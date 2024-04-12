<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cliente_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('compania');
            $table->string('vehiculo');
            $table->string('tablilla');
            $table->string('marca');
            $table->string('anio');
            $table->string('digitos_ss');
            $table->integer('mes_vencimiento');
            $table->unsignedBigInteger("costo_inspeccion_id")->nullable();
            $table->foreign("costo_inspeccion_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->unsignedBigInteger("cliente_id")->nullable();
            $table->foreign("cliente_id")->references("id")->on("clientes")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_vehiculos');
    }
};
