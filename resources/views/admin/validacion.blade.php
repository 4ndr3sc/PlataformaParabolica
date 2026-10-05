@extends('layouts.app')

@section('title', 'Control de validación - AsoTV')

@section('content')
<div class="min-h-screen bg-slate-100 text-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <p class="text-sm uppercase font-bold tracking-[0.2em] text-blue-600">Panel administrativo</p>
                <h1 class="text-3xl md:text-4xl font-black uppercase tracking-tight text-slate-900">Control de validación</h1>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700 text-white rounded-xl hover:bg-slate-800 transition-all font-semibold shadow-sm">
                <i class="fas fa-arrow-left"></i> Volver al panel
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 md:gap-6 mb-8">
            <div class="bg-white p-5 md:p-6 rounded-3xl border-b-4 border-blue-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-xs md:text-sm font-bold uppercase mb-2">Vendidas</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ $stats->vendidas }}</h3>
                <p class="text-blue-600 text-[10px] md:text-xs mt-2 font-bold uppercase tracking-widest">Entradas cobradas</p>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-3xl border-b-4 border-green-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-xs md:text-sm font-bold uppercase mb-2">Disponibles</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ $stats->disponibles }}</h3>
                <p class="text-green-600 text-[10px] md:text-xs mt-2 font-bold uppercase tracking-widest">Listas para uso</p>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-3xl border-b-4 border-yellow-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-xs md:text-sm font-bold uppercase mb-2">Utilizadas</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ $stats->utilizadas }}</h3>
                <p class="text-yellow-600 text-[10px] md:text-xs mt-2 font-bold uppercase tracking-widest">Ya consumidas</p>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-3xl border-b-4 border-red-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-xs md:text-sm font-bold uppercase mb-2">Canceladas</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ $stats->canceladas }}</h3>
                <p class="text-red-600 text-[10px] md:text-xs mt-2 font-bold uppercase tracking-widest">Anuladas</p>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center gap-3">
                <i class="fas fa-check-circle text-green-600"></i><span>{{ $message }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden mb-8">
            <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 uppercase">Tickets para validar</h2>
                    <p class="text-sm text-slate-600 mt-1">Revisa y actualiza el estado de cada solicitud.</p>
                </div>
                <form method="GET" action="{{ route('admin.validacion') }}" class="flex items-center gap-3">
                    <label for="status" class="text-sm font-semibold text-slate-700">Filtrar</label>
                    <select id="status" name="status" onchange="this.form.submit()" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="todos" @selected($status === 'todos')>Todos</option>
                        <option value="abierto" @selected($status === 'abierto')>Abiertos</option>
                        <option value="en_progreso" @selected($status === 'en_progreso')>En progreso</option>
                        <option value="resuelto" @selected($status === 'resuelto')>Resueltos</option>
                        <option value="cerrado" @selected($status === 'cerrado')>Cerrados</option>
                    </select>
                </form>
            </div>
            @if($tickets->isEmpty())
                <p class="p-8 text-center text-slate-500">No hay tickets para este filtro.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-3">Ticket</th>
                                <th class="px-6 py-3">Usuario</th>
                                <th class="px-6 py-3">Asunto</th>
                                <th class="px-6 py-3">Estado</th>
                                <th class="px-6 py-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $ticket->ticket_number }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $ticket->user->name ?? 'Usuario eliminado' }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $ticket->subject }}</td>
                                    <td class="px-6 py-4"><span class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold uppercase">{{ str_replace('_', ' ', $ticket->status) }}</span></td>
                                    <td class="px-6 py-4">
                                        <form method="POST" action="{{ route('admin.update-ticket-status', $ticket->id) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="rounded-lg border border-slate-300 px-2 py-1 text-xs">
                                                @foreach(['abierto' => 'Abierto', 'en_progreso' => 'En progreso', 'resuelto' => 'Resuelto', 'cerrado' => 'Cerrado'] as $value => $label)
                                                    <option value="{{ $value }}" @selected($ticket->status === $value)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-xs font-semibold">
                                                <i class="fas fa-save"></i> Guardar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 uppercase">Supervisión de entradas</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-slate-600 text-xs md:text-sm font-bold uppercase">Vendidas</p>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-ticket-alt"></i>
                        </span>
                    </div>
                    <h3 class="mt-4 text-3xl font-black text-slate-900">{{ $stats->vendidas }}</h3>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-slate-600 text-xs md:text-sm font-bold uppercase">Disponibles</p>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    </div>
                    <h3 class="mt-4 text-3xl font-black text-slate-900">{{ $stats->disponibles }}</h3>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-slate-600 text-xs md:text-sm font-bold uppercase">Utilizadas</p>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-user-check"></i>
                        </span>
                    </div>
                    <h3 class="mt-4 text-3xl font-black text-slate-900">{{ $stats->utilizadas }}</h3>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-slate-600 text-xs md:text-sm font-bold uppercase">Canceladas</p>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    </div>
                    <h3 class="mt-4 text-3xl font-black text-slate-900">{{ $stats->canceladas }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
