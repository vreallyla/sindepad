<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_registers', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('code')->unique();
            $table->date('expired');
            $table->string('amount');
            $table->enum('type',['Diskon','Potong Harga']);
            $table->softDeletes();
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
        Schema::dropIfExists('voucher_registers');
    }
}
