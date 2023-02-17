<?php

namespace App\Providers;

use App\Domain\Cart\Repositories\CartItemRepository;
use App\Domain\Cart\Repositories\CartItemRepositoryInterface;
use App\Domain\Cart\Services\CartItemService;
use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\DiscountCode\Repositories\DiscountCodeRepository;
use App\Domain\DiscountCode\Repositories\DiscountCodeRepositoryInterface;
use App\Domain\Order\Repositories\OrderItemRepository;
use App\Domain\Order\Repositories\OrderItemRepositoryInterface;
use App\Domain\Order\Repositories\OrderRepository;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Order\Services\OrderService;
use App\Domain\Order\Services\OrderServiceInterface;
use App\Domain\Product\Repositories\ProductRepository;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\Services\ProductService;
use App\Domain\Product\Services\ProductServiceInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->bind(CartItemRepositoryInterface::class, CartItemRepository::class);
        $this->app->bind(CartItemServiceInterface::class, CartItemService::class);

        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);

        $this->app->bind(DiscountCodeRepositoryInterface::class, DiscountCodeRepository::class);
        $this->app->bind(DiscountCodeServiceInterface::class, DiscountCodeService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
