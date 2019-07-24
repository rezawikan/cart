<?php

namespace App\Http\Controllers\Shipping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shipping\Shipping as Sender;
use App\Http\Resources\ShippingResource;
use App\Http\Resources\ShipmentHanlderResource;


class ShippingHandlerController extends Controller
{
    public $provider;

    public function setProvider(string $provider)
    {
        $this->provider = new Sender($provider);
    }

    public function provinces(Request $request)
    {
        if (empty($request->type)) {
            return [];
        }
        $this->setProvider($request->type);
        return new ShipmentHanlderResource($this->provider->shipping->getProvince($request->except('type')));
    }

    public function cities(Request $request)
    {
        if (empty($request->type)) {
            return [];
        }
        $this->setProvider($request->type);
        return new ShipmentHanlderResource($this->provider->shipping->getCity($request->except('type')));
    }

    public function subdistricts(Request $request)
    {
        if (empty($request->type)) {
            return [];
        }
        $this->setProvider($request->type);
        return new ShipmentHanlderResource($this->provider->shipping->getSubdistrict($request->except('type')));
    }

    public function cost(Request $request)
    {
        if (empty($request->type)) {
            return [];
        }

        $this->setProvider($request->type);
        return new ShipmentHanlderResource($this->provider->shipping->getCost($request->except('type')));
    }

    public function index()
    {
        // International
        // Pilihan Origin
        // $origin = (new Sender('international'))->shipping->getOrigin();
        //
        // // Origin Telah di Pilih
        // $originID = (new Sender('international'))->shipping->getOrigin(['id' => 1]);
        //
        // // Hasil Origin
        // $originID = $origin['rajaongkir']['results']['city_id'];
        //
        // // Pilihan Destinasi
        // $destination = (new Sender('international'))->shipping->getDestination();
        //
        // // Destinasi Telah di pilih
        // $destinationID = (new Sender('international'))->shipping->getDestination(['id' => 152]);
        //
        // // Hasil Destinasi
        // $destinationID = $destinationID['rajaongkir']['results']['country_id'];
        //
        //
        // // Menentukan Harga
        // $cost = (new Sender('international'))->shipping->getCost(
        //   [
        //     'origin' => $origin,
        //     'destination' => $destination,
        //     'weight' => 1000
        //   ]
        // );
        //
        // return $cost;



        // National
        // Pilihan Provonsi
        // return $province = (new Sender('national'))->shipping->getProvince();

        // Provinsi Telah di pilih
        $provinceID = (new Sender('national'))->shipping->getProvince(['id' => 1]);
        //
        // // Hasil Origin
        $provinceID = $provinceID['rajaongkir']['results']['province_id'];
        //
        // // Pilihan Kota
        $city = (new Sender('national'))->shipping->getCity();
        //
        // // Pilihan Kota Sesuai Provinsi ID
        $cityID = (new Sender('national'))->shipping->getCity(['province' => $provinceID]);

        // Pilihan Kabupaten
        // $cityID = $cityID['rajaongkir']['results'];

        $city = (new Sender('national'))->shipping->getCity(['province' => $provinceID, 'id' => 114]);
        //
        // // Hasil Kota
        $cityID = $city['rajaongkir']['results']['city_id'];

        // Pilihan Subdistrict
        $Subdistrict = (new Sender('national'))->shipping->getSubdistrict(['city' => $cityID]);

        return $Subdistrict = (new Sender('national'))->shipping->getSubdistrict(['city' => $cityID, 'id' => '1574']);
    }
}
