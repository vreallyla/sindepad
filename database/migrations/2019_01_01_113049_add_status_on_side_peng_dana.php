<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusOnSidePengDana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('side_peng_danas', function (Blueprint $table) {
            $table->enum('status',['belum terkonfirmasi','sudah terkonfirmasi']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('side_peng_danas', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
