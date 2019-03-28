<?php

namespace charlieuki\ReceiptPrinter;

use Illuminate\Support\ServiceProvider;

class ReceiptPrinterServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'charlieuki');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'charlieuki');
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
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/receiptprinter.php', 'receiptprinter');

        // Register the service the package provides.
        $this->app->singleton('receiptprinter', function ($app) {
            return new ReceiptPrinter;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['receiptprinter'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/receiptprinter.php' => config_path('receiptprinter.php'),
        ], 'receiptprinter.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/charlieuki'),
        ], 'receiptprinter.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/charlieuki'),
        ], 'receiptprinter.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/charlieuki'),
        ], 'receiptprinter.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
