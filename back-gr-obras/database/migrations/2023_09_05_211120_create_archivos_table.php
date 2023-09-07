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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->string('extension', 255);
            $table->boolean('es_plantilla');
            $table->string('nombre');
            $table->string('desc', 600)->nullable();
            $table->string('size', 20)->nullable();
            $table->string('url');

            $table->unsignedBigInteger('obra_id')->nullable();
            $table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');

            $table->unsignedBigInteger('avance_mes_id')->nullable();
            $table->foreign('avance_mes_id')->references('id')->on('avance_meses')->onDelete('cascade');

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
        Schema::dropIfExists('archivos');
    }
};
