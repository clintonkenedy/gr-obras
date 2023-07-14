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
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->date('fec');
            $table->decimal('costo_actualizado', 14, 2);
            $table->decimal('ejec_acumulado', 14, 2);
            $table->enum('pia', ['con pia', 'sin pia']);
            $table->decimal('sal_asig', 14, 2);
            $table->date('fec_asig');
            $table->string('pia_inc', 191);
            
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
        Schema::dropIfExists('presupuestos');
    }
};
