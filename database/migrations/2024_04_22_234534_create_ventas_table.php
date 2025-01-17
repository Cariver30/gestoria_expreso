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
            // $table->unsignedBigInteger("costo_inspeccion_id")->nullable();
            // $table->foreign("costo_inspeccion_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            // $table->decimal('costo_inspeccion_admin', 8,2)->nullable();
            // $table->unsignedBigInteger('costo_marbete_acaa_id')->nullable();
            // $table->foreign("costo_marbete_acaa_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            // $table->unsignedBigInteger("costo_marbete_id")->nullable();
            // $table->foreign("costo_marbete_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            // $table->decimal('costo_marbete_admin', 8,2)->nullable();
            // $table->unsignedBigInteger('costo_seguro_id')->nullable();
            // $table->foreign("costo_seguro_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            // $table->unsignedBigInteger("extra_licencia_id")->nullable();
            // $table->foreign("extra_licencia_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            // $table->unsignedBigInteger("extra_notificacion_id")->nullable();
            // $table->foreign("extra_notificacion_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            // $table->unsignedBigInteger("extra_multa_id")->nullable();
            // $table->foreign("extra_multa_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->decimal('costo_servicio_fijo', 8,2)->nullable();
            $table->decimal('derechos_anuales', 8,2)->nullable();
            $table->decimal('total', 8,2);
            $table->string('motivo')->nullable();
            $table->datetime('fecha_pago')->nullable();
            $table->integer('tipo_pago')->nullable();
            $table->integer('tipo_servicio'); //Si es Inspección=1, si es gestoría es 2
            $table->unsignedBigInteger("usuario_id")->nullable();
            $table->foreign("usuario_id")->references("id")->on("users");
            $table->unsignedBigInteger("estatus_id")->nullable();
            $table->foreign("estatus_id")->references("id")->on("estatus")->onDelete('cascade');
            $table->unsignedBigInteger("vehiculo_id")->nullable();
            $table->foreign("vehiculo_id")->references("id")->on("cliente_vehiculos")->onDelete('cascade');
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
        Schema::dropIfExists('ventas');
    }
};
