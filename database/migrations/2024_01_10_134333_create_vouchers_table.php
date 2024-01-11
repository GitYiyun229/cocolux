<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('depot_ids')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('from_value')->nullable();
            $table->integer('number_of_codes')->nullable();
            $table->integer('total_used_time')->nullable();
            $table->integer('total_assign')->nullable();
            $table->integer('value_type')->nullable();
            $table->integer('value')->nullable();
            $table->integer('value_max')->nullable();
            $table->integer('status')->nullable();
            $table->integer('id_nhanh')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
