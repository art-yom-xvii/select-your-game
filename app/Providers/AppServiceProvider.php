<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');

        // Share cart item count with all views
        View::composer('*', function ($view) {
            $cartItemCount = 0;
            if (session()->has('cart_session_id')) {
                $cart = Cart::where('session_id', session('cart_session_id'))->first();
                if ($cart) {
                    $cartItemCount = $cart->items()->sum('quantity');
                }
            }
            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
