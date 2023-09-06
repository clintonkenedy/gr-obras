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
            // $table->tinyInteger('num_semana')->nullable()->default(0);
            $table->string('codigo', 30);
            $table->string('codigo_semana', 30);

            $table->float('monto_prog', 14, 2)->nullable();
            $table->float('porcentaje_prog', 14, 2)->nullable();
            $table->float('acum_prog', 14, 2)->nullable();

            $table->float('monto_fisic', 14, 2)->nullable();
            $table->float('porcentaje_fisc', 14, 2)->nullable();
            $table->float('acum_fisc', 14, 2)->nullable();

            $table->float('monto_finan', 14, 2)->nullable();
            $table->float('porcentaje_finan', 14, 2)->nullable();
            $table->float('acum_finan', 14, 2)->nullable();

            $table->unsignedBigInteger('avance_mes_id')->nullable();
            $table->foreign('avance_mes_id')->references('id')->on('avance_meses')->nullOnDelete();

            $table->index(['codigo', 'codigo_semana', 'avance_mes_id']);

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
