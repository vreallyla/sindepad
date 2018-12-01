<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('email')->unique();
            $table->integer('ni')->nullable()->unique();
            $table->string('url');
            $table->string('name');
            $table->string('password');
            $table->string('gender_id',36);
            $table->foreign('gender_id')->references('id')->on('side_genders');
            $table->string('born_place')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('code_status');

            $table->string('status_id',36);
            $table->foreign('status_id')->references('id')->on('side_status_users');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
