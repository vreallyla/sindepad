<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstDataCustodiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_data_custodians', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name');
            $table->string('born_place');
            $table->date('dob');
            $table->string('phone')->nullable();
            $table->string('profession')->nullable();
            $table->string('address')->nullable();
            $table->string('gender_id',36);
            $table->foreign('gender_id')->references('id')->on('side_genders');
            $table->string('education_id',36)->nullable();
            $table->foreign('education_id')->references('id')->on('side_last_educations');
            $table->string('salary_id',36)->nullable();
            $table->foreign('salary_id')->references('id')->on('side_salary_lists');
            $table->string('profession_id',36)->nullable();
            $table->foreign('profession_id')->references('id')->on('side_profession_lists');
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
        Schema::dropIfExists('mst_data_custodians');
    }
}
