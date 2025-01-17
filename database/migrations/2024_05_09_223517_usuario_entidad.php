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
        Schema::create('usuario_sedes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("usuario_id")->nullable();
            $table->foreign("usuario_id")->references("id")->on("users");
            $table->unsignedBigInteger("sede_id");
            $table->foreign("sede_id")->references("id")->on("sedes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
