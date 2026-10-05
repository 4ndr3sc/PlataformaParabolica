<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-white text-slate-900 font-sans flex flex-col md:flex-row h-screen">
    <aside class="w-64 bg-slate-50 border-r border-slate-200 hidden md:flex flex-col flex-shrink-0 h-screen fixed md:relative z-50 md:z-auto">
        <div class="p-4 md:p-6 flex-1">
            <div class="flex items-center gap-2 mb-10">
                <span class="text-2xl font-black text-blue-500 tracking-tighter uppercase">ASOTV</span>
                <span class="text-xl font-bold text-yellow-500 uppercase hidden sm:inline">GUACHETA</span>
            </div>

            <nav class="space-y-4">
                <a href="{{ url('/tecnico/asignaciones') }}" class="flex items-center gap-3 p-3 {{ $section === 'asignaciones' ? 'bg-blue-100 text-blue-600 border border-blue-300' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }} rounded-xl transition-all">
                    <i class="fas fa-clipboard-list"></i> <span>Ver asignaciones</span>
                </a>
                <a href="{{ url('/tecnico/historial') }}" class="flex items-center gap-3 p-3 {{ $section === 'historial' ? 'bg-blue-100 text-blue-600 border border-blue-300' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }} rounded-xl transition-all">
                    <i class="fas fa-history"></i> <span>Historial de soporte</span>
                </a>

                <a href="{{ url('/perfil') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-user-cog"></i> <span>Mi Perfil</span>
                </a>
                <a href="{{ url('/app/descargar') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-green-100 hover:text-green-600 rounded-xl transition-all border border-transparent hover:border-green-300">
                    <i class="fas fa-mobile-alt"></i> <span>Aplicación</span>
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-slate-200">
            <a href="{{ url('/logout') }}" class="flex items-center gap-3 p-3 text-red-600 hover:bg-red-100 rounded-xl transition-all font-bold">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <main class="flex-1 w-full h-full p-4 md:p-8 overflow-y-auto">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <p class="text-sm uppercase font-bold tracking-[0.2em] text-blue-600">Panel técnico</p>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 uppercase tracking-tight">{{ $title }}</h1>
            </div>
            <div class="bg-slate-100 border border-slate-300 rounded-full px-4 py-2 text-sm font-bold">
                {{ $user->name }} · Técnico
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach($metrics as $metric)
                <div class="bg-white p-6 rounded-3xl border-b-4 border-{{ $metric['color'] }}-500 shadow-lg border border-slate-200">
                    <p class="text-slate-600 text-sm font-bold uppercase mb-2">{{ $metric['label'] }}</p>
                    <h3 class="text-3xl font-black text-slate-900">{{ $metric['value'] }}</h3>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900 uppercase">{{ $title }}</h2>
                <span class="text-xs font-bold uppercase text-slate-500">{{ $tickets->count() }} registros</span>
            </div>

            @if (session('success'))
                <div class="mx-6 mt-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if($tickets && $tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Ticket</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Cliente</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Asunto</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Estado</th>
                                <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Fecha</th>
                                @if($section === 'asignaciones' || $section === 'estados')
                                    <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-slate-900 font-bold">{{ $ticket->ticket_number }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $ticket->user ? $ticket->user->name : 'Cliente' }}</td>
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
                                    <td class="px-6 py-4 text-slate-600 text-sm">
                                        {{ $ticket->created_at ? $ticket->created_at->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    @if($section === 'asignaciones' || $section === 'estados')
                                        <td class="px-6 py-4">
                                            @if($section === 'asignaciones')
                                                <div class="flex flex-wrap gap-2 mb-2">
                                                    @if($ticket->status !== 'en_progreso')
                                                        <form method="POST" action="{{ url('/tecnico/tickets/' . $ticket->id . '/estado') }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="en_progreso">
                                                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs font-bold uppercase">Marcar en progreso</button>
                                                        </form>
                                                    @endif
                                                    @if($ticket->status !== 'resuelto')
                                                        <form method="POST" action="{{ url('/tecnico/tickets/' . $ticket->id . '/estado') }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="resuelto">
                                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-xs font-bold uppercase">Resolver</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endif
                                            <form method="POST" action="{{ url('/tecnico/tickets/' . $ticket->id . '/estado') }}" class="flex flex-wrap gap-2">
                                                @csrf
                                                <select name="status" class="border border-slate-300 rounded-lg px-3 py-2 text-xs font-bold uppercase bg-white text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none">
                                                    <option value="abierto" {{ $ticket->status === 'abierto' ? 'selected' : '' }}>Abierto</option>
                                                    <option value="en_progreso" {{ $ticket->status === 'en_progreso' ? 'selected' : '' }}>En progreso</option>
                                                    <option value="resuelto" {{ $ticket->status === 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                                                    <option value="cerrado" {{ $ticket->status === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                                                </select>
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-xs font-bold uppercase">Guardar</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center py-12">
                    <i class="fas fa-inbox text-slate-300 text-4xl mb-4 block"></i>
                    <p class="text-slate-600">No hay tickets para mostrar en esta vista.</p>
                </div>
            @endif
        </div>
    </main>
    @include('components.public-chatbot')
</body>
</html>
