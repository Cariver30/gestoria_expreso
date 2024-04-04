<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->default('2024-02-28 17:04:58');
            $table->string('password');
            $table->string('pin')->unique();
            $table->unsignedBigInteger("estatus_id")->nullable();
            $table->foreign("estatus_id")->references("id")->on("estatus")->onDelete('cascade');
            $table->date('dob');
            $table->text('avatar');
            $table->unsignedBigInteger("rol_id");
            $table->foreign("rol_id")->references("id")->on("roles")->onDelete('cascade');
            $table->unsignedBigInteger("sede_id")->nullable();
            $table->foreign("sede_id")->references("id")->on("sedes")->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
