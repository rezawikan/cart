<?php

namespace App\Http\Controllers\Shipping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shipping\Shipping as Sender;
use App\Http\Resources\ShippingResource;

class ShippingHandlerController extends Controller
{
    public $provider;

    public function setProvider(string $provider)
    {
        $this->provider = new Sender($provider);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOri()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
