<?php

namespace romanzipp\EnvDiff\Providers;

use Illuminate\Support\ServiceProvider;
use romanzipp\EnvDiff\Console\Commands\DiffEnvFiles;

class EnvDiffProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/../env-diff.php' => config_path('env-diff.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DiffEnvFiles::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/../env-diff.php', 'env-diff'
        );
    }
}
