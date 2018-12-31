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
            $table->date('register');
            $table->string('education_id',36)->nullable();
            $table->foreign('education_id')->references('id')->on('side_last_educations');
            $table->string('marital_id',36);
            $table->foreign('marital_id')->references('id')->on('side_marital_statuses');
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
        Schema::dropIfExists('link_user_teachers');
    }
}
