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
            $table->decimal('costo_inspeccion_admin')->nullable();
            $table->unsignedBigInteger('costo_marbete_acca_id')->nullable();
            $table->foreign("costo_marbete_acca_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->unsignedBigInteger("costo_marbete_id")->nullable();
            $table->foreign("costo_marbete_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->decimal('costo_marbete_admin')->nullable();
            $table->unsignedBigInteger('costo_seguro_id')->nullable();
            $table->foreign("costo_seguro_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->integer('costo_servicio_fijo')->nullable();
            $table->decimal('derechos_anuales', 10, 3)->nullable();
            $table->decimal('total', 8,2);
            $table->string('motivo')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->integer('tipo_pago')->nullable();
            $table->unsignedBigInteger("usuario_id")->nullable();
            $table->foreign("usuario_id")->references("id")->on("users");
            $table->unsignedBigInteger("estatus_id")->nullable();
            $table->foreign("estatus_id")->references("id")->on("estatus")->onDelete('cascade');
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
