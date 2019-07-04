<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_variation_id')->unsigned()->index();
            $table->integer('order_id')->unsigned()->index();
            $table->integer('quantity');
            $table->string('status')->default('processing');
            $table->string('info')->default('none'); //  none and fixed
            $table->timestamps();

            $table->foreign('product_variation_id')->references('id')->on('product_variations');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returns');
    }
}
