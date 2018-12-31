<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_activities', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('code', 36)->unique();
            $table->string('name', 50);
            $table->integer('time');
            $table->string('purpose', 50);
            $table->text('summary');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_activities');
    }
}
