<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Ticket | AsoTV Guachetá</title>
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
                <a href="{{ url('/facturas') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Mis Facturas</span>
                </a>
                <a href="{{ url('/soporte') }}" class="flex items-center gap-3 p-3 bg-blue-600/20 text-blue-400 rounded-xl border border-blue-600/50 shadow-lg shadow-blue-900/20">
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
                <h1 class="text-3xl font-extrabold text-white uppercase tracking-tight">Crear <span class="text-yellow-500 italic">Nuevo Ticket</span></h1>
                <p class="text-slate-400">Reporta tu petición, queja o reclamo.</p>
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

        <div class="max-w-3xl">
            <a href="{{ url('/soporte') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 mb-6">
                <i class="fas fa-arrow-left"></i> Volver a Soporte
            </a>

            <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden p-8">
                <form action="{{ url('/ticket/crear') }}" method="POST" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-xl">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Tipo de PQR</label>
                            <select name="type" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                                <option value="">Selecciona un tipo</option>
                                <option value="peticion">Falla tecnica</option>
                                <option value="queja">Facturacion</option>
                                <option value="reclamo">Sugerencia</option>
                                <option value="reclamo">Otros</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Prioridad</label>
                            <select name="priority" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                                <option value="">Selecciona una prioridad</option>
                                <option value="baja">Baja</option>
                                <option value="media" selected>Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Asunto</label>
                        <input type="text" name="subject" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Breve descripción del tema" required maxlength="255">
                    </div>

                    <div>
                        <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Descripción Detallada</label>
                        <textarea name="description" rows="8" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Describe en detalle tu petición, queja o reclamo. Incluye información relevante como fechas, horarios, etc." required minlength="20"></textarea>
                        <p class="text-slate-500 text-xs mt-2">Mínimo 20 caracteres</p>
                    </div>

                    <div class="bg-blue-900/20 border border-blue-600/30 rounded-xl p-4">
                        <p class="text-slate-300 text-sm">
                            <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                            <strong>Nota:</strong> Recibirás una notificación con el número de tu ticket. Este número te permitirá hacer seguimiento de tu PQR.
                        </p>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-slate-700">
                        <a href="{{ url('/soporte') }}" class="px-6 py-3 rounded-xl text-white border border-slate-600 hover:bg-slate-700 font-bold uppercase text-sm transition">Cancelar</a>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold uppercase text-sm transition">Crear Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/profile-photo-upload.js') }}"></script>

</body>
</html>
