<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Técnico | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body class="bg-white text-slate-900 font-sans flex flex-col md:flex-row h-screen">

    <aside class="w-64 bg-slate-50 border-r border-slate-200 hidden md:flex flex-col flex-shrink-0 h-screen fixed md:relative z-50 md:z-auto">
        <div class="p-6 flex-1">
            <div class="flex items-center gap-2 mb-10">
                <span class="text-2xl font-black text-blue-500 tracking-tighter uppercase">ASOTV</span>
                <span class="text-xl font-bold text-yellow-500 uppercase">GUACHETA</span>
            </div>
            
            <nav class="space-y-4">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-th-large"></i> <span class="font-bold">Resumen</span>
                </a>
                <a href="{{ url('/facturas') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Mis Facturas</span>
                </a>
                <a href="{{ url('/soporte') }}" class="flex items-center gap-3 p-3 bg-blue-100 text-blue-600 rounded-xl border border-blue-300 shadow-lg shadow-blue-200/50">
                    <i class="fas fa-tools"></i> <span>Soporte Técnico</span>
                </a>
                <a href="{{ url('/perfil') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-user-cog"></i> <span>Mi Perfil</span>
                </a>
                @if(!(Auth::check() && Auth::user()->role === 'administrador'))
                    <a href="{{ url('/app/descargar') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-green-100 hover:text-green-600 rounded-xl transition-all border border-transparent hover:border-green-300">
                        <i class="fas fa-mobile-alt"></i> <span>Aplicación</span>
                    </a>
                @endif
                @if(Auth::check() && Auth::user()->role === 'administrador')
                    <div class="border-t border-slate-300 pt-4 mt-4">
                        <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 p-3 text-red-600 font-bold hover:bg-red-100 rounded-xl transition-all border-2 border-red-300">
                            <i class="fas fa-lock-open"></i> <span>Panel Admin</span>
                        </a>
                    </div>
                @endif
            </nav>
        </div>

        <div class="p-6 border-t border-slate-200">
            <a href="{{ url('/logout') }}" class="flex items-center gap-3 p-3 text-red-600 hover:bg-red-100 rounded-xl transition-all font-bold">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <main class="flex-1 w-full h-full p-4 md:p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight">Soporte <span class="text-yellow-500 italic">Técnico</span></h1>
                <p class="text-slate-600">Crea y gestiona tus tickets de soporte.</p>
            </div>
            
            <div class="flex items-center gap-4 bg-slate-100 p-2 pr-6 rounded-full border border-slate-300">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold shadow-lg overflow-hidden relative">
                    @if(Auth::user()->profile_photo)
                        <img id="profile-image-display" 
                             src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div id="profile-initial-display" class="w-full h-full bg-blue-600 flex items-center justify-center font-bold text-white uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <span class="font-bold text-sm">Estado: <span class="text-green-600">Activo</span></span>
            </div>
        </header>

        <div class="mb-10">
            <a href="{{ url('/soporte/crear') }}" class="inline-flex bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold uppercase text-sm transition-all items-center gap-2">
                <i class="fas fa-plus"></i> Crear Nuevo Ticket
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl border-b-4 border-blue-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-sm font-bold uppercase mb-2">Tickets Abiertos</p>
                <h3 class="text-3xl font-black text-slate-900">{{ $tickets->where('status', 'abierto')->count() }}</h3>
                <p class="text-blue-600 text-xs mt-2 font-bold uppercase">Sin resolver</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border-b-4 border-yellow-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-sm font-bold uppercase mb-2">En Progreso</p>
                <h3 class="text-3xl font-black text-slate-900">{{ $tickets->where('status', 'en_progreso')->count() }}</h3>
                <p class="text-yellow-600 text-xs mt-2 font-bold uppercase">Siendo atendidos</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border-b-4 border-green-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-sm font-bold uppercase mb-2">Resueltos</p>
                <h3 class="text-3xl font-black text-slate-900">{{ $tickets->where('status', 'resuelto')->count() }}</h3>
                <p class="text-green-600 text-xs mt-2 font-bold uppercase">Completados</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 uppercase">Mis Tickets</h2>
            </div>
            
            @if($tickets && $tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Número</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Tipo</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Asunto</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Estado</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Prioridad</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-slate-900 font-bold">{{ $ticket->ticket_number }}</td>
                                    <td class="px-6 py-4 text-slate-600 uppercase text-xs">
                                        @switch($ticket->type)
                                            @case('peticion')
                                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded font-bold">Petición</span>
                                                @break
                                            @case('queja')
                                                <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded font-bold">Queja</span>
                                                @break
                                            @case('reclamo')
                                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded font-bold">Reclamo</span>
                                                @break
                                            @default
                                                <span class="bg-slate-200 text-slate-600 px-2 py-1 rounded font-bold">General</span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $ticket->subject }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'abierto' => 'bg-blue-100 text-blue-600',
                                                'en_progreso' => 'bg-yellow-100 text-yellow-600',
                                                'resuelto' => 'bg-green-100 text-green-600',
                                                'cerrado' => 'bg-slate-200 text-slate-600'
                                            ];
                                        @endphp
                                        <span class="{{ $statusClasses[$ticket->status] ?? 'bg-slate-200 text-slate-600' }} px-2 py-1 rounded text-xs font-bold uppercase">
                                            {{ str_replace('_', ' ', $ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $priorityColors = ['baja' => 'text-green-600', 'media' => 'text-yellow-600', 'alta' => 'text-red-600'];
                                        @endphp
                                        <span class="{{ $priorityColors[$ticket->priority] ?? 'text-slate-600' }} font-bold uppercase text-xs">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 text-sm">
                                        {{ $ticket->created_at ? $ticket->created_at->format('d/m/Y') : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center py-12">
                    <i class="fas fa-inbox text-slate-300 text-4xl mb-4 block"></i>
                    <p class="text-slate-600">No tienes tickets creados en este momento.</p>
                    <p class="text-slate-500 text-sm mt-2">Si tienes algún problema, crea un nuevo ticket para que nuestro equipo pueda ayudarte.</p>
                </div>
            @endif
        </div>

        <div class="mt-10 bg-gradient-to-r from-green-500 to-green-400 p-8 rounded-3xl shadow-2xl">
            <h3 class="text-xl font-black text-white uppercase mb-4">¿Necesitas Ayuda?</h3>
            <p class="text-white mb-6">Nuestro equipo de soporte está disponible para atender tus requerimientos técnicos en Guachetá.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-phone text-yellow-300 text-xl"></i>
                    <div>
                        <p class="text-white text-xs uppercase">Teléfono</p>
                        <p class="text-white font-bold">+57 3208344845</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope text-yellow-300 text-xl"></i>
                    <div>
                        <p class="text-white text-xs uppercase">Email</p>
                        <p class="text-white font-bold">soporte@asotv.com</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-clock text-yellow-300 text-xl"></i>
                    <div>
                        <p class="text-white text-xs uppercase">Horario</p>
                        <p class="text-white font-bold">Lun - Vie | 8AM - 5PM</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/profile-photo-upload.js') }}"></script>
</body>
</html>