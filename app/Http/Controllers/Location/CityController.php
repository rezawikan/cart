<?php

namespace App\Http\Controllers\Location;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Scoping\Scopes\All\NameScope;
use App\Scoping\Scopes\Address\ProvinceScope;
use App\Http\Requests\Location\CitiesStoreRequest;

class CityController extends Controller
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
     * @return \App\Scoping\Scopes\Address\ProvinceScope
     */
    protected function scopes()
    {
        return [
          'province'    => new ProvinceScope(),
          'name'        => new NameScope()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\CityResource
     */
    public function index(Request $request)
    {
        $scope = City::withScopes($this->scopes());

        if ($request->pagination == true) {
            $cities = $scope->paginate(12);
        } else {
            $cities = $scope->limit(50)->get();
        }

        return CityResource::collection($cities);
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
     * @param  \App\Http\Requests\Location\CitiesStoreRequest  $request
     * @return \App\Http\Resources\CityResource
     */
    public function store(CitiesStoreRequest $request)
    {
        return new CityResource(City::create($request->all()));
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
     * @return \App\Http\Resources\CityResource
     */
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        return new CityResource($city->update($rquest->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \App\Http\Resources\CityResource
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        return new CityResource($city->delete());
    }
}
