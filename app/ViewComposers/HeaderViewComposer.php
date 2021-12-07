<?php

namespace App\ViewComposers;

use App\Includes\Cart;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class HeaderViewComposer
{
    public function compose(View $view)
    {
        $cartQtySum = Cart::getCartQtySum();

        $cartCount = $cartQtySum > 99 ? '99+' : strval($cartQtySum);

        $menu = Cache::remember('HeaderMenu', env("CACHE_TIME", 0), function () {
            return Menu::where('location', 'header')->with('items')->first();
        });

        $view->with('menu', $menu);
        $view->with('cartCount', $cartCount);
    }
}