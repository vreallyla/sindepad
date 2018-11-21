<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsTransMultiStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_trans_multi_students', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('trans_id', 36);
            $table->foreign('trans_id')->references('id')->on('mst_transaction_lists');
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
        Schema::dropIfExists('rs_trans_multi_students');
    }
}
