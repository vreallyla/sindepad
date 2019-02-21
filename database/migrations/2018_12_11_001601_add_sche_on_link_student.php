<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScheOnLinkStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('link_user_students', function (Blueprint $table) {
            $table->string('sche_id',36)->nullable();
            $table->foreign('sche_id')->references('id')->on('mst_schecules')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('link_user_students', function (Blueprint $table) {
            $table->dropColumn('sche_id');
        });
    }
}
