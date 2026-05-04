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
<body class="bg-white text-slate-900 font-sans flex flex-col md:flex-row h-screen">

    <aside class="w-64 bg-slate-50 border-r border-slate-200 hidden md:flex flex-col flex-shrink-0 h-screen fixed md:relative z-50 md:z-auto">
        <div class="p-6 flex-1">
            <div class="flex items-center gap-2 mb-10">
                <span class="text-2xl font-black text-blue-500 tracking-tighter uppercase">ASOTV</span>
                <span class="text-xl font-bold text-yellow-500 uppercase">GUACHETA </span>
            </div>
            
            <nav class="space-y-4">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-th-large"></i> <span class="font-bold">Resumen</span>
                </a>
                <a href="{{ url('/facturas') }}" class="flex items-center gap-3 p-3 bg-blue-100 text-blue-600 rounded-xl border border-blue-300 shadow-lg shadow-blue-200/50">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Mis Facturas</span>
                </a>
                <a href="{{ url('/soporte') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-tools"></i> <span>Soporte Técnico</span>
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
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight">Mis <span class="text-yellow-500 italic">Facturas</span></h1>
                <p class="text-slate-600">Revisa el historial de tus facturas y pagos.</p>
            </div>
            <div class="flex items-center gap-4 bg-slate-100 p-2 pr-6 rounded-full border border-slate-300">
                <div class="photo-upload-trigger w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold shadow-lg overflow-hidden relative">
                    <img id="profile-image-display" 
                         src="{{ (Auth::check() && Auth::user()->profile_photo) ? asset('storage/' . Auth::user()->profile_photo) : '' }}" 
                         class="w-full h-full object-cover {{ (Auth::check() && Auth::user()->profile_photo) ? '' : 'hidden' }}">
                    <div id="profile-initial-display" 
                         class="w-full h-full bg-blue-600 flex items-center justify-center font-bold {{ (Auth::check() && Auth::user()->profile_photo) ? 'hidden' : '' }}">
                         {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                </div>
                <span class="font-bold text-sm">Estado: <span class="text-green-600">Activo</span></span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl border-b-4 border-green-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-sm font-bold uppercase mb-2">Total Pagado</p>
                <h3 class="text-2xl font-black text-slate-900">$ 191.600</h3>
                <p class="text-green-600 text-xs mt-2 font-bold uppercase">Año 2026</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border-b-4 border-yellow-500 shadow-lg border border-slate-200">
                <p class="text-slate-600 text-sm font-bold uppercase mb-2">Próximo Pago</p>
                <h3 class="text-2xl font-black text-slate-900">$ 47.900</h3>
                <p class="text-yellow-600 text-xs mt-2 font-bold uppercase">Vence en 27 días</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 uppercase">Facturas Recientes</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Número</th>
                            <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Fecha</th>
                            <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Período</th>
                            <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Valor</th>
                            <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Estado</th>
                            <th class="px-6 py-4 text-left text-slate-600 font-bold uppercase text-xs">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-900 font-bold">#2026-001</td>
                            <td class="px-6 py-4 text-slate-600">01/05/2026</td>
                            <td class="px-6 py-4 text-slate-600">Mayo 2026</td>
                            <td class="px-6 py-4 text-slate-900 font-bold">$ 47.900</td>
                            <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-bold">Pendiente</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-600 hover:text-blue-700 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-900 font-bold">#2026-002</td>
                            <td class="px-6 py-4 text-slate-600">01/04/2026</td>
                            <td class="px-6 py-4 text-slate-600">Abril 2026</td>
                            <td class="px-6 py-4 text-slate-900 font-bold">$ 47.900</td>
                           <td class="px-6 py-4"><span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Pagada</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-600 hover:text-blue-700 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-900 font-bold">#2026-003</td>
                            <td class="px-6 py-4 text-slate-600">01/03/2026</td>
                            <td class="px-6 py-4 text-slate-600">Marzo 2026</td>
                            <td class="px-6 py-4 text-slate-900 font-bold">$ 47.900</td>
                            <td class="px-6 py-4"><span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Pagada</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-600 hover:text-blue-700 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-900 font-bold">#2026-004</td>
                            <td class="px-6 py-4 text-slate-600">01/02/2026</td>
                            <td class="px-6 py-4 text-slate-600">Febrero 2026</td>
                            <td class="px-6 py-4 text-slate-900 font-bold">$ 47.900</td>
                            <td class="px-6 py-4"><span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Pagada</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-600 hover:text-blue-700 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-900 font-bold">#2026-005</td>
                            <td class="px-6 py-4 text-slate-600">01/01/2026</td>
                            <td class="px-6 py-4 text-slate-600">Enero 2026</td>
                            <td class="px-6 py-4 text-slate-900 font-bold">$ 47.900</td>
                            <td class="px-6 py-4"><span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Pagada</span></td>
                            <td class="px-6 py-4"><a href="#" class="text-blue-600 hover:text-blue-700 font-bold"><i class="fas fa-download"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/profile-photo-upload.js') }}"></script>

</body>
</html>
