<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceResource;
use App\Models\Province;

class ProvinceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:api']);
    // }

    public function index()
    {
        return ProvinceResource::collection(Province::get());
    }
}
