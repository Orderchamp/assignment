<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->bind(
            CouponRepositoryInterface::class,
            CouponRepository::class,
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class,
        );

        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class,
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class,
        );
    }
}
