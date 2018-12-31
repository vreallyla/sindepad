<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSideActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_activities', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name', 50);
            $table->string('target');
            $table->text('desc');
            $table->string('mst_id',36)->nullable();
            $table->foreign('mst_id')->references('id')->on('mst_activities');
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
        Schema::dropIfExists('side_activities');
    }
}
