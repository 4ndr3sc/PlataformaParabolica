<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('email');
            }
        });

        if (Schema::hasColumn('users', 'role')) {
            $driver = DB::getDriverName();

            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY role ENUM('cliente', 'aliado', 'administrador', 'tecnico') NOT NULL DEFAULT 'cliente'");
            } elseif ($driver === 'sqlite') {
                $rows = DB::table('users')->whereRaw("role NOT IN ('cliente', 'aliado', 'administrador', 'tecnico')")->get();
                foreach ($rows as $row) {
                    DB::table('users')->where('id', $row->id)->update(['role' => 'cliente']);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
