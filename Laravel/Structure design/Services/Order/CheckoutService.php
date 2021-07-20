<?php

namespace App\Services\Order;

use App\Contracts\Order\Cart;
use App\Contracts\Order\Checkout;

class CheckoutService implements Checkout
{
    /**
     * Returns the cart
     *
     * @return null
     */
    public function getCart()
    {
        //
    }

    /**
     * Set the cart for the checkout
     *
     * @param Cart $cart
     */
    public function setCart(Cart $cart)
    {
        //
    }

    /**
     * Returns the shipping address
     *
     * @return Address
     */
    public function getShippingAddress(): Address
    {
        //
    }

    /**
     * Set the shipping address
     *
     * @param Address $address
     *
     * @return void
     */
    public function setShippingAddress(Address $address): void
    {
        //
    }

    /**
     * Get the discount
     *
     * @return Discount
     */
    public function getDiscountCode(): Discount
    {
        //
    }

    /**
     * Set the discount
     *
     * @param Discount $discount
     *
     * @return bool
     */
    public function setDiscountCode(Discount $discount): bool
    {
        //
    }

    /**
     * Get the payment method
     *
     * @return Payment
     */
    public function getPaymentMethod(): Payment
    {
        //
    }

    /**
     * Set the payment method
     *
     * @param Payment $payment
     *
     * @return bool
     */
    public function setPaymentMethod(Payment $payment): bool
    {
        //
    }

    /**
     * Process the checkout
     *
     * @return bool
     */
    public function checkout(): bool
    {
        //
    }

    /**
     * Cancel the checkout
     *
     * @return null
     */
    public function cancel()
    {
        //
    }
}