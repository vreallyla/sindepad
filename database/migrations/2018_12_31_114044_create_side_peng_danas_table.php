<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidePengDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_peng_danas', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('an', 32);
            $table->string('email', 36);
            $table->string('url');
            $table->string('nominal');
            $table->date('date');
            $table->string('mst_id',36)->nullable();
            $table->foreign('mst_id')->references('id')->on('mst_peng_danas')->onDelete('cascade');
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
        Schema::dropIfExists('side_peng_danas');
    }
}
