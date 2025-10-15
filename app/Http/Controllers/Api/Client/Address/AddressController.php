<?php

namespace App\Http\Controllers\Api\Client\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Address\CreateAddressRequest;
use App\Http\Requests\Api\Client\Address\UpdateAddressRequest;
use App\Http\Resources\Order\Address\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        return AddressResource::collection(Address::where('client_id', auth()->user()->id)->get());
    }

    public function create(CreateAddressRequest $request)
    {
        $data = $request->validated();
        $data['client_id'] = auth()->user()->id;
        Address::create($data);

        return successResponse('تم بنجاح');
    }

    public function update(Address $address, UpdateAddressRequest $request)
    {
        $data = $request->validated();
        $address->update($data);

        return successResponse('تم بنجاح');
    }

    public function delete(Address $address)
    {
        $address->delete();

        return successResponse('تم بنجاح');
    }
}
