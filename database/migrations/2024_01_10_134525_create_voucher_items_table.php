<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('voucher_id');
            $table->integer('value')->nullable();
            $table->integer('value_type')->nullable();
            $table->integer('value_max')->nullable();
            $table->integer('can_used_times')->nullable();
            $table->integer('used_times')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('voucher_items');
    }
}
