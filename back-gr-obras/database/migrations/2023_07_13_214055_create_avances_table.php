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
        Schema::create('avances', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['físico', 'financiera']);
            $table->date('fecha');
            $table->enum('estado', ['en proceso', 'finalizado']);
            $table->float('avance_fisico_km', 14, 2)->nullable();
            $table->integer('avance_fisico_npisos')->nullable();
            $table->integer('avance_fisico_metros')->nullable();
            $table->string('avance_fisico_otros')->nullable();
            $table->float('avance_financiero', 14, 2)->nullable();

            $table->unsignedBigInteger('obra_id')->nullable();
            $table->foreign('obra_id')->references('id')->on('obras')->nullOnDelete();

            $table->unsignedBigInteger('cronograma_id')->nullable();
            $table->foreign('cronograma_id')->references('id')->on('cronogramas')->nullOnDelete();
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
        Schema::dropIfExists('avances');
    }
};
