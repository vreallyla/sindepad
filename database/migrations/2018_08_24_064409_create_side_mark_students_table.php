<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSideMarkStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_mark_students', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->float('rate');
            $table->text('detail');
            $table->string('teacher_id',36);
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->string('student_id',36);
            $table->foreign('student_id')->references('id')->on('link_user_students');
            $table->string('module_id',36);
            $table->foreign('module_id')->references('id')->on('side_rpp_lists');
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
        Schema::dropIfExists('side_mark_students');
    }
}
