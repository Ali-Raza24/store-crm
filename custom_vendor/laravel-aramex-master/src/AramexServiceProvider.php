<?php

namespace ExtremeSa\Aramex;

use ExtremeSa\Aramex\Aramex as AramexClass;
use Illuminate\Support\ServiceProvider;

class AramexServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    public function register()
    {
        $this->app->singleton(Aramex::class, function () {
            return new AramexClass($this->app);
        });
    }
}
