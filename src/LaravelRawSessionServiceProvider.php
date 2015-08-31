<?php namespace STS\Session;

use Illuminate\Support\ServiceProvider;
use Session;

class LaravelRawSessionServiceProvider extends ServiceProvider {
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['session']->extend('raw', function($app)
		{
			return new RawSessionHandler($app['config']->get("session.namespace"));
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}
}