<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstDataRppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_data_rpps', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name');
            $table->date('period_start');
            $table->date('periode_end');
            $table->string('class_id',36);
            $table->foreign('class_id')->references('id')->on('mst_classes');
            $table->string('user_id',36);
            $table->foreign('user_id')->references('id')->on('mst_disabilities');
            /*$table->string('custodian_id',36)->nullable();
            $table->foreign('custodian_id')->references('id')->on('users');*/
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
        Schema::dropIfExists('mst_data_rpps');
    }
}
