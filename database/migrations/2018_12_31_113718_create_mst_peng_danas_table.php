<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstPengDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_peng_danas', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('kode', 15)->unique();
            $table->string('name');
            $table->text('desc');
            $table->string('target');
            $table->string('terisi');
            $table->enum('status',['Proses','Sukses']);
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
        Schema::dropIfExists('mst_peng_danas');
    }
}
