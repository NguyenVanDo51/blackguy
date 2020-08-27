<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LessionUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lession_user', function (Blueprint $table) {
            $table->bigInteger('lession_id');
            $table->bigInteger('user_id');
            $table->bigInteger('course')->nullable();
            $table->bigInteger('timer')->default(0);
            $table->boolean('is_finish')->default(false);
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
        Schema::dropIfExists('lession_user');
    }
}
