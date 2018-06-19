<?php

namespace Ngmedia\FormCinch;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Ngmedia\Formcinch\Middleware\FormCinchAdminMiddleware;

class FormCinchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
	    include __DIR__.'/routes/web.php';
	    include __DIR__.'/routes/custom.php';
	    $this->loadMigrationsFrom(__DIR__.'/migrations');

	    $this->publishes([
		    __DIR__.'/views' => resource_path('views/vendor/formcinch'),
            __DIR__.'/public' => public_path('vendor/formcinch'),
        ], 'public');

	    // use the vendor configuration file as fallback
	    $this->mergeConfigFrom(
		    __DIR__.'/config/formcinch/formcinch.php', 'formcinch.formcinch'
	    );

	    $this->loadTranslationsFrom( __DIR__.'/lang/captcha.php', 'Ngmedia\FormCinch\Lang');

	    $this->registerMiddlewareGroup();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
	    $this->app->make('Ngmedia\FormCinch\Controllers\FormCinchController');
	    $this->app->make('Ngmedia\FormCinch\Controllers\FormCinchSubmissionController');
	    $this->loadViewsFrom(__DIR__.'/views', 'formcinch');

        // register the helper functions
        $this->loadHelpers();

    }

    /**
     * Load the Backpack helper methods, for convenience.
     */
    public function loadHelpers()
    {
        require_once __DIR__.'/helpers.php';
    }

    /**
     * Registers the form cinch middleware
     */
	public function registerMiddlewareGroup()
	{
		$middleware_key = config('formcinch.formcinch.middleware_key');
		$middleware_class = config('formcinch.formcinch.middleware_class');

		if (!is_array($middleware_class)) {
			app()->router->pushMiddlewareToGroup($middleware_key, $middleware_class);

			return;
		}

		foreach ($middleware_class as $middleware_class) {
			app()->router->pushMiddlewareToGroup($middleware_key, $middleware_class);
		}
	}
}
