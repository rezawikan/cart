<?php

namespace App\Pattern\ReturnProduct;

use Illuminate\Http\Request;
use App\Models\Order;

class HandleReturnProduct
{

    protected $request;

    public function setRequest(Request $request) {
      $this->request = $request;
    }

    public function findOrder() {
      return Order::find($this->request->order_id);
    }

    public function convertProduct() {
      return collect($this->request->updated_products)->mapWithKeys(function($value) {
        return [$value['id'] => [
          'quantity' => $value['quantity']
          ]];
      })->reject(function ($value) {
          return empty($value['quantity']);
      });
    }

    public function convertReturn() {
      return collect($this->request->return_values)->map(function($value) {
        return [
          'order_id'             => (int) $this->request->order_id,
          'product_variation_id' => $value['id'],
          'quantity'             => $value['quantity'],
          'original_price'       => $value['original_price']
        ];
      })->reject(function ($value) {
          return empty($value['quantity']);
      })->toArray();
    }
}
