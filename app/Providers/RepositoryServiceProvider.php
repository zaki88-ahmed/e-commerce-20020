<?php

namespace App\Providers;

use App\Http\Interfaces\SystemAnswerInterface;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            'App\Http\Interfaces\ProductInterface',
            'App\Http\Repositories\ProductRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\BrandInterface',
            'App\Http\Repositories\BrandRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\StripeInterface',
            'App\Http\Repositories\StripeRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\CartInterface',
            'App\Http\Repositories\CarttRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\AuthInterface',
            'App\Http\Repositories\AuthRepository'
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
