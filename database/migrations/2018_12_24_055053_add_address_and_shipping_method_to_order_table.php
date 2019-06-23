<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressAndShippingMethodToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('address_id')->after('user_id')->unsigned()->index();
            $table->integer('shipping_method_id')->after('user_id')->unsigned()->index();

            $table->foreign('address_id')->references('id')->on('addresses');
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
        Schema::table('orders', function (Blueprint $table) {

          $table->dropForeign('orders_address_id_foreign');
          $table->dropForeign('orders_shipping_method_id_foreign');

          $table->dropColumn('address_id');
          $table->dropColumn('shipping_method_id');
        });
    }
}
