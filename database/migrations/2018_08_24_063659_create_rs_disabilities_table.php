<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsDisabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_disabilities', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->text('detail')->nullable();
            $table->string('student_id',36);
            $table->foreign('student_id')->references('id')->on('link_user_students');
            $table->string('disablity_id',36);
            $table->foreign('disablity_id')->references('id')->on('mst_disabilities');
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
        Schema::dropIfExists('rs_disabilities');
    }
}
