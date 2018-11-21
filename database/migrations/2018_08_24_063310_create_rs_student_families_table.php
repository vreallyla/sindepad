<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsStudentFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_student_families', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('student_id',36)->nullable();
            $table->foreign('student_id')->references('id')->on('link_user_students');
            $table->string('family_id',36)->nullable();
            $table->foreign('family_id')->references('id')->on('link_student_families');
            $table->string('hub_id',36)->nullable();
            $table->foreign('hub_id')->references('id')->on('mst_hubs');
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
        Schema::dropIfExists('rs_student_families');
    }
}
