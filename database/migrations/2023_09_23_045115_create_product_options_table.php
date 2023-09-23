<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->default('')->nullable();
            $table->string('sku')->nullable();
            $table->json('images')->nullable();
            $table->string('brand')->nullable();
            $table->string('option_name')->nullable();
            $table->integer('price')->nullable();
            $table->integer('barcode')->nullable();
            $table->integer('normal_price')->nullable();
            $table->integer('parent_id')->nullable();
            $table->json('variations')->nullable();
            $table->json('stocks')->nullable();
            $table->json('options')->nullable();
            $table->json('hot_deal')->nullable();
            $table->json('flash_deal')->nullable();
            $table->tinyInteger('is_default')->default(0)->nullable();
            $table->tinyInteger('active')->default(0)->comment('0: Không hoạt động; 1: Hoạt động');
            $table->integer('ordering')->default(0)->nullable();
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
        Schema::dropIfExists('product_options');
    }
}
