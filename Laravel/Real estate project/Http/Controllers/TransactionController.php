<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\UserDoesNotHaveWallet;
use App\Http\Resources\TransactionCollection;
use App\Models\User;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * @param User $user
     * @return TransactionCollection
     * @throws UserDoesNotHaveWallet
     */
    public function list(User $user) : TransactionCollection
    {
        if(! $user->isCustomer()) {
            throw new UserDoesNotHaveWallet('This user does not have a wallet.');
        }

        $transactions = $user->wallet->transactions()
            ->latest()
            ->paginate(10);

        return new TransactionCollection($transactions);
    }
}
