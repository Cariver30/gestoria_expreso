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
        Schema::create('detalle_venta_inspeccions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("subservicio_id")->nullable();
            $table->foreign("subservicio_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->unsignedBigInteger("servicio_id")->nullable();
            $table->foreign("servicio_id")->references("id")->on("servicios")->onDelete('cascade');
            $table->unsignedBigInteger("venta_id")->nullable();
            $table->foreign("venta_id")->references("id")->on("ventas")->onDelete('cascade');
            $table->decimal('precio', 8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_venta_inspeccions');
    }
};
