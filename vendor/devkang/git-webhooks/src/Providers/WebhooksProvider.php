<?php

namespace DevKang\Git\Providers;

use Devkang\Git\Http\Controllers\WebhooksController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WebhooksProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => config_path('git.php')], 'config');
        $this->mergeConfigFrom($path, 'git');
        //

        Route::prefix('git')
            ->namespace('DevKang\Git\Http\Controllers')
            ->group(function () {
                Route::post('webhooks', "WebhooksController@index");
            });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
