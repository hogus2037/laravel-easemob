<?php

namespace Hogus\LaravelEasemob;

use Illuminate\Support\ServiceProvider;

class EasemobServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/config.php';
        $this->publishes([$configPath => config_path('laravel-easemob.php')], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Easemob::class, function ($app) {
            return new Easemob($app->config->get('laravel-easemob', []));
        });
        $this->app->alias(Easemob::class, 'easemob');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Easemob::class, 'easemob'];
    }
}
