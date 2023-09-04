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
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->char('cui', 7);
            $table->string('meta', 50);
            $table->string('nombre_proyecto', 500);
            $table->string('sector', 191);
            $table->enum('estado_obra', ['en ejecución', 'pendiente', 'suspendido', 'finalizado']);
            $table->smallInteger('dura_dias');
            $table->date('fec_ini');
            $table->date('fec_fin');
            $table->float('pim', 14, 2)->default(0);
            $table->float('saldo_asig', 14, 2)->default(0);


            $table->char('ubigeo_cod', 6)->nullable();
            $table->foreign('ubigeo_cod')->references('codigo')->on('ubigeos')->nullOnDelete();
            
            $table->unsignedBigInteger('coordinador_id')->nullable();
            $table->foreign('coordinador_id')->references('id')->on('administrativos')->nullOnDelete();
            
            $table->unsignedBigInteger('residente_id')->nullable();
            $table->foreign('residente_id')->references('id')->on('administrativos')->nullOnDelete();
            
            $table->unsignedBigInteger('economista_id')->nullable();
            $table->foreign('economista_id')->references('id')->on('administrativos')->nullOnDelete();
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
        Schema::dropIfExists('obras');
    }
};
