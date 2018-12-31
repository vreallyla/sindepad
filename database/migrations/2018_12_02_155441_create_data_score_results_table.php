<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataScoreResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_score_results', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->float('value');
            $table->string('achievement');
            $table->string('note');
            $table->string('sd_act_id',36);
            $table->foreign('sd_act_id')->references('id')->on('side_activities');
            $table->string('student_id',36);
            $table->foreign('student_id')->references('id')->on('link_user_students');
            $table->string('teacher_id',36);
            $table->foreign('teacher_id')->references('id')->on('users');
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
        Schema::dropIfExists('data_score_results');
    }
}
