<?php

namespace App\Http\Controllers\Location;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Scoping\Scopes\All\NameScope;
use App\Http\Resources\ProvinceResource;
use App\Http\Requests\Location\ProvinceStoreRequest;

class ProvinceController extends Controller
{
    /**
     * __construct.
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * scope for filters.
     *
     * @return \App\Scoping\Scopes\All\NameScope
     */
    protected function scopes()
    {
        return [
          'name'    => new NameScope()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\ProvinceResource
     */
    public function index()
    {
        return ProvinceResource::collection(Province::withScopes($this->scopes())->get());
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
     * @param  \App\Http\Requests\Location\ProvinceStoreRequest  $request
     * @return \App\Http\Resources\ProvinceResource
     */
    public function store(ProvinceStoreRequest $request)
    {
        return new ProvinceResource(Province::create($request->all()));
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
     * @return \App\Http\Resources\ProvinceResource
     */
    public function update(Request $request, $id)
    {
        $province = Province::findOrFail($id);
        return new ProvinceResource($province->update($rquest->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \App\Http\Resources\ProvinceResource
     */
    public function destroy($id)
    {
        $province = Province::findOrFail($id);
        return new ProvinceResource($province->delete());
    }
}
