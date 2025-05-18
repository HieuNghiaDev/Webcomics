<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\TheLoai;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Chia sẻ biến $theLoai cho tất cả các view
        View::composer('*', function ($view) {
            $theLoai = TheLoai::all();
            $view->with('theLoai', $theLoai);
        });

        // Chia sẻ thông tin người dùng đăng nhập (nếu cần)
        View::composer('*', function ($view) {
            $view->with('currentUser', auth()->user());
        });
    }
}