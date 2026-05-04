<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function showCreateForm()
    {
        $user = auth()->user();
        return view('create-ticket', ['user' => $user]);
    }

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'type' => 'required|in:peticion,queja,reclamo',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'priority' => 'required|in:baja,media,alta',
        ]);

        $user = auth()->user();
        $maxAttempts = 5;
        $attempt = 0;

        // Generar número único de ticket con reintentos
        while ($attempt < $maxAttempts) {
            try {
                $ticket = DB::transaction(function () use ($user, $request) {
                    // Contar tickets del día con LOCK para evitar race conditions
                    $todayCount = Ticket::where('ticket_number', 'like', 'TK-' . date('Ymd') . '%')
                                        ->lockForUpdate()
                                        ->count();
                    
                    $ticketNumber = 'TK-' . date('Ymd') . '-' . str_pad($todayCount + 1, 4, '0', STR_PAD_LEFT);

                    // Crear el ticket
                    return Ticket::create([
                        'user_id' => $user->id,
                        'ticket_number' => $ticketNumber,
                        'type' => $request->type,
                        'subject' => $request->subject,
                        'description' => $request->description,
                        'priority' => $request->priority,
                        'status' => 'abierto',
                    ]);
                });

                return redirect('/soporte')->with('success', '¡Tu ticket ha sido creado correctamente! Número: ' . $ticket->ticket_number);
            } catch (\Exception $e) {
                if (str_contains($e->getMessage(), 'tickets_ticket_number_unique')) {
                    $attempt++;
                    if ($attempt >= $maxAttempts) {
                        // Si falla después de reintentos, limpiar duplicados y reintentar
                        Ticket::where('ticket_number', 'like', 'TK-' . date('Ymd') . '%')
                               ->orderBy('id')
                               ->skip(1)
                               ->delete();
                        return redirect('/soporte')->with('error', 'Se detectaron duplicados. Por favor intenta de nuevo.');
                    }
                    continue;
                }
                throw $e;
            }
        }

        return redirect('/soporte')->with('error', 'No fue posible crear el ticket. Intenta nuevamente.');
    }
}
