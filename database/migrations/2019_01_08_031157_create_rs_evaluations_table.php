<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_evaluations', function (Blueprint $table) {
            $table->string('eva_id',36);
            $table->foreign('eva_id')->references('id')->on('mst_evaluations')->onDelete('cascade');
            $table->string('student_id',36);
            $table->foreign('student_id')->references('id')->on('link_user_students')->onDelete('cascade');
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
        Schema::dropIfExists('rs_evaluations');
    }
}
