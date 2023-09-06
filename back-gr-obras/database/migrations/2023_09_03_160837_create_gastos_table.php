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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->float('costo_directo', 14, 2)->nullable();
            $table->float('gastos_generales', 14, 2)->nullable();
            $table->float('gastos_supervision', 14, 2)->nullable();
            $table->float('gastos_gest_proyect', 14, 2)->nullable();
            $table->float('gastos_liquidacion', 14, 2)->nullable();
            $table->float('gastos_monito_segui', 14, 2)->nullable();
            $table->float('gastos_elabo_expediente', 14, 2)->nullable();
            $table->float('gastos_evalu_expediente', 14, 2)->nullable();

            $table->unsignedBigInteger('presupuesto_id')->nullable();
            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->nullOnDelete();
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
        Schema::dropIfExists('gastos');
    }
};
