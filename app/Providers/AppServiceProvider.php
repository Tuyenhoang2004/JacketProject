<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Catalog;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

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
        // Lấy danh sách catalog và chia sẻ với các view
        $list_catalog = Catalog::all();
        View::share('list_catalog', $list_catalog);

        // Lắng nghe các truy vấn SQL và ghi log
        DB::listen(function ($query) {
            \Log::info($query->sql);
            \Log::info($query->bindings);
        });
    }
}
