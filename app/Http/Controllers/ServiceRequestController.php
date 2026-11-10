<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->isAdministrator() || $user->role === 'cliente', 403);

        $requests = ServiceRequest::with('user')
            ->when(! $user->isAdministrator(), fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->get();

        return view('servicios.index', compact('requests'));
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pendiente,aprobada,rechazada'],
        ]);

        $serviceRequest->update(['status' => $validated['status']]);

        return back()->with('success', 'El estado de la solicitud fue actualizado.');
    }
}
