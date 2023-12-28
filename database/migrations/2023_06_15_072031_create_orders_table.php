<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tel');
            $table->integer('city');
            $table->integer('district');
            $table->integer('ward');
            $table->string('address');
            $table->text('note')->nullable();
            $table->text('coco_note')->nullable();
            $table->integer('payment')->nullable();
            $table->integer('status')->nullable();
            $table->integer('price_ship_coco')->nullable();
            $table->integer('price_coupon_now')->nullable();
            $table->string('coupon')->nullable();
            $table->string('mess_coupon')->nullable();
            $table->integer('nhanh_order_id')->nullable();
            $table->integer('shop_order_id')->nullable();
            $table->string('message')->nullable();
            $table->string('status_nhanh')->nullable();
            $table->string('status_description_nhanh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
