<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsTransPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_trans_prices', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('trans_user_id', 36);
            $table->foreign('trans_user_id')->references('id')->on('rs_trans_multi_students');
            $table->string('price_id', 36);
            $table->foreign('price_id')->references('id')->on('link_trans_prices');
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
        Schema::dropIfExists('rs_trans_prices');
    }
}
