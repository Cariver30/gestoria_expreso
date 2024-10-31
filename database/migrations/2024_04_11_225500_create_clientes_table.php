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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('tipo_cliente');  //Si es cliente inspección=1, si es tipo gestoría=2
            $table->string('email');
            $table->string('telefono');
            $table->string('seguro_social');
            $table->string('identificacion');
            $table->string('img_licencia');
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
        Schema::dropIfExists('clientes');
    }
};
