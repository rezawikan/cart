<?php

namespace App\Http\Controllers\Cashflow;

use App\Models\Cashflow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashflowResource;

class CashflowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $cashflow = Cashflow::latest()->paginate(12);

      return CashflowResource::collection($cashflow);
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

        $latest = Cashflow::latest()->first();
        if ($request->type == 'debit') {
            $total = $latest->total + $request->amount;
        } else {
            $total = $latest->total - $request->amount;
        }

        Cashflow::create([
          'type'   => $request->type,
          'info'   => $request->info,
          'amount' => $request->amount,
          'total'  => $total
        ]);
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
    public function update(Request $request, Cashflow $cashflow)
    {
        $cashflow->update($request->all());
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
