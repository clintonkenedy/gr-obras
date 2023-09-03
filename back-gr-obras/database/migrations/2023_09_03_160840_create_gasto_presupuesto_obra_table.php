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
        Schema::create('gasto_presupuesto_obra', function (Blueprint $table) {
            $table->float('ppto', 14, 2);
            $table->float('adicional', 14, 2)->nullable();
            $table->float('ejecutado', 14, 2);
            $table->float('saldo', 14, 2);
            $table->date('fecha');

            $table->unsignedBigInteger('gasto_id');
            $table->unsignedBigInteger('obra_id');
            $table->foreign('gasto_id')->references('id')->on('gastos')->onDelete('cascade');
            $table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');
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
