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
        Schema::create('vehiculo_marbetes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("vehiculo_id");
            $table->foreign("vehiculo_id")->references("id")->on("cliente_vehiculos")->onDelete('cascade');
            $table->unsignedBigInteger("marbete_id")->nullable();
            $table->foreign("marbete_id")->references("id")->on("sub_servicios")->onDelete('cascade');
            $table->integer('marbete_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculo_marbetes');
    }
};
