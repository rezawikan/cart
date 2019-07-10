<?php

namespace App\Http\Controllers\Location;use Illuminate\Http\Request;

use App\Models\Subdistrict;
use App\Http\Controllers\Controller;
use App\Scoping\Scopes\All\NameScope;
use App\Scoping\Scopes\Address\CityScope;
use App\Http\Resources\SubdistrictResource;

class SubdistrictController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function scopes()
    {
        return [
          'city'    => new CityScope(),
          'name'    => new NameScope()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $scope = Subdistrict::withScopes($this->scopes());

        if ($request->pagination == true) {
            $subdistrict = $scope->paginate(12);
        } else {
            $subdistrict = $scope->limit(50)->get();
        }

        return SubdistrictResource::collection($subdistrict);
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
        return new SubdistrictResource(Subdistrict::create($request->all()));
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
