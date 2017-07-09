<?php

namespace AdrianMejias\ZipBomb\Middleware;

use Closure;
use Illuminate\Http\Request;

class ZipBomb
{
    /**
     * The zipbomb instance.
     *
     * @var \AdrianMejias\ZipBomb\ZipBomb
     */
    protected $zipbomb;

    /**
     * A simple request.
     *
     * @var Request
     */
    protected $request;

    /**
     * A simple application.
     *
     * @var Application
     */
    protected $app;

    /**
     * A simple agent.
     *
     * @var string
     */
    protected $agent;

    /**
     * Create a new zipbomb middleware class.
     *
     * @param \AdrianMejias\ZipBomb\ZipBomb $zipbomb
     *
     * @return void
     */
    public function __construct(ZipBomb $zipbomb)
    {
        $this->zipbomb = $zipbomb;

      // get user-agent
      $this->agent = strtolower($this->request->header('User-Agent'));
    }

    /**
     * Prepare the client to recieve GZIP data. This will not be suspicious
     * since most web servers use GZIP by default.
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldBomb()) {
            $contents = $this->zipbomb->getZipBombFileContent();

            // turn off output buffering
            if (ob_get_level()) {
                ob_end_clean();
            }

            // send the gzipped file to the client
            return response($contents, 200)->withHeaders([
                'Content-Encoding' => 'gzip',
                'Content-Length'   => $this->zipbomb->getZipBombFileSize(),
            ]);
        }

        return $next($response);
    }

    /**
     * @return string|bool
     */
    protected function shouldBomb(Request $request)
    {
        // check user-agents
        foreach ($this->zipbomb->getAgents() as $agent) {
            if (! empty($this->agent) && strpos($this->agent, $agent) !== false) {
                return true;
            }
        }

        // check paths
        foreach ($this->zipbomb->getPaths() as $path) {
            if ($this->request->is($path)) {
                return true;
            }
        }

        return false;
    }
}
