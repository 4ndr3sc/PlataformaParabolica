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
        <header class="flex justify-between items-center mb-10 mt-12 md:mt-0">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight">Crear <span class="text-yellow-500 italic">Nuevo Ticket</span></h1>
                <p class="text-slate-600">Reporta tu petición, queja o reclamo.</p>
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
                <span class="font-bold text-xs md:text-sm hidden sm:inline">Estado: <span class="text-green-600">Activo</span></span>
            </div>
        </header>

        <div class="max-w-3xl">
            <a href="{{ url('/soporte') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 mb-6 font-bold">
                <i class="fas fa-arrow-left"></i> Volver a Soporte
            </a>

            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden p-6 md:p-8">
                <form action="{{ url('/ticket/crear') }}" method="POST" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-600 font-bold uppercase text-xs mb-2">Tipo de PQR</label>
                            <select name="type" class="w-full px-4 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                                <option value="">Selecciona un tipo</option>
                                <option value="peticion">Falla Técnica</option>
                                <option value="queja">Facturación</option>
                                <option value="reclamo">Reclamo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-600 font-bold uppercase text-xs mb-2">Prioridad</label>
                            <select name="priority" class="w-full px-4 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                                <option value="">Selecciona una prioridad</option>
                                <option value="baja">Baja</option>
                                <option value="media" selected>Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-600 font-bold uppercase text-xs mb-2">Asunto</label>
                        <input type="text" name="subject" class="w-full px-4 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Breve descripción del tema" required maxlength="255">
                    </div>

                    <div>
                        <label class="block text-slate-600 font-bold uppercase text-xs mb-2">Descripción Detallada</label>
                        <textarea name="description" rows="8" class="w-full px-4 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Describe en detalle tu petición, queja o reclamo. Incluye información relevante como fechas, horarios, etc." required minlength="20"></textarea>
                        <p class="text-slate-500 text-xs mt-2">Mínimo 20 caracteres</p>
                    </div>

                    <div class="bg-blue-100 border border-blue-300 rounded-xl p-4">
                        <p class="text-blue-700 text-sm">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            <strong>Nota:</strong> Recibirás una notificación con el número de tu ticket. Este número te permitirá hacer seguimiento de tu PQR.
                        </p>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                        <a href="{{ url('/soporte') }}" class="px-6 py-3 rounded-xl text-slate-600 border border-slate-300 hover:bg-slate-100 font-bold uppercase text-sm transition">Cancelar</a>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold uppercase text-sm transition shadow-lg shadow-blue-600/30">Crear Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/profile-photo-upload.js') }}"></script>

</body>
</html>
