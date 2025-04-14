<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Catalog;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $list_catalog = Catalog::all();
        View::share('list_catalog', $list_catalog);
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
    }

}
