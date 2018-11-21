<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkPaymentInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_payment_invoices', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('img');
            $table->string('name');
            $table->date('date_send');
            $table->string('bank_id',36);
            $table->foreign('bank_id')->references('id')->on('data_banks');
            $table->string('tran_id',36);
            $table->foreign('tran_id')->references('id')->on('mst_transaction_lists');

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
        Schema::dropIfExists('link_payment_invoices');
    }
}
