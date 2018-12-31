<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsScheculesTable extends Migration
{

    public function up()
    {
        Schema::create('rs_schecules', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->time('time_start');
            $table->time('time_end');
            $table->string('day_id', 36);
            $table->foreign('day_id')->references('id')->on('side_daylists');
            $table->string('mst_id', 36)->nullable();
            $table->foreign('mst_id')->references('id')->on('mst_activities');
            $table->string('sche_id', 36)->nullable();
            $table->foreign('sche_id')->references('id')->on('mst_schecules');
            $table->string('act_other')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rs_schecules');
    }
}
