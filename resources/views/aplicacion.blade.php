<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación | AsoTV Guachetá</title>
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
                <a href="{{ url('/soporte') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-tools"></i> <span>Soporte Técnico</span>
                </a>
                <a href="{{ url('/perfil') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-user-cog"></i> <span>Mi Perfil</span>
                </a>
                @if(!(Auth::check() && Auth::user()->role === 'administrador'))
                    <a href="{{ url('/aplicacion') }}" class="flex items-center gap-3 p-3 bg-blue-600/20 text-blue-400 rounded-xl border border-blue-600/50 shadow-lg shadow-blue-900/20">
                        <i class="fas fa-mobile-alt"></i> <span>Aplicación</span>
                    </a>
                @endif
                @if(Auth::check() && Auth::user()->role === 'administrador')
                    <div class="border-t border-slate-800 pt-4 mt-4">
                        <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 p-3 text-red-400 font-bold hover:bg-red-500/10 rounded-xl transition-all border-2 border-red-700">
                            <i class="fas fa-lock-open"></i> <span>Panel Admin</span>
                        </a>
                    </div>
                @endif
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
                <h1 class="text-3xl font-extrabold text-white uppercase tracking-tight">Descarga Nuestra <span class="text-yellow-500 italic">Aplicación</span></h1>
                <p class="text-slate-400">Accede a todos tus servicios desde tu dispositivo móvil.</p>
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

        <!-- Sección Hero -->
        <div class="bg-gradient-to-r from-blue-900 to-blue-800 rounded-3xl shadow-2xl overflow-hidden mb-10">
            <div class="p-8 md:p-12">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-black text-white uppercase mb-4">AsoTV en tu Bolsillo</h2>
                    <p class="text-blue-100 text-lg mb-6">La nueva aplicación móvil de AsoTV Guachetá te permite administrar tus servicios, consultar facturas, crear tickets de soporte y mucho más, en cualquier momento y desde cualquier lugar.</p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2 text-blue-100">
                            <i class="fas fa-check text-yellow-400"></i> Acceso a tus facturas
                        </div>
                        <div class="flex items-center gap-2 text-blue-100">
                            <i class="fas fa-check text-yellow-400"></i> Soporte técnico
                        </div>
                        <div class="flex items-center gap-2 text-blue-100">
                            <i class="fas fa-check text-yellow-400"></i> Gestión de servicios
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 opacity-10">
                <i class="fas fa-mobile-alt text-9xl"></i>
            </div>
        </div>

        <!-- Descargas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <!-- iOS -->
            <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden hover:border-blue-500 transition-all group">
                <div class="p-8 text-center">
                    <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 mb-6 w-20 h-20 flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                        <i class="fas fa-apple text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white uppercase mb-2">iOS</h3>
                    <p class="text-slate-400 mb-6">Descarga desde App Store</p>
                    <div class="space-y-2 mb-6">
                        <p class="text-slate-500 text-sm">
                            <i class="fas fa-info-circle"></i> Compatible con iPhone y iPad
                        </p>
                        <p class="text-slate-500 text-sm">
                            <i class="fas fa-circle text-yellow-500 text-xs"></i> Disponible próximamente
                        </p>
                    </div>
                    <button disabled class="w-full bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-bold uppercase text-sm transition-all opacity-50 cursor-not-allowed flex items-center justify-center gap-2">
                        <i class="fas fa-lock"></i> Próximamente
                    </button>
                </div>
            </div>

            <!-- Android -->
            <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden hover:border-blue-500 transition-all group">
                <div class="p-8 text-center">
                    <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 mb-6 w-20 h-20 flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                        <i class="fas fa-android text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white uppercase mb-2">Android</h3>
                    <p class="text-slate-400 mb-6">Descarga desde Google Play</p>
                    <div class="space-y-2 mb-6">
                        <p class="text-slate-500 text-sm">
                            <i class="fas fa-info-circle"></i> Compatible con Android 8.0+
                        </p>
                        <p class="text-slate-500 text-sm">
                            <i class="fas fa-circle text-yellow-500 text-xs"></i> Disponible próximamente
                        </p>
                    </div>
                    <button disabled class="w-full bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-bold uppercase text-sm transition-all opacity-50 cursor-not-allowed flex items-center justify-center gap-2">
                        <i class="fas fa-lock"></i> Próximamente
                    </button>
                </div>
            </div>
        </div>

        <!-- Características -->
        <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden p-8 mb-10">
            <h2 class="text-2xl font-bold text-white uppercase mb-8 flex items-center gap-2">
                <i class="fas fa-star text-yellow-500"></i> Características Principales
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Característica 1 -->
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600/20 border border-blue-600">
                            <i class="fas fa-wallet text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-1">Gestión de Facturas</h3>
                        <p class="text-slate-400 text-sm">Consulta y descarga tus facturas directamente desde tu móvil.</p>
                    </div>
                </div>

                <!-- Característica 2 -->
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600/20 border border-blue-600">
                            <i class="fas fa-headset text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-1">Soporte Técnico</h3>
                        <p class="text-slate-400 text-sm">Crea y sigue tus tickets de soporte en tiempo real.</p>
                    </div>
                </div>

                <!-- Característica 3 -->
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600/20 border border-blue-600">
                            <i class="fas fa-wifi text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-1">Estado del Servicio</h3>
                        <p class="text-slate-400 text-sm">Monitorea el estado de tu conexión en tiempo real.</p>
                    </div>
                </div>

                <!-- Característica 4 -->
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600/20 border border-blue-600">
                            <i class="fas fa-user-circle text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-1">Perfil de Usuario</h3>
                        <p class="text-slate-400 text-sm">Gestiona tu información personal y preferencias.</p>
                    </div>
                </div>

                <!-- Característica 5 -->
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600/20 border border-blue-600">
                            <i class="fas fa-bell text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-1">Notificaciones</h3>
                        <p class="text-slate-400 text-sm">Recibe alertas sobre actualizaciones y eventos importantes.</p>
                    </div>
                </div>

                <!-- Característica 6 -->
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600/20 border border-blue-600">
                            <i class="fas fa-lock text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-1">Seguridad</h3>
                        <p class="text-slate-400 text-sm">Autenticación segura y protección de datos.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requisitos del Sistema -->
        <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden p-8">
            <h2 class="text-2xl font-bold text-white uppercase mb-6 flex items-center gap-2">
                <i class="fas fa-cog text-yellow-500"></i> Requisitos del Sistema
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-apple"></i> iOS
                    </h3>
                    <ul class="space-y-2 text-slate-400">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400"></i> iOS 14.0 o superior
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400"></i> Mínimo 100 MB de espacio libre
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400"></i> Conexión a Internet
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-android"></i> Android
                    </h3>
                    <ul class="space-y-2 text-slate-400">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400"></i> Android 8.0 o superior
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400"></i> Mínimo 120 MB de espacio libre
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400"></i> Conexión a Internet
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/profile-photo-upload.js') }}"></script>

</body>
</html>
