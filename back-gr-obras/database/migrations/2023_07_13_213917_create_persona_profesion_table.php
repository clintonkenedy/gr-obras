<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona_profesion', function (Blueprint $table) {
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('profesion_id');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('profesion_id')->references('id')->on('profesiones')->onDelete('cascade');
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
        Schema::dropIfExists('persona_profesion');
    }
};
