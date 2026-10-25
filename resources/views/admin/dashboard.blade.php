@extends('layouts.app')

@section('title', 'Panel de Administración - AsoTV')

@section('content')
<div class="min-h-screen bg-[#f3f4f6] text-slate-900">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <header class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 p-6 text-white shadow-xl md:p-8">
            <div class="relative z-10 flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
                <div>
                    <p class="mb-2 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-widest text-blue-100">
                        <i class="fas fa-shield-alt"></i> Centro de control
                    </p>
                    <h1 class="text-3xl font-black tracking-tight md:text-4xl">Panel de Administración</h1>
                    <p class="mt-2 max-w-2xl text-sm text-blue-100 md:text-base">Gestiona usuarios, permisos y operaciones de AsoTV desde un solo lugar.</p>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-400 text-xl text-slate-950">
                        <i class="fas fa-crown"></i>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-100">Sesión administrativa</p>
                        <p class="font-bold">{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" class="absolute -right-10 -top-20 h-64 w-64 rounded-full border-[32px] border-white/5"></div>
            <div aria-hidden="true" class="absolute -bottom-36 right-48 h-64 w-64 rounded-full border-[32px] border-white/5"></div>
        </header>

        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 border-b-4 border-b-blue-500 bg-white p-5 shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Usuarios registrados</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><i class="fas fa-users"></i></span>
                </div>
                <p class="mt-4 text-3xl font-black text-slate-900">{{ $users->count() }}</p>
                <p class="mt-1 text-sm text-slate-500">Cuentas en la plataforma</p>
            </div>
            <div class="rounded-2xl border border-slate-200 border-b-4 border-b-amber-500 bg-white p-5 shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Tickets registrados</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600"><i class="fas fa-ticket-alt"></i></span>
                </div>
                <p class="mt-4 text-3xl font-black text-slate-900">{{ $totalTickets }}</p>
                <p class="mt-1 text-sm text-slate-500">Solicitudes recibidas</p>
            </div>
            <div class="rounded-2xl border border-slate-200 border-b-4 border-b-green-500 bg-white p-5 shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Tickets abiertos</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-600"><i class="fas fa-folder-open"></i></span>
                </div>
                <p class="mt-4 text-3xl font-black text-slate-900">{{ $openTickets }}</p>
                <p class="mt-1 text-sm text-slate-500">Pendientes de atención</p>
            </div>
            <div class="rounded-2xl border border-slate-200 border-b-4 border-b-violet-500 bg-white p-5 shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Sin resolver</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600"><i class="fas fa-hourglass-half"></i></span>
                </div>
                <p class="mt-4 text-3xl font-black text-slate-900">{{ $unresolvedTickets }}</p>
                <p class="mt-1 text-sm text-slate-500">En proceso o pendientes</p>
            </div>
        </div>

        <main class="min-w-0">
                @if ($message = Session::get('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800">
                        <i class="fas fa-check-circle mt-0.5 text-green-600"></i>
                        <div>
                            <h3 class="font-semibold">Éxito</h3>
                            <p class="text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
                        <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
                        <div>
                            <h3 class="font-semibold">Error</h3>
                            <p class="text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
                        <h3 class="font-semibold">No se pudo crear la cuenta</h3>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-lg md:p-8">
                    <div class="mb-6 flex items-center gap-4 border-b border-slate-100 pb-5">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-xl text-blue-600"><i class="fas fa-user-plus"></i></span>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 md:text-2xl">Crear cuenta de usuario</h2>
                            <p class="mt-1 text-sm text-slate-500">Registra clientes, aliados y personal de AsoTV.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.store-user') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @csrf
                        <div>
                            <label for="new_name" class="mb-2 block text-sm font-semibold text-slate-700">Nombre</label>
                            <input type="text" name="name" id="new_name" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        </div>
                        <div>
                            <label for="new_email" class="mb-2 block text-sm font-semibold text-slate-700">Correo electrónico</label>
                            <input type="email" name="email" id="new_email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        </div>
                        <div>
                            <label for="new_password" class="mb-2 block text-sm font-semibold text-slate-700">Contraseña</label>
                            <input type="password" name="password" id="new_password" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" id="new_password_confirmation" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        </div>
                        <div>
                            <label for="new_role" class="mb-2 block text-sm font-semibold text-slate-700">Rol</label>
                            <select name="role" id="new_role" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-base transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                <option value="cliente" @selected(old('role', 'cliente') === 'cliente')>Cliente</option>
                                <option value="aliado" @selected(old('role') === 'aliado')>Aliado</option>
                                <option value="tecnico" @selected(old('role') === 'tecnico')>Personal de soporte</option>
                                <option value="administrador" @selected(old('role') === 'administrador')>Administrador</option>
                                <option value="superusuario" @selected(old('role') === 'superusuario')>Superusuario</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <label class="flex w-full items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                                <input type="checkbox" name="is_active" value="1" checked class="h-4 w-4 rounded text-blue-600">
                                <span>Cuenta activa</span>
                            </label>
                        </div>
                        <div class="flex justify-end pt-2 md:col-span-2">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-base font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                                <i class="fas fa-user-plus"></i> Crear cuenta
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mb-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg">
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                        <div>
                            <h2 class="text-xl font-black text-slate-900">Usuarios registrados</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $users->count() }} cuentas</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><i class="fas fa-users"></i></span>
                    </div>

                    @if($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-200 bg-slate-50">
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Teléfono</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rol</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($users as $user)
                                        <tr class="transition hover:bg-blue-50/40">
                                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $user->name }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-600">{{ $user->phone ?? 'N/A' }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($user->isAdministrator())
                                                        bg-red-100 text-red-800
                                                    @elseif($user->role === 'tecnico')
                                                        bg-blue-100 text-blue-800
                                                    @elseif($user->role === 'superusuario')
                                                        bg-amber-100 text-amber-800
                                                    @else
                                                        bg-slate-100 text-slate-700
                                                    @endif
                                                ">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('admin.edit-user', $user->id) }}" 
                                                       class="inline-flex items-center gap-1 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    @if($user->id !== Auth::id())
                                                        <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
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
@endsection
