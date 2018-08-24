<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsUserToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_user_to_students', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('student_id',36);
            $table->foreign('student_id')->references('id')->on('link_user_students');
            $table->string('user_id',36);
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('rs_user_to_students');
    }
}
