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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("costo_inspeccion_id")->nullable();
            $table->foreign("costo_inspeccion_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->integer('costo_inspeccion_admin')->nullable();
            $table->unsignedBigInteger("costo_marbete_id")->nullable();
            $table->foreign("costo_marbete_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->integer('costo_marbete_admin')->nullable();
            $table->integer('costo_servicio_fijo')->nullable();

            $table->integer('total');
            $table->date('fecha_pago');
            $table->integer('tipo_pago');
            $table->unsignedBigInteger("vehiculo_id")->nullable();
            $table->foreign("vehiculo_id")->references("id")->on("cliente_vehiculos")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
