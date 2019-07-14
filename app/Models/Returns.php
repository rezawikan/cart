<?php

namespace App\Models;

use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use CanBeScoped, LatestOrder;

    protected $table = 'returns';
    protected $fillable = [
      'product_variation_id',
      'order_id',
      'quantity',
      'status',
      'info'
    ];

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function variation()
    {
      return $this->belongsTo(ProductVariation::class,'product_variation_id','id');
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function order()
    {
      return $this->belongsTo(Order::class);
    }
}
