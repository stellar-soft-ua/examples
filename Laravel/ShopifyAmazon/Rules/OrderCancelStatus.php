<?php

namespace App\Rules;

use App\Models\Amazon\AmazonOrder;
use Illuminate\Contracts\Validation\Rule;

class OrderCancelStatus implements Rule
{

    public function passes($attribute, $value)
    {
        $order = AmazonOrder::query()->where('amazon_id', $value)->first();

        if (!in_array($order->status,
            [AmazonOrder::STATUS_PENDING_AVAILABILITY, AmazonOrder::STATUS_PENDING, AmazonOrder::STATUS_UNSHIPPED])
        ) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Incorrect status to cancel order';
    }
}
