<?php

namespace App\Traits;

use App\Services\WalletService;

trait HasWallet
{
    /**
     * @param $amount
     */
    public function increaseBalance($amount) : void
    {
        app(WalletService::class)->increaseBalance($this->wallet, $amount);
    }

    /**
     * @param $amount
     *
     * @return bool
     */
    public function reduceBalance($amount) : bool
    {
        return app(WalletService::class)->reduceBalance($this->wallet, $amount);
    }

    /**
     * @param $amount
     * @return bool
     */
    public function canPay($amount) : bool
    {
        return app(WalletService::class)->canPay($this->wallet, $amount);
    }

    /**
     * @param $amount
     *
     * @return void
     */
    public function createWallet($amount)
    {
        app(WalletService::class)->createWallet($this, $amount);
    }

    /**
     * @return mixed
     */
    public function getBalanceAttribute()
    {
        return app(WalletService::class)->getBalance($this->wallet);
    }
}