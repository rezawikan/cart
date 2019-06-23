<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Resources\CityResource;
use App\Scoping\Scopes\Address\ProvinceScope;

class CityController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function scopes()
    {
        return [
          'province'    => new ProvinceScope(),
        ];
    }

    public function index(Request $request)
    {
        $city = City::withScopes($this->scopes())->get();
        return CityResource::collection($city);
    }
}
