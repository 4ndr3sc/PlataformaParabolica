@extends('layouts.app')

@section('title', 'Asignar técnico - AsoTV')

@section('content')
<div class="min-h-screen bg-slate-100 text-slate-900">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 p-6 text-white shadow-xl md:p-8">
            <div class="relative z-10 flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-blue-200">Operaciones de soporte</p>
                    <h1 class="text-3xl font-black md:text-4xl">Asignar técnico</h1>
                    <p class="mt-2 text-blue-100">Distribuye las solicitudes entre el personal de soporte.</p>
                </div>
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/20 bg-white/10 text-2xl text-amber-300"><i class="fas fa-user-plus"></i></span>
            </div>
            <div aria-hidden="true" class="absolute -right-10 -top-20 h-64 w-64 rounded-full border-[32px] border-white/5"></div>
        </header>

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

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                <div>
                    <h2 class="text-xl font-black text-slate-900">Solicitudes de soporte</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $tickets->count() }} tickets</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><i class="fas fa-ticket-alt"></i></span>
            </div>

            @if($tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ticket</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Técnico asignado</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Asignar técnico</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($tickets as $ticket)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $ticket->ticket_number }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $ticket->user ? $ticket->user->name : 'Cliente' }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ str_replace('_', ' ', $ticket->status) }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $ticket->technician ? $ticket->technician->name : 'Sin asignar' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <form action="{{ route('admin.assign-ticket', $ticket->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <select name="technician_id" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                                <option value="">Seleccionar técnico</option>
                                                @foreach($technicians as $technician)
                                                    <option value="{{ $technician->id }}" {{ $ticket->technician_id == $technician->id ? 'selected' : '' }}>
                                                        {{ $technician->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-bold uppercase text-white transition hover:bg-blue-700">
                                                Asignar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-inbox mb-4 block text-4xl text-slate-300"></i>
                    <p class="font-semibold text-slate-600">No hay tickets para asignar.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
