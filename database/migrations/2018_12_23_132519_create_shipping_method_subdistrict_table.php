<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingMethodSubdistrictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_method_subdistrict', function (Blueprint $table) {
            $table->integer('subdistrict_id')->unsigned()->index();
            $table->integer('shipping_method_id')->unsigned()->index();

            $table->foreign('subdistrict_id')->references('id')->on('subdistricts');
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_method_subdistrict');
    }
}
