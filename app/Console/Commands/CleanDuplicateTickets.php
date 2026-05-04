<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;

class CleanDuplicateTickets extends Command
{
    protected $signature = 'tickets:clean-duplicates';
    protected $description = 'Elimina tickets duplicados manteniendo el más antiguo';

    public function handle()
    {
        $this->info('Limpiando tickets duplicados...');

        // Obtener todos los ticket_number que aparecen más de una vez
        $duplicates = Ticket::select('ticket_number')
            ->groupBy('ticket_number')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('ticket_number');

        if ($duplicates->isEmpty()) {
            $this->info('No hay tickets duplicados.');
            return 0;
        }

        $deletedCount = 0;

        foreach ($duplicates as $ticketNumber) {
            // Obtener todos los tickets con este número, ordenados por ID (mantener el más antiguo)
            $tickets = Ticket::where('ticket_number', $ticketNumber)
                ->orderBy('id', 'asc')
                ->get();

            // Mantener el primero, eliminar los demás
            $tickets->slice(1)->each(function ($ticket) use (&$deletedCount) {
                $ticket->delete();
                $deletedCount++;
            });
        }

        $this->info("Se eliminaron {$deletedCount} tickets duplicados.");
        return 0;
    }
}
