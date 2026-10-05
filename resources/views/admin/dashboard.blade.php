@extends('layouts.app')

@section('title', 'Panel de Administración - AsoTV')

@section('content')
<div class="min-h-screen bg-[#f3f4f6] text-slate-900">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900">Panel de Administración</h1>
                <p class="mt-2 text-xl text-slate-600 italic">Gestiona usuarios y asigna roles</p>
            </div>
            <a href="/dashboard" class="hidden md:inline-flex items-center gap-2 px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800 transition font-semibold">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="flex gap-6 items-start">
            <aside class="w-full max-w-[360px] flex-shrink-0 bg-white rounded-xl border border-gray-200 shadow-sm p-5 hidden lg:block">
                <div class="mb-6">
                    <p class="text-lg font-black uppercase tracking-[0.22em] text-gray-800 text-center">Administración</p>
                </div>
                <nav class="space-y-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-red-50 text-red-700 border border-red-200 font-semibold shadow-sm">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-100 text-red-600"><i class="fas fa-user-shield text-sm"></i></span>
                        <span class="text-base">Control de accesos</span>
                    </a>
                    <a href="{{ route('admin.ticket-assignment') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition text-base font-medium">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white text-slate-600 border border-slate-200"><i class="fas fa-user-plus text-sm"></i></span>
                        <span>Asignar técnico</span>
                    </a>
                    <a href="{{ route('admin.validacion') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition text-base font-medium">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white text-slate-600 border border-slate-200"><i class="fas fa-clipboard-check text-sm"></i></span>
                        <span>Control de validación</span>
                    </a>
                    <a href="{{ route('admin.reportes') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition text-base font-medium">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white text-slate-600 border border-slate-200"><i class="fas fa-chart-line text-sm"></i></span>
                        <span>Reportes y analítica</span>
                    </a>
                </nav>
            </aside>

            <main class="flex-1 min-w-0">
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

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                        <h3 class="font-semibold">No se pudo crear la cuenta</h3>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Stats Cards removed as requested -->

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-black text-gray-900">Crear cuenta de usuario</h2>
                        <p class="text-base text-gray-600 mt-1">Clientes, aliados y personal de soporte.</p>
                    </div>

                    <form action="{{ route('admin.store-user') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @csrf
                        <div class="md:col-span-2">
                            <label for="new_name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                            <input type="text" name="name" id="new_name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base">
                        </div>
                        <div class="md:col-span-2">
                            <label for="new_email" class="block text-sm font-semibold text-gray-700 mb-2">Correo electrónico</label>
                            <input type="email" name="email" id="new_email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base">
                        </div>
                        <div class="md:col-span-2">
                            <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">Contraseña</label>
                            <input type="password" name="password" id="new_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base">
                        </div>
                        <div class="md:col-span-2">
                            <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" id="new_password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base">
                        </div>
                        <div class="md:col-span-2">
                            <label for="new_role" class="block text-sm font-semibold text-gray-700 mb-2">Rol</label>
                            <select name="role" id="new_role" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base">
                                <option value="cliente" @selected(old('role', 'cliente') === 'cliente')>Cliente</option>
                                <option value="aliado" @selected(old('role') === 'aliado')>Aliado</option>
                                <option value="tecnico" @selected(old('role') === 'tecnico')>Personal de soporte</option>
                                <option value="administrador" @selected(old('role') === 'administrador')>Administrador</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 w-full text-sm font-medium text-gray-700">
                                <input type="checkbox" name="is_active" value="1" checked class="h-4 w-4 text-blue-600 rounded">
                                <span>Cuenta activa</span>
                            </label>
                        </div>
                        <div class="md:col-span-2 flex justify-end pt-2">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-base">
                                <i class="fas fa-user-plus"></i> Crear cuenta
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
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

            </main>
        </div>
    </div>
</div>
@endsection
