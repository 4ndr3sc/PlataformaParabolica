<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de servicio | AsoTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900">
    @if(Auth::user()->isAdministrator())
        <nav class="sticky top-0 z-10 overflow-x-auto border-b border-slate-200 bg-white px-4 py-2 shadow-sm">
            @include('components.admin-navigation')
        </nav>
    @endif
    <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <header class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-blue-700">{{ Auth::user()->isAdministrator() ? 'Administración' : 'Mi cuenta' }}</p>
                <h1 class="mt-2 text-3xl font-black">{{ Auth::user()->isAdministrator() ? 'Solicitudes de servicio' : 'Mis servicios solicitados' }}</h1>
                <p class="mt-2 text-slate-600">{{ Auth::user()->isAdministrator() ? 'Consulta las solicitudes y actualiza su estado.' : 'Aquí puedes consultar los planes que solicitaste desde esta cuenta.' }}</p>
            </div>
            @if(!Auth::user()->isAdministrator())
                <a href="{{ url('/planes') }}" class="rounded-xl bg-blue-700 px-5 py-3 font-bold text-white hover:bg-blue-800">Ver planes</a>
            @endif
        </header>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-300 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-red-800">{{ $errors->first() }}</div>
        @endif

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-left text-xs font-bold uppercase text-slate-500">
                        <tr>
                            @if(Auth::user()->isAdministrator())
                                <th class="px-5 py-4">Cliente</th>
                            @endif
                            <th class="px-5 py-4">Servicio</th>
                            <th class="px-5 py-4">Precio mensual</th>
                            <th class="px-5 py-4">Fecha de solicitud</th>
                            <th class="px-5 py-4">Estado</th>
                            @if(Auth::user()->isAdministrator())
                                <th class="px-5 py-4">Acción</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($requests as $serviceRequest)
                            <tr>
                                @if(Auth::user()->isAdministrator())
                                    <td class="px-5 py-4">
                                        <p class="font-bold">{{ $serviceRequest->user->name }}</p>
                                        <p class="text-sm text-slate-500">{{ $serviceRequest->user->email }}</p>
                                    </td>
                                @endif
                                <td class="px-5 py-4 font-semibold">{{ $serviceRequest->service_name }}</td>
                                <td class="px-5 py-4">$ {{ number_format($serviceRequest->amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $serviceRequest->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $serviceRequest->status === 'aprobada' ? 'bg-green-100 text-green-800' : ($serviceRequest->status === 'rechazada' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ ucfirst($serviceRequest->status) }}
                                    </span>
                                </td>
                                @if(Auth::user()->isAdministrator())
                                    <td class="px-5 py-4">
                                        <form method="POST" action="{{ route('admin.service-requests.update', $serviceRequest) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="rounded-lg border border-slate-300 bg-white px-2 py-2 text-sm">
                                                @foreach(['pendiente' => 'Pendiente', 'aprobada' => 'Aprobada', 'rechazada' => 'Rechazada'] as $value => $label)
                                                    <option value="{{ $value }}" @selected($serviceRequest->status === $value)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="rounded-lg bg-blue-700 px-3 py-2 text-sm font-bold text-white hover:bg-blue-800">Guardar</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->isAdministrator() ? 6 : 4 }}" class="px-5 py-12 text-center text-slate-500">
                                    Aún no hay solicitudes.
                                    @if(!Auth::user()->isAdministrator())
                                        <a href="{{ url('/planes') }}" class="font-bold text-blue-700 hover:underline">Explora los planes disponibles.</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
