<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paying_methods', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name')->unique();

            $table->string('url')->unique()->nullable();
            $table->enum('method', ['Bayar Ditempat', 'Transfer']);
            $table->string('desc')->nullable();
            $table->string('bank_id',36)->nullable();
            $table->foreign('bank_id')->references('id')->on('data_banks');
            $table->softDeletes();
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
        Schema::dropIfExists('paying_methods');
    }
}
