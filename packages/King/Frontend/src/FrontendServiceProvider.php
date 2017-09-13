<?php

namespace King\Frontend;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Models\User;
use Validator;

class FrontendServiceProvider extends ServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        
        //Load helpers
        $this->loadHelpers();
        
        // Load views.
        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'frontend');

        // Load translation.
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'frontend');

        // Setup routes.
        $this->setupRoutes($this->app->router);

        // Merge config.
        $this->mergeConfigFrom(__DIR__ . '/../config/frontend.php', 'frontend');

        // Publish assets.
        $this->publishes([
            __DIR__ . '/../public' => public_path('packages/king/frontend'),
        ], 'public');
        
        $this->customValidation();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->registerFrontend();
        config(['../config/frontend.php']);
    }
    
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router) {
        $router->group(['namespace' => 'King\Frontend\Http\Controllers'], function($router) {
            require __DIR__ . '/../routes/routes.php';
        });
    }
    
    protected function loadHelpers() {
        Include_once realpath(__DIR__ . '/support/helpers.php');
    }
    
    private function registerFrontend() {
        $this->app->bind('frontend', function($app) {
            return new Frontend($app);
        });
    }
    
    protected function customValidation() {
        Validator::extend('activated', function ($attribute, $value, $parameters, $validator) {
            $user = User::where('email', $value)->first();
            
            if (null === $user) {
                return false;
            }
            
            return $user->activated;
        });
        
        Validator::replacer('activated', function ($message, $attribute, $rule, $parameters) {
            return _t('auth.email.activated');
        });
    }
}
