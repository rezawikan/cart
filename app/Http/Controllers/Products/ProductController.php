<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pattern\Product\HandleProduct;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductCreateResource;
use App\Http\Resources\ProductEditResource;
use App\Scoping\Scopes\Products\CategoryScope;
use App\Scoping\Scopes\Products\NameScope;
use App\Scoping\Scopes\Products\PopularScope;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function scopes()
    {
        return [
          'slug'    => new CategoryScope(),
          'name'    => new NameScope(),
          'popular' => new PopularScope()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::LatestOrder()->withScopes($this->scopes())->paginate(12)->appends($request->except('page'));

        return ProductIndexResource::collection($products);
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
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->all());
        return new ProductCreateResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load(['variations.type', 'variations.stock']);

        return new ProductEditResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->load(['variations.type', 'variations.stock','variations.product']);

        return new ProductEditResource($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, HandleProduct $handle)
    {
        $product->update($request->except('variations','delete'));

        $handle->setRequest($request);

        $handle->sync();

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
