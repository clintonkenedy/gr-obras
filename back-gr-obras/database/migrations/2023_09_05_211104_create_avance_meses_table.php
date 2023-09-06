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
        Schema::create('avance_meses', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->comment('junio2023');
            $table->float('sum_programado', 14, 2)->nullable();
            $table->float('sum_fisico', 14, 2)->nullable();
            $table->float('sum_financiero', 14, 2)->nullable();
            $table->float('saldo', 14, 2)->nullable()->comment('Relacionado con el Costo Directo');

            $table->unsignedBigInteger('obra_id')->nullable();
            $table->foreign('obra_id')->references('id')->on('obras')->nullOnDelete();

            $table->index('obra_id');

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
        Schema::dropIfExists('avance_meses');
    }
};
