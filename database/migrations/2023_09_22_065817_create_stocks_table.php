<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->string('store_name');
            $table->integer('product_id')->nullable();
            $table->integer('product_option_id')->nullable();
            $table->integer('product_master_id')->nullable();
            $table->float('total_quantity')->nullable();
            $table->float('total_order_quantity')->nullable();
            $table->float('total_stock_quantity')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
