<?php

namespace Antron\Bobo;

use Illuminate\Support\ServiceProvider;

class BoboServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
	$this->app->singleton('bobo',function($app)
	{
		return new Bobo;
	});
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bobo'];
    }

}
