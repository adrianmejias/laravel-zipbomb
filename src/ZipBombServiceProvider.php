<?php

namespace AdrianMejias\ZipBomb;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use AdrianMejias\ZipBomb\ZipBomb as ZipBombContract;
use AdrianMejias\ZipBomb\Exceptions\InvalidConfiguration;
use AdrianMejias\ZipBomb\Middleware\ZipBomb as ZipBombMiddleware;

class ZipBombServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->source = __DIR__.'/../config/zipbomb.php';

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/zipbomb.php' => config_path('zipbomb.php'),
            ], 'config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('zipbomb');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/zipbomb.php', 'zipbomb');

        $config = config('zipbomb');

        $this->app->bind('zipbomb', function ($app) use ($config) {
            $this->guardAgainstInvalidConfiguration($config);

            return new ZipBomb($config);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            'zipbomb',
        ];
    }

    /**
     * Check for invalid configuration.
     */
    protected function guardAgainstInvalidConfiguration(array $config = null)
    {
        if (empty($config['agents'])) {
            throw InvalidConfiguration::agentsNotSpecified();
        }

        if (empty($config['paths'])) {
            throw InvalidConfiguration::pathsNotSpecified();
        }

        if (! $this->createOrFail($config['zip_bomb_file'])) {
            throw InvalidConfiguration::zipBombFileNotWriteable($config['zip_bomb_file']);
        }

        if (! file_exists($config['zip_bomb_file'])) {
            throw InvalidConfiguration::zipBombFileDoesNotExist($config['zip_bomb_file']);
        }
    }

    /**
     * Check for zip bomb file.
     */
    private function createOrFail($zip_bomb_file)
    {
        if (! file_exists($zip_bomb_file)) {
            $output = shell_exec(`dd if=/dev/zero bs=1M count=10240 | gzip > ${file} 2>&1 1> /dev/null`);

            Log::info('Create Zip Bomb File: ', [
                'file'   => $zip_bomb_file,
                'output' => $output,
            ]);

            return file_exists($zip_bomb_file);
        }

        return true;
    }
}
