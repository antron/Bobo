<?php

namespace Antron\Bobo;

use Illuminate\Support\ServiceProvider;

class AranaServiceProvider extends ServiceProvider
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
        $this->app['bobo'] = $this->app->share(function($app)
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
