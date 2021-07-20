<?php

namespace App\Traits;

use App\Services\Order\CartService;

trait Orderable
{
    /**
     * Add product to the cart
     *
     * @return Cart
     */
    public function addToCart()
    {
        return app(CartService::class)->add($this);
    }
}