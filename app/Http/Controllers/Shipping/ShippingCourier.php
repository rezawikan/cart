<?php

namespace App\Http\Controllers\Shipping;

use App\Models\Subdistrict;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingCourierResource;

class ShippingCourier extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

          $shippingCourier = Subdistrict::with([
          'shippingMethods',
          'city',
          'city.province'
          ])
          ->OrderByProvince()
          ->paginate(12);

        return ShippingCourierResource::collection($shippingCourier);
    }

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
        $shippingMethod = ShippingMethod::create($request->except('subdistrict_id'));
        $subdistrict = Subdistrict::find($request->subdistrict_id);
        $subdistrict->shippingMethods()->sync([$shippingMethod->id]);
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
