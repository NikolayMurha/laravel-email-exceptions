<?php

namespace Abrigham\LaravelEmailExceptions;

use Illuminate\Support\ServiceProvider;

class EmailExceptionsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'laravel-email-exceptions');
        $app = app();
        $this->publishes([
            __DIR__ . '/config/laravel-email-exceptions.php' => $app->configPath('laravel-email-exceptions.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/views' => $app->resourcePath('views/vendor/laravel-email-exceptions')// resource_path('views/vendor/laravel-email-exceptions'),
        ], 'views');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/laravel-email-exceptions.php',
            'laravel_email_exceptions'
        );
    }
}
