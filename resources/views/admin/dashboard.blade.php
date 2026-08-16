@extends('layouts.app')

@section('title', 'Panel de Administración - AsoTV')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
                    <p class="text-gray-600 mt-1">Gestiona usuarios y asigna roles</p>
                </div>
                <a href="/dashboard" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alerts -->
        @if ($message = Session::get('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle mt-0.5 text-green-600"></i>
                <div>
                    <h3 class="font-semibold">Éxito</h3>
                    <p class="text-sm">{{ $message }}</p>
                </div>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
                <div>
                    <h3 class="font-semibold">Error</h3>
                    <p class="text-sm">{{ $message }}</p>
                </div>
            </div>
        @endif

        <!-- Stats Cards removed as requested -->

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Usuarios Registrados</h2>
            </div>

            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Teléfono</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rol</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->phone ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                            @if($user->role === 'administrador')
                                                bg-red-100 text-red-800
                                            @elseif($user->role === 'tecnico')
                                                bg-blue-100 text-blue-800
                                            @else
                                                bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.edit-user', $user->id) }}" 
                                               class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            @if($user->id !== Auth::id())
                                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition"
                                                        onclick="return confirm('¿Está seguro de que desea eliminar este usuario?');">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-200 text-gray-600 text-xs rounded cursor-not-allowed">
                                                    <i class="fas fa-lock"></i> Tu cuenta
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4 block"></i>
                    <p class="text-gray-500">No hay usuarios registrados</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
