<?php

namespace App\Providers;

use App\Interfaces\Auth\UserInterface;
use App\Interfaces\BrandInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\OrderItemInterface;
use App\Interfaces\ProductImageInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductSizeInterface;
use App\Interfaces\TempImageInterface;
use App\Repositories\Auth\UserRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductImageRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductSizeRepository;
use App\Repositories\TempImageRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(ProductImageInterface::class, ProductImageRepository::class);
        $this->app->bind(ProductSizeInterface::class, ProductSizeRepository::class);
        $this->app->bind(TempImageInterface::class, TempImageRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(OrderItemInterface::class, OrderItemRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
