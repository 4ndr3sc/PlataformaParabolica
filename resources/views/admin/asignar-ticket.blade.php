@extends('layouts.app')

@section('title', 'Asignar técnico - AsoTV')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Asignar técnico</h1>
                    <p class="text-gray-600 mt-1">Asigna cada ticket a un técnico disponible.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Asignar técnico</h2>
            </div>

            @if($tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ticket</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Técnico asignado</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Asignar técnico</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $ticket->ticket_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $ticket->user ? $ticket->user->name : 'Cliente' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ str_replace('_', ' ', $ticket->status) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $ticket->technician ? $ticket->technician->name : 'Sin asignar' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <form action="{{ route('admin.assign-ticket', $ticket->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <select name="technician_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">Seleccionar técnico</option>
                                                @foreach($technicians as $technician)
                                                    <option value="{{ $technician->id }}" {{ $ticket->technician_id == $technician->id ? 'selected' : '' }}>
                                                        {{ $technician->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-xs font-semibold uppercase">
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
                <div class="p-8 text-center">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4 block"></i>
                    <p class="text-gray-500">No hay tickets para asignar.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
