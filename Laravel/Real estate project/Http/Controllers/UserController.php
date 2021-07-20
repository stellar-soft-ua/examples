<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Models\Role;
use App\Models\User;
use App\Models\Verification;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Verification
     */
    protected $verification;

    /**
     * UserController constructor.
     *
     * @param User $user
     * @param Verification $verification
     */
    public function __construct(User $user, Verification $verification)
    {
        $this->user = $user;
        $this->verification = $verification;
    }

    public function transactions()
    {
        return view('customer.transactions');
    }

    public function billing()
    {
        return view('customer.billing', [

        ]);
    }
}
