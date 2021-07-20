<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

class WalletService
{
    /**
     * @param Wallet $wallet
     * @param $amount
     *
     * @return void
     */
    public function increaseBalance(Wallet $wallet, $amount) : void
    {
        $wallet->increment('amount', $amount);

        $this->addIncomeTransaction($wallet, $amount);
    }

    /**
     * @param Wallet $wallet
     * @param $amount
     *
     * @return bool
     */
    public function reduceBalance(Wallet $wallet, $amount) : bool
    {
        if($this->canPay($wallet, $amount)) {
            $wallet->decrement('amount', $amount);

            $this->addExpenseTransaction($wallet, $amount);

            return true;
        }

        return false;
    }

    /**
     * @param Wallet $wallet
     * @param $amount
     *
     * @return bool
     */
    public function canPay(Wallet $wallet, $amount) : bool
    {
        return $wallet->amount >= $amount;
    }

    /**
     * @param Wallet $wallet
     *
     * @return float
     */
    public function getBalance(?Wallet $wallet) : float
    {
        return $this->format($wallet->amount ?? 0);
    }

    /**
     * @param User $user
     * @param int $amount
     *
     * @return void
     */
    public function createWallet(User $user, $amount) : void
    {
        $user->wallet()->create(['amount' => $amount]);

        $this->addIncomeTransaction($user->wallet, $amount);
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     */
    public function addIncomeTransaction(Wallet $wallet, float $amount)
    {
        $this->createTransaction($wallet, $amount, Transaction::TYPE_INCOME);
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     */
    public function addExpenseTransaction(Wallet $wallet, float $amount)
    {
        $this->createTransaction($wallet, $amount, Transaction::TYPE_EXPENSE);
    }

    /**
     * @param Wallet $wallet
     * @param $amount
     * @param $type
     *
     * @return void
     */
    protected function createTransaction(Wallet $wallet, $amount, $type)
    {
        $wallet->transactions()->create([
            'amount' => $amount,
            'type' => $type,
        ]);
    }

    /**
     * @param float $amount
     *
     * @return float
     */
    protected function format(float $amount) : float
    {
        return round($amount, 0);
    }
}