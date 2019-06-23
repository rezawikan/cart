<?php

namespace App\Http\Controllers\PaymentMethods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Pattern\Cart\Payment\Payment;
use App\Pattern\Cart\Payments\Gateway;
use App\Models\PaymentMethod;
use App\Http\Requests\PaymentMethods\PaymentMethodStoreRequest;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth:api']);
        // $this->gateway = $gateway;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return PaymentMethodResource::collection($request->user()->paymentMethods);
        return PaymentMethodResource::collection(PaymentMethod::all());
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
    public function store(PaymentMethodStoreRequest $request)
    {
        // $card = $this->gateway->withUser($request->user())
        //      ->createCustomer()
        //      ->addCard($request->token);
        //
        //      return new PaymentMethodResource($card);
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
