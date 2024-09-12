<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Pengajuanizin;

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
    public function boot()
{
    // Share pending count to all views
    View::composer('*', function ($view) {
        $pendingCount = Pengajuanizin::where('status_approved', '0')->count();
        $view->with('pendingCount', $pendingCount);
    });
}
}