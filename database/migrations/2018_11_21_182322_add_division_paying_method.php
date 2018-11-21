<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDivisionPayingMethod extends Migration
{

    public function up()
    {
        Schema::table('paying_methods', function (Blueprint $table) {
            $table->string('name_owner')->nullable();
            $table->string('division')->nullable();
        });
    }

    public function down()
    {
        Schema::table('paying_methods', function (Blueprint $table) {
            $table->dropColumn('name_owner');
            $table->dropColumn('division');
        });
    }
}
