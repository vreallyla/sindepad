<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSideRppListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_rpp_lists', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->text('materi');
            $table->text('tujuan');
            $table->text('target');
            $table->string('category_id',36)->nullable();
            $table->foreign('category_id')->references('id')->on('side_category_rpps');
            $table->string('data_id',36)->nullable();
            $table->foreign('data_id')->references('id')->on('mst_data_rpps');
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
        Schema::dropIfExists('side_rpp_lists');
    }
}
