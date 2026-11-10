<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('invoice_number')->unique();
                $table->string('plan_key');
                $table->string('plan_name');
                $table->unsignedInteger('amount');
                $table->date('date');
                $table->date('billing_period');
                $table->date('due_date');
                $table->enum('status', ['pending', 'paid'])->default('pending');
                $table->timestamps();
                $table->unique(['user_id', 'billing_period']);
            });
        }

        if (! Schema::hasTable('service_requests')) {
            Schema::create('service_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('service_key');
                $table->string('service_name');
                $table->unsignedInteger('amount');
                $table->enum('status', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
                $table->timestamps();
                $table->index(['user_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        // The original table-creation migrations own these tables.
    }
};
