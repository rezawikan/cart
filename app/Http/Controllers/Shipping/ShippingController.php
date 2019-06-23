<?php

namespace App\Http\Controllers\Shipping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shipping\Shipping as Sender;
use App\Http\Resources\ShippingResource;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        // return 'asd';
        $origin = (new Sender('international'))->shipping->getOrigin(['id' => 1]);

        // dd($origin);
        $origin = $origin['rajaongkir']['results']['city_id'];

        $destination = (new Sender('international'))->shipping->getDestination(['id' => 152]);
        $destination = $destination['rajaongkir']['results']['country_id'];

        // return $destination;

        $cost = (new Sender('international'))->shipping->getCost(
          [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => 1000
          ]
        );

        return $cost;
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
