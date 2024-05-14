<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->default('');
            $table->string('image')->nullable();
            $table->string('banner_up')->nullable();
            $table->string('banner_down')->nullable();
            $table->text('canonical_url')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('content_faq')->nullable();
            $table->tinyInteger('is_home')->default(0)->nullable();
            $table->tinyInteger('has_toc')->default(1)->nullable();
            $table->tinyInteger('is_highlight')->default(0)->nullable();
            $table->tinyInteger('active')->default(0)->comment('0: Không hoạt động; 1: Hoạt động');
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
            $table->integer('ordering')->default(0)->nullable();
            $table->string('hashtag')->nullable();
            $table->string('products')->nullable();
            $table->string('name_cat')->nullable();
            $table->string('link_cat')->nullable();
            $table->string('products_up')->nullable();
            $table->string('products_down')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
