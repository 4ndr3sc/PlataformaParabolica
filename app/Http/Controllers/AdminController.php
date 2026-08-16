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
        // Métricas de tickets
        try {
            $totalTickets = Ticket::count();
            $openTickets = Ticket::where('status', 'abierto')->count();
            $unresolvedTickets = Ticket::whereNotIn('status', ['resuelto', 'cerrado'])->count();
        } catch (\Exception $e) {
            $totalTickets = 0;
            $openTickets = 0;
            $unresolvedTickets = 0;
        }
        return view('admin.dashboard', compact('users', 'totalTickets', 'openTickets', 'unresolvedTickets'));
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
        $roles = ['cliente', 'administrador', 'tecnico'];

        return view('admin.edit-user', compact('user', 'roles'));
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
            'role' => 'required|in:cliente,administrador,tecnico',
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return redirect('/admin/dashboard')->with('success', 'Rol de ' . $user->name . ' actualizado a: ' . $request->role);
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
