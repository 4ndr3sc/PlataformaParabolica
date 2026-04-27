<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Facturas | AsoTV Guachetá</title>
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
<body class="bg-slate-900 text-slate-100 font-sans flex flex-col md:flex-row h-screen">

    <aside class="w-64 bg-slate-950 border-r border-slate-800 hidden md:flex flex-col flex-shrink-0 h-screen fixed md:relative z-50 md:z-auto">
        <div class="p-6 flex-1">
            <div class="flex items-center gap-2 mb-10">
                <span class="text-2xl font-black text-blue-500 tracking-tighter uppercase">ASOTV</span>
                <span class="text-xl font-bold text-yellow-500 uppercase">GUACHETA </span>
            </div>
            
            <nav class="space-y-4">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-th-large"></i> <span class="font-bold">Resumen</span>
                </a>
                <a href="{{ url('/facturas') }}" class="flex items-center gap-3 p-3 bg-blue-600/20 text-blue-400 rounded-xl border border-blue-600/50 shadow-lg shadow-blue-900/20">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Mis Facturas</span>
                </a>
                <a href="{{ url('/soporte') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-tools"></i> <span>Soporte Técnico</span>
                </a>
                <a href="{{ url('/perfil') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-user-cog"></i> <span>Mi Perfil</span>
                </a>
                <a href="{{ url('/app/descargar') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-green-500/20 hover:text-green-400 rounded-xl transition-all border border-transparent hover:border-green-500/50">
                    <i class="fas fa-mobile-alt"></i> <span>Aplicación</span>
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-slate-800">
            <a href="{{ url('/logout') }}" class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition-all font-bold">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <main class="flex-1 w-full h-full p-4 md:p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-white uppercase tracking-tight">Mis <span class="text-yellow-500 italic">Facturas</span></h1>
                <p class="text-slate-400">Revisa el historial de tus facturas y pagos.</p>
            </div>
            <div class="flex items-center gap-4 bg-slate-800 p-2 pr-6 rounded-full border border-slate-700">
                <div class="photo-upload-trigger w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold shadow-lg overflow-hidden relative">
                    <img id="profile-image-display" 
                         src="{{ (Auth::check() && Auth::user()->profile_photo) ? asset('storage/' . Auth::user()->profile_photo) : '' }}" 
                         class="w-full h-full object-cover {{ (Auth::check() && Auth::user()->profile_photo) ? '' : 'hidden' }}">
                    <div id="profile-initial-display" 
                         class="w-full h-full bg-blue-600 flex items-center justify-center font-bold {{ (Auth::check() && Auth::user()->profile_photo) ? 'hidden' : '' }}">
                         {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                </div>
                <span class="font-bold text-sm">Estado: <span class="text-green-400">Activo</span></span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-slate-800 p-6 rounded-3xl border-b-4 border-green-500 shadow-xl">
                <p class="text-slate-400 text-sm font-bold uppercase mb-2">Total Pagado</p>
                <h3 class="text-2xl font-black text-white">$ 260.000</h3>
                <p class="text-green-400 text-xs mt-2 font-bold uppercase">Año 2026</p>
            </div>
            <div class="bg-slate-800 p-6 rounded-3xl border-b-4 border-yellow-500 shadow-xl">
                <p class="text-slate-400 text-sm font-bold uppercase mb-2">Próximo Pago</p>
                <h3 class="text-2xl font-black text-white">$ 65.000</h3>
                <p class="text-yellow-500 text-xs mt-2 font-bold uppercase">Vence en 5 días</p>
            </div>
        </div>

        <div class="bg-slate-800 rounded-3xl shadow-xl overflow-hidden border border-slate-700">
            <div class="p-6 border-b border-slate-700">
                <h2 class="text-xl font-bold text-white uppercase">Facturas Recientes</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-slate-400 font-bold uppercase text-xs">Número</th>
                            <th class="px-6 py-4 text-left text-slate-400 font-bold uppercase text-xs">Fecha</th>
                            <th class="px-6 py-4 text-left text-slate-400 font-bold uppercase text-xs">Período</th>
                            <th class="px-6 py-4 text-left text-slate-400 font-bold uppercase text-xs">Valor</th>
                            <th class="px-6 py-4 text-left text-slate-400 font-bold uppercase text-xs">Estado</th>
                            <th class="px-6 py-4 text-left text-slate-400 font-bold uppercase text-xs">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4 text-white font-bold">#2026-001</td>
                            <td class="px-6 py-4 text-slate-300">01/04/2026</td>
                            <td class="px-6 py-4 text-slate-300">Abril 2026</td>
                            <td class="px-6 py-4 text-white font-bold">$ 65.000</td>
                            <td class="px-6 py-4"><span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-xs font-bold">Pendiente</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-400 hover:text-blue-300 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4 text-white font-bold">#2026-002</td>
                            <td class="px-6 py-4 text-slate-300">01/03/2026</td>
                            <td class="px-6 py-4 text-slate-300">Marzo 2026</td>
                            <td class="px-6 py-4 text-white font-bold">$ 65.000</td>
                            <td class="px-6 py-4"><span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-bold">Pagada</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-400 hover:text-blue-300 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4 text-white font-bold">#2026-003</td>
                            <td class="px-6 py-4 text-slate-300">01/02/2026</td>
                            <td class="px-6 py-4 text-slate-300">Febrero 2026</td>
                            <td class="px-6 py-4 text-white font-bold">$ 65.000</td>
                            <td class="px-6 py-4"><span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-bold">Pagada</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-400 hover:text-blue-300 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4 text-white font-bold">#2026-004</td>
                            <td class="px-6 py-4 text-slate-300">01/01/2026</td>
                            <td class="px-6 py-4 text-slate-300">Enero 2026</td>
                            <td class="px-6 py-4 text-white font-bold">$ 65.000</td>
                            <td class="px-6 py-4"><span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-bold">Pagada</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-400 hover:text-blue-300 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/profile-photo-upload.js') }}"></script>

</body>
</html>
