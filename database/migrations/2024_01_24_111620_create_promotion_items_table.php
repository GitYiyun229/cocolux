<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_items', function (Blueprint $table) {
            $table->id();
            $table->integer('promotion_id');
            $table->string('name');
            $table->integer('price')->nullable();
            $table->integer('value')->nullable();
            $table->string('sku')->nullable();
            $table->integer('nhanh_id')->nullable();
            $table->string('type')->nullable();
            $table->timestamp('applied_stop_time')->nullable();
            $table->timestamp('applied_start_time')->nullable();
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
        Schema::dropIfExists('promotion_items');
    }
}
