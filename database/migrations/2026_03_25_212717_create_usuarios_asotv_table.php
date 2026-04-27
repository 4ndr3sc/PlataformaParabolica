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
        // Esta migración fue originalmente para crear una tabla usuarios_asotv
        // pero se decidió usar la tabla 'users' existente. No hacer nada aquí.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse necesario ya que no se crea nada
    }
};

