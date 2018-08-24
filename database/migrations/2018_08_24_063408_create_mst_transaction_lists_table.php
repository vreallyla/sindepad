<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstTransactionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_transaction_lists', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->bigInteger('amount');
            $table->string('user_id',36);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('student_id',36)->nullable();
            $table->foreign('student_id')->references('id')->on('link_user_students');
            $table->string('admin_id',36);
            $table->foreign('admin_id')->references('id')->on('users');
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
        Schema::dropIfExists('mst_transaction_lists');
    }
}
