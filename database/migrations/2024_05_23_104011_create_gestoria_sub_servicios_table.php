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
        Schema::create('gestoria_sub_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('costo');
            $table->unsignedBigInteger("gestoria_servicio_id")->nullable();
            $table->foreign("gestoria_servicio_id")->references("id")->on("gestoria_servicios")->onDelete('cascade');
            $table->unsignedBigInteger("estatus_id")->nullable();
            $table->foreign("estatus_id")->references("id")->on("estatus")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestoria_sub_servicios');
    }
};
