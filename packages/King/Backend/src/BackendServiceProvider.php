<?php

namespace King\Backend;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class BackendServiceProvider extends ServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        
        //Load helpers
        $this->loadHelpers();
        
        // Load views.
        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'backend');

        // Load translation.
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'backend');

        // Setup routes.
        $this->setupRoutes($this->app->router);

        // Merge config.
        $this->mergeConfigFrom(__DIR__ . '/../config/backend.php', 'backend');

        // Publish assets.
        $this->publishes([
            __DIR__ . '/../public' => public_path('packages/king/backend'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->registerBackend();
        config(['../config/backend.php']);
    }
    
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router) {
        $router->group(['namespace' => 'King\Backend\Http\Controllers'], function($router) {
            require __DIR__ . '/../routes/web.php';
        });
    }
    
    protected function loadHelpers() {
        Include_once realpath(__DIR__ . '/support/helpers.php');
    }
    
    private function registerBackend() {
        $this->app->bind('backend', function($app) {
            return new Backend($app);
        });
    }
}
