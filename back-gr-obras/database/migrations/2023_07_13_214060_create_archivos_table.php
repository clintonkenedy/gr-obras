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

            $table->unsignedBigInteger('obra_resolucion_id')->nullable();
            $table->foreign('obra_resolucion_id')->references('id')->on('obras')->nullOnDelete();

            $table->unsignedBigInteger('obra_kmz_id')->nullable();
            $table->foreign('obra_kmz_id')->references('id')->on('obras')->nullOnDelete();

            $table->unsignedBigInteger('arch_cronograma_id')->nullable();
            $table->foreign('arch_cronograma_id')->references('id')->on('cronogramas')->nullOnDelete();

            $table->unsignedBigInteger('cronograma_req_id')->nullable();
            $table->foreign('cronograma_req_id')->references('id')->on('cronogramas')->nullOnDelete();

            $table->unsignedBigInteger('avance_id')->nullable();
            $table->foreign('avance_id')->references('id')->on('avances')->nullOnDelete();

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
