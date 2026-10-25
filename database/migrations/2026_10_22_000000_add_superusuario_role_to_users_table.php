<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('cliente', 'aliado', 'administrador', 'tecnico', 'superusuario') NOT NULL DEFAULT 'cliente'");
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['cliente', 'aliado', 'administrador', 'tecnico', 'superusuario'])
                ->default('cliente')
                ->change();
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            return;
        }

        DB::table('users')->where('role', 'superusuario')->update(['role' => 'administrador']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('cliente', 'aliado', 'administrador', 'tecnico') NOT NULL DEFAULT 'cliente'");
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['cliente', 'aliado', 'administrador', 'tecnico'])
                ->default('cliente')
                ->change();
        });
    }
};
