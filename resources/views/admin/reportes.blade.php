@extends('layouts.app')

@section('title', 'Reportes y analítica - AsoTV')

@section('content')
<div class="min-h-screen bg-slate-100 text-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <p class="text-sm uppercase font-bold tracking-[0.2em] text-blue-600">Panel administrativo</p>
                <h1 class="text-3xl md:text-4xl font-black uppercase tracking-tight text-slate-900">Informes periódicos</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700 text-white rounded-xl hover:bg-slate-800 transition-all font-semibold shadow-sm">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-5 md:p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Generar informes periódicos</h2>
                    <p class="text-sm text-slate-600 mt-1">Resumen del rendimiento de ventas, uso de boletos y comportamiento del usuario.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('admin.reportes') }}" class="flex items-center gap-3">
                        <label for="period" class="text-sm font-semibold text-slate-700">Periodo</label>
                        <select id="period" name="period" onchange="this.form.submit()" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="7" {{ $periodDays == 7 ? 'selected' : '' }}>7 días</option>
                            <option value="30" {{ $periodDays == 30 ? 'selected' : '' }}>30 días</option>
                            <option value="60" {{ $periodDays == 60 ? 'selected' : '' }}>60 días</option>
                            <option value="90" {{ $periodDays == 90 ? 'selected' : '' }}>90 días</option>
                        </select>
                    </form>
                    <a href="{{ route('admin.reportes.export', ['period' => $periodDays]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all font-semibold shadow-sm">
                        <i class="fas fa-download"></i> Exportar CSV
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 md:gap-6 mb-8">
            <div class="bg-white p-5 md:p-6 rounded-3xl border-b-4 border-blue-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-xs md:text-sm font-bold uppercase mb-2">Rendimiento de ventas</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ $salesPerformance['newUsers'] }}</h3>
                <p class="text-blue-600 text-[10px] md:text-xs mt-2 font-bold uppercase tracking-widest">Nuevos usuarios</p>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-3xl border-b-4 border-green-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-xs md:text-sm font-bold uppercase mb-2">Uso de boletos</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ $ticketUsage['total'] }}</h3>
                <p class="text-green-600 text-[10px] md:text-xs mt-2 font-bold uppercase tracking-widest">Tickets registrados</p>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-3xl border-b-4 border-yellow-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-xs md:text-sm font-bold uppercase mb-2">Comportamiento</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ $userBehavior['usuariosActivos'] }}</h3>
                <p class="text-yellow-600 text-[10px] md:text-xs mt-2 font-bold uppercase tracking-widest">Usuarios activos</p>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-3xl border-b-4 border-red-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-xs md:text-sm font-bold uppercase mb-2">Tasa de conversión</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ $salesPerformance['conversionRate'] }}%</h3>
                <p class="text-red-600 text-[10px] md:text-xs mt-2 font-bold uppercase tracking-widest">Último periodo</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-bold uppercase text-slate-900 mb-4">Rendimiento de ventas</h3>
                <ul class="space-y-4">
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">Nuevos usuarios</span>
                        <span class="font-bold text-slate-900">{{ $salesPerformance['newUsers'] }}</span>
                    </li>
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">Usuarios activos</span>
                        <span class="font-bold text-slate-900">{{ $salesPerformance['activeUsers'] }}</span>
                    </li>
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">Tickets creados</span>
                        <span class="font-bold text-slate-900">{{ $salesPerformance['ticketsCreated'] }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-slate-600">Tickets resueltos</span>
                        <span class="font-bold text-slate-900">{{ $salesPerformance['ticketsResolved'] }}</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-bold uppercase text-slate-900 mb-4">Uso de boletos</h3>
                <ul class="space-y-4">
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">Abiertos</span>
                        <span class="font-bold text-slate-900">{{ $ticketUsage['abiertos'] }}</span>
                    </li>
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">En progreso</span>
                        <span class="font-bold text-slate-900">{{ $ticketUsage['enProgreso'] }}</span>
                    </li>
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">Resueltos</span>
                        <span class="font-bold text-slate-900">{{ $ticketUsage['resueltos'] }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-slate-600">Cerrados</span>
                        <span class="font-bold text-slate-900">{{ $ticketUsage['cerrados'] }}</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-bold uppercase text-slate-900 mb-4">Comportamiento del usuario</h3>
                <ul class="space-y-4">
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">Nuevos</span>
                        <span class="font-bold text-slate-900">{{ $userBehavior['nuevos'] }}</span>
                    </li>
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">Tickets por usuario</span>
                        <span class="font-bold text-slate-900">{{ $userBehavior['ticketsPorUsuario'] }}</span>
                    </li>
                    <li class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <span class="text-slate-600">Sin actividad</span>
                        <span class="font-bold text-slate-900">{{ $userBehavior['usuariosSinActividad'] }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-slate-600">Usuarios activos</span>
                        <span class="font-bold text-slate-900">{{ $userBehavior['usuariosActivos'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-bold uppercase text-slate-900 mb-4">Comparativa del periodo</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 uppercase text-xs font-bold">
                            <th class="px-4 py-3">Métrica</th>
                            <th class="px-4 py-3">Este mes</th>
                            <th class="px-4 py-3">Últimos 30 días</th>
                            <th class="px-4 py-3">Total acumulado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $row)
                            <tr class="border-b border-slate-200">
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $row['label'] }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $row['ventas'] }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $row['boletos'] }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $row['usuarios'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
