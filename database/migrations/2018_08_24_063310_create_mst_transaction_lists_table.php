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
            $table->enum('status',['menunggu','konfirmasi','administrasi','batal','berhasil']);
            $table->string('user_id',36);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('admin_id',36)->nullable();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->string('method_id',36)->nullable();
            $table->foreign('method_id')->references('id')->on('paying_methods');
            $table->string('voucher_id',36)->nullable();
            $table->foreign('voucher_id')->references('id')->on('voucher_registers');
            $table->string('code',36)->unique();
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
