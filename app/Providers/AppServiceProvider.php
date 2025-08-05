<?php

namespace App\Providers;

use App\Interfaces\BrandInterface;
use App\Interfaces\CategoryInterface;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
