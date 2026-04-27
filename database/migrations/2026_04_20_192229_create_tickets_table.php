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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            // Relación con el usuario: Usamos foreignId para mayor limpieza
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Identificador único del ticket (ej: TICKET-12345)
            $table->string('ticket_number')->unique();
            
            // Clasificación PQR
            $table->enum('type', ['peticion', 'queja', 'reclamo', 'sugerencia'])
                  ->default('peticion');
            
            $table->string('subject'); // El asunto ya no debería ser nullable para tener orden
            $table->text('description');
            
            // Estados del proceso
            $table->enum('status', ['abierto', 'en_progreso', 'resuelto', 'cerrado'])
                  ->default('abierto');
            
            // Prioridad para atención técnica
            $table->enum('priority', ['baja', 'media', 'alta'])
                  ->default('media');
            
            // Respuesta de soporte y fecha de cierre
            $table->text('response')->nullable();
            $table->timestamp('resolved_at')->nullable();
            
            $table->timestamps(); // Crea created_at y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};