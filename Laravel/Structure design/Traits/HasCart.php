<?php

namespace App\Traits;

use App\Services\Order\CartService;

trait HasCart
{
    /**
     * Return the cart
     *
     * @return Cart
     */
    public function getCart()
    {
        return app(CartService::class)->getCart();
    }
}