<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('role_id')->default(1);
            $table->tinyInteger('blocked')->default(0);
            $table->dateTime('lastonline')->nullable();
            $table->boolean('online')->default(false);
            $table->dateTime('registration')->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->string('confirmation_token')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
