<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAddressRequest;
use App\Http\Requests\Admin\UpdateAddressRequest;
use App\Http\Resources\AddressCollection;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CountryResource;
use App\Models\Address;
use App\Models\Card;
use App\Models\Country;

class CardAddressController extends Controller
{

    public function index()
    {
        return AddressCollection::make(auth()->user()->client->addresses()->paginate());
    }

    /**
     * Get card
     *
     * @param int $id
     * @return AddressResource|\Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $client = auth()->user()->client;
        $address = Address::findOrFail($id);

        if ($address->client_id !== $client->id) {
            return $this->apiResponse('It is not your address!', 403);
        }

        $countries = Country::active()->orderBy('featured','desc')->get();

        $currency = $client->midCurrency;
        return AddressResource::make($address)->additional([
            'message' => 'Address item!',
            'countries' =>  CountryResource::collection($countries),
            'currency' => ($currency) ? [
                'code' => $currency->currency_code, 'symbol' => $currency->symbol
            ] : [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAddressRequest $request
     * @return AddressResource
     */
    public function store(StoreAddressRequest $request)
    {
        $client = auth()->user()->client;

        $data = $request->validated();
        $data['client_id'] = $client->id;

        $address = Address::create($data);

        $countries = Country::active()->orderBy('featured','desc')->get();

        $currency = $client->midCurrency;
        return AddressResource::make($address->refresh())->additional([
            'message' => 'Address created successfully!',
            'countries' =>  CountryResource::collection($countries),
            'currency' => ($currency) ? [
                'code' => $currency->currency_code, 'symbol' => $currency->symbol
            ] : [],
        ]);
    }

    public function update(UpdateAddressRequest $request, int $id)
    {
        $client = auth()->user()->client;
        $address = Address::findOrFail($id);

        if ($address->client_id !== $client->id) {
            return $this->apiResponse('It is not your address!', 403);
        }

        $address->fill($request->validated());
        $address->save();

        $countries = Country::active()->orderBy('featured','desc')->get();
        $currency = $client->midCurrency;
        return AddressResource::make($address->refresh())->additional([
            'message' => 'Address updated successfully!',
            'countries' =>  CountryResource::collection($countries),
            'currency' => ($currency) ? [
                'code' => $currency->currency_code, 'symbol' => $currency->symbol
            ] : [],
        ]);
    }

    public function destroy(int $id)
    {
        $address = Address::findOrFail($id);
        $client = auth()->user()->client;

        if ($address->client_id !== $client->id) {
            return $this->apiResponse(__('It is not your address!'), 403);
        }

        $card = Card::where('address_id', $id)->where('client_id', $client->id)->first();
        if ($card) {
            return $this->apiResponse(__('Address is using!'), 403);
        }

        $address->forceDelete();

        return $this->apiResponse('Address item deleted!');
    }
}
