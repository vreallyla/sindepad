<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkUserTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_user_teachers', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('lastschool');
            $table->date('register');
            $table->string('job_id',36);
            $table->foreign('job_id')->references('id')->on('side_job_desks');
            $table->string('education_id',36)->nullable();
            $table->foreign('education_id')->references('id')->on('side_last_educations');
            $table->string('marital_id',36);
            $table->foreign('marital_id')->references('id')->on('side_marital_statuses');
            $table->string('occupation_id',36);
            $table->foreign('occupation_id')->references('id')->on('side_occupations');
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
        Schema::dropIfExists('link_user_teachers');
    }
}
