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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->default('2024-02-28 17:04:58');
            $table->string('password');
            $table->string('pin')->unique();
            $table->date('dob');
            $table->text('avatar');
            $table->rememberToken();
            $table->timestamps();
        });
        User::create([
            'name' => 'Alfredo Ramirez Anastacio',
            'dob'=>'2000-10-10',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'pin' => 'A1B2C3',
            'email_verified_at'=> '2022-01-02 17:04:58',
            'avatar' => 'images/avatar-1.jpg',
            'created_at' => now()
        ]);
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
