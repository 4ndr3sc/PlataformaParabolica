<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

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

        // Generar número único de ticket
        $ticketNumber = 'TK-' . date('Ymd') . '-' . str_pad(Ticket::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

        // Crear el ticket
        Ticket::create([
            'user_id' => $user->id,
            'ticket_number' => $ticketNumber,
            'type' => $request->type,
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'abierto',
        ]);

        return redirect('/soporte')->with('success', '¡Tu ticket ha sido creado correctamente! Número: ' . $ticketNumber);
    }
}
