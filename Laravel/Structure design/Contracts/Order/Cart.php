<?php


namespace App\Contracts\Order;


interface Cart
{
    /**
     * Returns the cart
     *
     * @return Cart|null
     */
    public function getCart();

    /**
     * Get list of the cart items
     *
     * @return ProductCollection
     */
    public function items(): ProductCollection;

    /**
     * Get list of the cart items
     *
     * @param Product $product
     *
     * @return void
     */
    public function add(Product $product): void;

    /**
     * Remove the product from the cart
     *
     * @param Product $product
     *
     * @return bool
     */
    public function remove(Product $product): bool;

    /**
     * Update cart data
     *
     * @param array $data
     *
     * @return void
     */
    public function update(array $data): void;

    /**
     * Destroy the cart
     *
     * @return void
     */
    public function destroy(): void;

    /**
     * Returns the total of the cart items
     *
     * @return int
     */
    public function total(): int;

    /**
     * Returns the total price of the cart
     *
     * @return float
     */
    public function totalPrice(): float;
}