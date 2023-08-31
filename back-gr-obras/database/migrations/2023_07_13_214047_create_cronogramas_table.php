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
        Schema::create('cronogramas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['semanal', 'mensual']);
            $table->date('fec_ini');
            $table->date('fec_fin');
            $table->decimal('presu_req', 14, 2);
            $table->tinyInteger('num_req');
            $table->decimal('porcentaje', 14, 2);
            $table->decimal('monto_adqui', 14, 2);
            $table->decimal('monto_proceso', 14, 2);
            $table->decimal('monto_total', 14, 2);

            $table->unsignedBigInteger('administrativo_id')->nullable();
            $table->foreign('administrativo_id')->references('id')->on('administrativos')->nullOnDelete();

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
        Schema::dropIfExists('cronogramas');
    }
};
