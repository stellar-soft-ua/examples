<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($transaction){
                return [
                    'id' => $transaction->id,
                    'uuid' => $transaction->uuid,
                    'amount' => $transaction->amount,
                    'type' => [
                        'label' => $transaction->getTypeLabel(),
                        'key' => Str::slug($transaction->getTypeLabel())
                    ],
                    'created_at' => $transaction->created_at->toDateTimeString()
                ];
            }),
        ];
    }
}
