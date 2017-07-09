<?php

namespace AdrianMejias\ZipBomb;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use AdrianMejias\ZipBomb\Exceptions\InvalidConfiguration;

class ZipBombServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/zipbomb.php' => config_path('zipbomb.php'),
            ], 'config');
        // } elseif ($this->app instanceof LumenApplication) {
        //     $this->app->configure('zipbomb');
        // }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/zipbomb.php', 'zipbomb');

        $config = config('zipbomb');

        $this->app->bind(ZipBomb::class, function ($app) use ($config) {
            $this->guardAgainstInvalidConfiguration($config);

            return new ZipBomb($config);
        });

        $this->app->alias(ZipBomb::class, 'laravel-zipbomb');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            'laravel-zipbomb',
        ];
    }

    /**
     * Check for invalid configuration.
     *
     * @param string[]|null
     *
     * @throws \AdrianMejias\ZipBomb\Exceptions\InvalidConfiguration
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
     * 
     * @param string
     * 
     * @return boolean
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
