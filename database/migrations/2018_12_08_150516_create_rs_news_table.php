<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_news', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('mst_id',36)->nullable();
            $table->foreign('mst_id')->references('id')->on('mst_news_lists')->onDelete('cascade');
            $table->string('category_id',36)->nullable();
            $table->foreign('category_id')->references('id')->on('side_news_categories');
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
        Schema::dropIfExists('rs_news');
    }
}
