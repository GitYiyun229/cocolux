<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->default('')->nullable();
            $table->string('sku')->nullable();
            $table->string('image')->nullable();
            $table->string('brand')->nullable();
            $table->integer('price')->nullable();
            $table->integer('barcode')->nullable();
            $table->json('hashtag')->nullable();
            $table->string('video_url')->nullable();
            $table->text('canonical_url')->nullable();
            $table->integer('normal_price')->nullable();
            $table->text('description')->nullable();
            $table->text('document')->nullable();
            $table->json('attributes')->nullable();
            $table->json('categories')->nullable();
            $table->json('suppliers')->nullable();
            $table->json('hot_deal')->nullable();
            $table->json('flash_deal')->nullable();
            $table->tinyInteger('is_home')->default(0)->nullable();
            $table->tinyInteger('is_hot')->default(0)->nullable();
            $table->tinyInteger('is_new')->default(0)->nullable();
            $table->tinyInteger('active')->default(0)->comment('0: Không hoạt động; 1: Hoạt động');
            $table->integer('view_count')->nullable();
            $table->integer('order_count')->nullable();
            $table->integer('rating_count')->nullable();
            $table->integer('rating_average')->nullable();
            $table->integer('comment_count')->nullable();
            $table->integer('favourite_count')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
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
        Schema::dropIfExists('products');
    }
}
