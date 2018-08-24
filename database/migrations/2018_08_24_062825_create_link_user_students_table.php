<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkUserStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_user_students', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name');
            $table->string('gender_id',36);
            $table->foreign('gender_id')->references('id')->on('side_genders');
            $table->enum('religion', ['Islam', 'Non Muslim']);
            $table->string('born_place');
            $table->date('dob');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->date('register');
            $table->enum('status', ['Active', 'Non Active']);


            $table->string('packet_id',36);
            $table->foreign('packet_id')->references('id')->on('mst_data_pakets');

            $table->string('class_id',36);
            $table->foreign('class_id')->references('id')->on('mst_classes');

            $table->string('father_id',36)->nullable();
            $table->foreign('father_id')->references('id')->on('mst_data_fathers');
            $table->string('mother_id',36)->nullable();
            $table->foreign('mother_id')->references('id')->on('mst_data_mothers');
            $table->string('custodian_id',36)->nullable();
            $table->foreign('custodian_id')->references('id')->on('mst_data_custodians');
//            $table->string('teacher_id',36)->nullable();
//            $table->foreign('teacher_id')->references('id')->on('link_user_teachers');
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
        Schema::dropIfExists('link_user_students');
    }
}
