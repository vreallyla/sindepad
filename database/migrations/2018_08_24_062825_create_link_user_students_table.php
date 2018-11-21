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
            $table->string('born_place')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('detail')->nullable();

            $table->date('register')->nullable();
            $table->enum('status', ['Non Active', 'Active']);

            $table->string('class_id',36)->nullable();
            $table->foreign('class_id')->references('id')->on('mst_classes');
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
