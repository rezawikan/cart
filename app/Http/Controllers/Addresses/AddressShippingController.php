<?php

namespace App\Http\Controllers\Addresses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Http\Resources\ShippingMethodResource;

class AddressShippingController extends Controller
{
    public function action(Address $address)
    {
        return ShippingMethodResource::collection($address->subdistrict->shippingMethods);
    }
}
