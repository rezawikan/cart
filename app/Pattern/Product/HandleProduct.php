<?php

namespace App\Pattern\Product;

use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Models\Stock;

class HandleProduct
{

  protected $request;

  public function setRequest(Request $request) {
    $this->request = $request;
  }

  public function sync() {

    $this->deleteID($this->request->delete);

    $type = collect($this->request->variations)->map(function($variation){
      return $variation['name'];
    })->toArray();

    $temp = [];
    foreach ($this->request->variations as $key => $value) {
        $temp = array_merge($value['variations'], $temp);
    }

    foreach ($temp as $key => $data) {
      if ($this->hasID($data['id'])) {
          $this->updateData($data);
      } else {
          $this->createData($data);
      }
    }
  }

  //
  /**
   * Block comment
   *
   * @param type
   * @return void
   */
  public function deleteID(array $data) {
    $data = collect($data)->flatten()->all();
    if ($data == null) {
        return true;
    }

    return ProductVariation::whereIn('id', $data)->delete();
  }

    //
    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function hasID($data) {
      return $data != null ? true : false;
    }


    //
    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function updateData(array $data) {
      $variant = ProductVariation::find($data['id']);
      $variant->update([
        'product_id' => $data['product']['id'],
        'product_variation_type_id' => $data['type']['id'],
        'price' => $data['price'],
        'base_price' => $data['base_price'],
        'name' => $data['name'],
        'weight' => $data['weight'],
      ]);

      if ($variant->hasStock()) {
          $this->handleStock($variant, $data['stock_count']);
      } else {
          $this->createStock($variant, $data['stock_count']);
      }
    }

    public function handleStock($variant, $stockNew) {

      if ($stockNew == $variant->stockCount())
          return;

      if (count($variant->stocks) > 1) {
          $this->convertMultiVriations($variant, $stockNew);
      } else {
          $this->convertFirstVariant($variant, $stockNew);
      }
    }

    protected function convertMultiVriations($variant, $stockNew) {
      if ($variant->stockCount() > $stockNew) {
          $quantity = $variant->stockCount() - $stockNew;
          $temp = $quantity;

          foreach ($variant->stocks as $value) {
             if ($value->quantity >= $temp) {
                 $stock = Stock::where('id', $value->id)->update([
                   'quantity' => $value->quantity - $temp
                 ]);

                 if ($stock['quantity'] == 0) {
                      Stock::destroy($stock['id']);
                 }
                 
                 break;
             } else {
                $temp = $temp - $value->quantity;
                Stock::destroy($value->id);
             }
         }
      } else {
          Stock::create([
                  'product_variation_id' => $variant->id,
                  'quantity' => $stockNew - $variant->stockCount()
                ]);
      }
    }

    protected function convertFirstVariant($variant, $stockNew) {
      $first = $variant->stocks->first();

      if ($variant->stockCount() > $stockNew) {
          $quantity = $first->quantity - ($variant->stockCount() - $stockNew);
      } else {
          $quantity = $first->quantity + ($stockNew - $variant->stockCount());
      }

      Stock::where('id', $first->id)->update([
        'quantity' =>  $quantity
      ]);
    }

    public function createStock($variant, $stock_count) {
      $variant->stocks()->create([
        'quantity' => $stock_count
      ]);
    }

    //
    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function createData(array $data) {
      $variant = ProductVariation::create([
        'product_id' => $data['product']['id'],
        'product_variation_type_id' => $data['type']['id'],
        'price' => $data['price'],
        'base_price' => $data['base_price'],
        'name' => $data['name'],
        'weight' => $data['weight'],
      ]);

      $this->createStock($variant, $data['stock_count']);
    }
}
