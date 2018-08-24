<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSideCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_cities', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('name', 100);
            $table->string('provinces_id',36);
            $table->foreign('provinces_id')->references('id')->on('side_provinces');
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
        Schema::dropIfExists('side_cities');
    }
}
