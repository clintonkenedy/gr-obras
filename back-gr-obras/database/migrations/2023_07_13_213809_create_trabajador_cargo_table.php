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
        Schema::create('trabajador_cargo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trabajador_id')->nullable();
            $table->unsignedBigInteger('cargo_id')->nullable();
            $table->foreign('trabajador_id')->references('id')->on('trabajadores')->nullOnDelete();
            $table->foreign('cargo_id')->references('id')->on('cargos')->nullOnDelete();
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
        Schema::dropIfExists('trabajador_cargo');
    }
};
