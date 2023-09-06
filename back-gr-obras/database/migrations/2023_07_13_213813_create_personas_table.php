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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_doc', ['DNI', 'RUC']);
            $table->string('num_doc', 11);
            $table->string('nombres', 191);
            $table->string('a_paterno', 191);
            $table->string('a_materno', 191);
            $table->string('nombre_completo', 573)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('direccion', 191)->nullable();
            $table->char('celular', 9)->nullable();

            $table->unsignedBigInteger('administrativo_id')->nullable();
            $table->foreign('administrativo_id')->references('id')->on('users')->nullOnDelete();

            $table->unsignedBigInteger('trabajador_id')->nullable();
            $table->foreign('trabajador_id')->references('id')->on('trabajadores')->nullOnDelete();

            $table->char('ubigeo_cod', 6)->nullable();
            $table->foreign('ubigeo_cod')->references('codigo')->on('ubigeos')->nullOnDelete();
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
        Schema::dropIfExists('personas');
    }
};
