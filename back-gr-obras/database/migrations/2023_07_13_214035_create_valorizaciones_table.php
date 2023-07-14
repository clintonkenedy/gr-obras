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
        Schema::create('valorizaciones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['fisica', 'financiera']);
            $table->decimal('tot_aprobado', 14, 2);
            $table->decimal('cd', 14, 2);
            $table->decimal('anterior', 14, 2);
            $table->decimal('actual', 14, 2);
            $table->decimal('acumulado', 14, 2);
            $table->decimal('saldo', 14, 2);
            $table->decimal('acum_porc', 14, 2);
            $table->decimal('saldo_porc', 14, 2);

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
        Schema::dropIfExists('valorizaciones');
    }
};
