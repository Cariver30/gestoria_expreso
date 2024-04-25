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
            $table->string('tablilla', 50);
            $table->string('marca', 100);
            $table->string('anio', 6);
            $table->string('motivo')->nullable();
            // $table->integer('costo_inspeccion_admin')->nullable();
            $table->unsignedBigInteger("estatus_id")->nullable();
            $table->foreign("estatus_id")->references("id")->on("estatus")->onDelete('cascade');
            $table->unsignedBigInteger("mes_vencimiento_id")->nullable();
            $table->foreign("mes_vencimiento_id")->references("id")->on("mes")->onDelete('cascade');
            // $table->unsignedBigInteger("costo_inspeccion_id")->nullable();
            // $table->foreign("costo_inspeccion_id")->references("id")->on("sub_servicios")->onDelete('cascade');
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
