<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            'App\Contracts\ISupervisor', function ($app) {
                return new \App\Services\Supervisor(new \PhpXmlRpc\Client(env('XML_RPC_SERVER')));
            }
        );
    }
}
