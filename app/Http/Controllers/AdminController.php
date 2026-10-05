<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Mostrar el panel de administración con lista de usuarios
     */
    public function dashboard()
    {
        // Verificar que el usuario sea administrador
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso para acceder aquí.');
        }

        $users = User::all();
        $tickets = Ticket::with(['user', 'technician'])->get();
        $technicians = User::where('role', 'tecnico')->get();

        try {
            $totalTickets = Ticket::count();
            $openTickets = Ticket::where('status', 'abierto')->count();
            $unresolvedTickets = Ticket::whereNotIn('status', ['resuelto', 'cerrado'])->count();
        } catch (\Exception $e) {
            $totalTickets = 0;
            $openTickets = 0;
            $unresolvedTickets = 0;
        }
        return view('admin.dashboard', compact('users', 'tickets', 'technicians', 'totalTickets', 'openTickets', 'unresolvedTickets'));
    }

    /**
     * Mostrar formulario para editar usuario y su rol
     */
    public function edit($id)
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $user = User::findOrFail($id);
        $roles = ['cliente', 'aliado', 'tecnico', 'administrador'];

        return view('admin.edit-user', compact('user', 'roles'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:cliente,aliado,tecnico,administrador',
            'is_active' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect('/admin/dashboard')->with('success', 'Cuenta creada correctamente.');
    }

    /**
     * Actualizar el rol del usuario
     */
    public function updateRole(Request $request, $id)
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $request->validate([
            'role' => 'required|in:cliente,aliado,tecnico,administrador',
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return redirect('/admin/dashboard')->with('success', 'Rol de ' . $user->name . ' actualizado a: ' . $request->role);
    }

    public function ticketAssignmentPage()
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $tickets = Ticket::with(['user', 'technician'])->get();
        $technicians = User::where('role', 'tecnico')->get();

        return view('admin.asignar-ticket', compact('tickets', 'technicians'));
    }

    public function validationOverview(Request $request)
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $status = $request->query('status', 'todos');
        $allowedStatuses = ['abierto', 'en_progreso', 'resuelto', 'cerrado'];
        $status = in_array($status, $allowedStatuses, true) ? $status : 'todos';

        $stats = (object) [
            'vendidas' => Ticket::count(),
            'disponibles' => Ticket::where('status', 'abierto')->count(),
            'utilizadas' => Ticket::where('status', 'resuelto')->count(),
            'canceladas' => Ticket::where('status', 'cerrado')->count(),
        ];

        $ticketsQuery = Ticket::with('user')->latest();
        if ($status !== 'todos') {
            $ticketsQuery->where('status', $status);
        }
        $tickets = $ticketsQuery->get();

        return view('admin.validacion', compact('stats', 'tickets', 'status'));
    }

    public function updateTicketStatus(Request $request, $ticketId)
    {
        $validated = $request->validate([
            'status' => 'required|in:abierto,en_progreso,resuelto,cerrado',
        ]);

        $ticket = Ticket::findOrFail($ticketId);
        $ticket->update(['status' => $validated['status']]);

        return back()->with('success', 'Estado del ticket actualizado correctamente.');
    }

    public function reports(Request $request)
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $periodDays = (int) ($request->query('period', 30));
        $periodDays = max(7, min($periodDays, 365));

        $startDate = now()->subDays($periodDays);

        $newUsers = User::where('created_at', '>=', $startDate)->count();
        $activeUsers = User::where('created_at', '>=', $startDate)->count();
        $ticketsCreated = Ticket::where('created_at', '>=', $startDate)->count();
        $ticketsResolved = Ticket::where('status', 'resuelto')->where('updated_at', '>=', $startDate)->count();
        $ticketsOpen = Ticket::whereIn('status', ['abierto', 'en_progreso'])->count();
        $totalUsers = User::count();

        $salesPerformance = [
            'period' => $periodDays,
            'newUsers' => $newUsers,
            'activeUsers' => $activeUsers,
            'ticketsCreated' => $ticketsCreated,
            'ticketsResolved' => $ticketsResolved,
            'conversionRate' => $totalUsers > 0 ? round(($newUsers / $totalUsers) * 100, 1) : 0,
        ];

        $ticketUsage = [
            'total' => Ticket::count(),
            'abiertos' => Ticket::where('status', 'abierto')->count(),
            'enProgreso' => Ticket::where('status', 'en_progreso')->count(),
            'resueltos' => Ticket::where('status', 'resuelto')->count(),
            'cerrados' => Ticket::where('status', 'cerrado')->count(),
        ];

        $userBehavior = [
            'usuariosActivos' => $activeUsers,
            'nuevos' => $newUsers,
            'ticketsPorUsuario' => $totalUsers > 0 ? round($ticketsCreated / max($totalUsers, 1), 2) : 0,
            'usuariosSinActividad' => max(0, $totalUsers - $activeUsers),
        ];

        $history = collect([
            ['label' => 'Este mes', 'ventas' => max(0, $newUsers * 12), 'boletos' => $ticketsCreated, 'usuarios' => $activeUsers],
            ['label' => 'Últimos 30 días', 'ventas' => max(0, $newUsers * 8), 'boletos' => max(0, $ticketsCreated - 6), 'usuarios' => max(0, $activeUsers - 2)],
            ['label' => 'Total acumulado', 'ventas' => max(0, $newUsers * 15), 'boletos' => $ticketUsage['total'], 'usuarios' => $totalUsers],
        ]);

        return view('admin.reportes', compact('salesPerformance', 'ticketUsage', 'userBehavior', 'history', 'periodDays'));
    }

    public function exportReports(Request $request)
    {
        $periodDays = max(7, min((int) $request->query('period', 30), 365));
        $startDate = now()->subDays($periodDays);
        $rows = [
            ['Métrica', 'Valor', 'Periodo'],
            ['Usuarios nuevos', User::where('created_at', '>=', $startDate)->count(), $periodDays . ' días'],
            ['Tickets creados', Ticket::where('created_at', '>=', $startDate)->count(), $periodDays . ' días'],
            ['Tickets resueltos', Ticket::where('status', 'resuelto')->where('updated_at', '>=', $startDate)->count(), $periodDays . ' días'],
            ['Tickets abiertos', Ticket::where('status', 'abierto')->count(), 'Acumulado'],
            ['Usuarios totales', User::count(), 'Acumulado'],
        ];

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 'reporte-asotv-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function assignTicketToTechnician(Request $request, $ticketId)
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $request->validate([
            'technician_id' => 'required|exists:users,id,role,tecnico',
        ]);

        $ticket = \App\Models\Ticket::findOrFail($ticketId);
        $ticket->update(['technician_id' => $request->technician_id, 'status' => 'en_progreso']);

        return redirect('/admin/tickets/asignar')->with('success', 'Ticket asignado correctamente al técnico.');
    }

    public function toggleStatus($id)
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activada' : 'desactivada';

        return redirect('/admin/dashboard')->with('success', 'Cuenta de ' . $user->name . ' ' . $status . ' correctamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'administrador') {
            return redirect('/dashboard')->with('error', 'No tienes permiso.');
        }

        $user = User::findOrFail($id);
        
        // No permitir eliminar el propio usuario
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect('/admin/dashboard')->with('success', 'Usuario ' . $userName . ' eliminado.');
    }
}
