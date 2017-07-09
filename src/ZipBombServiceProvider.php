<?php

namespace AdrianMejias\ZipBomb;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use AdrianMejias\ZipBomb\Exceptions\InvalidConfiguration;

class ZipBombServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $source = realpath(__DIR__.'/../config/zipbomb.php');
        
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('zipbomb.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('zipbomb');
        }

        $this->mergeConfigFrom($source, 'zipbomb');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('zipbomb', function (Container $app) {
            $config = $app['config']['zipbomb'];
            
            $this->guardAgainstInvalidConfiguration($config);

            return new ZipBomb($config);
        });

        $this->app->alias('zipbomb', ZipBomb::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): Array
    {
        return [
            'zipbomb',
        ];
    }

    /**
     * Check for invalid configuration.
     */
    protected function guardAgainstInvalidConfiguration(Array $config = null)
    {
        if (empty($config['agents'])) {
            throw InvalidConfiguration::agentsNotSpecified();
        }

        if (empty($config['paths'])) {
            throw InvalidConfiguration::pathsNotSpecified();
        }

        if (! $this->createOrFail($config['zip_bomb_file'])) {
            throw InvalidConfiguration::zipDoesNotWriteable($config['zip_bomb_file']);
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