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
            $table->enum('tipo', ['programado', 'físico', 'financiero']);
            $table->date('fecha');
            // $table->enum('estado', ['en proceso', 'finalizado']);
            $table->float('monto', 14, 2)->nullable();
            $table->float('porcentaje', 14, 2)->nullable();
            $table->float('acum', 14, 2)->nullable();

            $table->unsignedBigInteger('obra_id')->nullable();
            $table->foreign('obra_id')->references('id')->on('obras')->nullOnDelete();

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
