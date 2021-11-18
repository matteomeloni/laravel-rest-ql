<?php

namespace Matteomeloni\LaravelRestQl;

use Illuminate\Support\ServiceProvider;

class LaravelRestQlServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'matteomeloni');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'matteomeloni');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-rest-ql.php', 'laravel-rest-ql');

        // Register the service the package provides.
        $this->app->singleton('laravel-rest-ql', function ($app) {
            return new LaravelRestQl;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-rest-ql'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-rest-ql.php' => config_path('laravel-rest-ql.php'),
        ], 'laravel-rest-ql.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/matteomeloni'),
        ], 'laravel-rest-ql.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/matteomeloni'),
        ], 'laravel-rest-ql.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/matteomeloni'),
        ], 'laravel-rest-ql.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
