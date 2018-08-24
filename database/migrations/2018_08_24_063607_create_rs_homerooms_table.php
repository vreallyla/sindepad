<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsHomeroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_homerooms', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('teacher_id',36);
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->string('student_id',36);
            $table->foreign('student_id')->references('id')->on('link_user_students');
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
        Schema::dropIfExists('rs_homerooms');
    }
}
