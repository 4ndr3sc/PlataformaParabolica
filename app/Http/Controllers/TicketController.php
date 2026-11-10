<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    public function updateInformation(Request $request, Ticket $ticket)
    {
        abort_unless($ticket->user_id === Auth::id(), 403);
        abort_if(in_array($ticket->status, ['resuelto', 'cerrado'], true), 403, 'No puedes editar una PQR cerrada.');

        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20', 'max:10000'],
        ]);

        $ticket->update($validated);

        return redirect('/soporte')->with('success', 'La información de tu PQR fue actualizada.');
    }

    public function updateTechnicianReport(Request $request, $id)
    {
        $validated = $request->validate([
            'technician_comment' => ['required', 'string', 'max:5000'],
            'technician_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $ticket = Ticket::where('id', $id)
            ->where('technician_id', Auth::id())
            ->firstOrFail();

        $previousPhoto = $ticket->technician_photo;
        if ($request->hasFile('technician_photo')) {
            $newPhoto = $request->file('technician_photo')->store('ticket_reports', 'public');
            if (!$newPhoto) {
                throw new \RuntimeException('No fue posible guardar la foto del reporte técnico.');
            }
            $ticket->technician_photo = $newPhoto;
        }

        $ticket->technician_comment = $validated['technician_comment'];
        $ticket->save();

        if ($request->hasFile('technician_photo') && $previousPhoto && !Storage::disk('public')->delete($previousPhoto)) {
            Log::warning('No se pudo eliminar la foto anterior del reporte técnico.', [
                'ticket_id' => $ticket->id,
                'photo_path' => $previousPhoto,
            ]);
        }

        return back()->with('success', 'El reporte técnico fue guardado correctamente.');
    }
}
