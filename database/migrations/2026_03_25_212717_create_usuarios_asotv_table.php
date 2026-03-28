<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_asotv');
    }
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // Crea el campo 'id'
        $table->string('name'); // Para 'Cesar Andres Contreras Suarez'
        $table->string('email')->unique(); // Para 'andres@andres.com'
        $table->timestamp('email_verified_at')->nullable(); // Campo NULL en tu imagen
        $table->string('password'); // Para la contraseña encriptada
        $table->rememberToken(); // Campo 'remember_token'
        $table->timestamps(); // Crea 'created_at' y 'updated_at'
    });
}
};
