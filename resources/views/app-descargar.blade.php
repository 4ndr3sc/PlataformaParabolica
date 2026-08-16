<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Descargar Aplicación | AsoTV Guachetá</title>
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
                <a href="{{ url('/facturas') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Mis Facturas</span>
                </a>
                <a href="{{ url('/soporte') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-tools"></i> <span>Soporte Técnico</span>
                </a>
                <a href="{{ url('/perfil') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded-xl transition-all">
                    <i class="fas fa-user-cog"></i> <span>Mi Perfil</span>
                </a>
                @if(!(Auth::check() && Auth::user()->role === 'administrador'))
                    <a href="{{ url('/app/descargar') }}" class="flex items-center gap-3 p-3 bg-green-100 text-green-600 rounded-xl border border-green-300 shadow-lg shadow-green-200/50">
                        <i class="fas fa-mobile-alt"></i> <span>Aplicación</span>
                    </a>
                @endif
                @if(Auth::check() && Auth::user()->role === 'administrador')
                    <div class="border-t border-slate-300 pt-4 mt-4">
                        <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 p-3 text-red-600 font-bold hover:bg-red-100 rounded-xl transition-all border-2 border-red-300">
                            <i class="fas fa-lock-open"></i> <span>Panel Admin</span>
                        </a>
                    </div>
                @endif
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
                <h1 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight">Descargar <span class="text-yellow-500 italic">Aplicación</span></h1>
                <p class="text-slate-600">Accede a AsoTV desde tu dispositivo móvil</p>
            </div>
            <div class="flex items-center gap-4 bg-slate-100 p-2 pr-6 rounded-full border border-slate-300">
                <div class="photo-upload-trigger w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold shadow-lg overflow-hidden relative">
                    @if(Auth::check() && Auth::user()->profile_photo)
                        <img id="profile-image-display" src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                    @else
                        <div id="profile-initial-display" class="w-full h-full bg-blue-600 flex items-center justify-center font-bold">
                            {{ Auth::check() ? strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) : 'U' }}
                        </div>
                    @endif
                </div>
                <span class="font-bold text-sm">Estado: <span class="text-green-600">Activo</span></span>
            </div>
        </header>

        @if ($message = session('error'))
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-8">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </div>
        @endif

        <!-- Tarjetas de Descarga -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Card Android -->
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-8 text-center">
                    <i class="fab fa-android text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold">Android</h3>
                </div>
                
                <div class="p-8">
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fas fa-mobile-alt text-green-600 text-lg"></i>
                            <span>Compatible con Android 8.0 o superior</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fas fa-bolt text-green-600 text-lg"></i>
                            <span>Acceso completo a tus servicios AsoTV</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fas fa-bell text-green-600 text-lg"></i>
                            <span>Notificaciones en tiempo real</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fas fa-microchip text-green-600 text-lg"></i>
                            <span>Bajo consumo de datos y almacenamiento</span>
                        </div>
                    </div>

                    <div class="flex gap-3 mb-6">
                        <a href="/app/descargar/apk" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-xl font-bold text-lg hover:bg-green-700 transition-all shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i> Descargar APK
                        </a>
                    </div>

                    <p class="text-xs text-slate-500 text-center font-bold">Tamaño: 64.5 MB</p>
                </div>
            </div>

            <!-- Card iOS -->
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-br from-gray-800 to-black text-white p-8 text-center">
                    <i class="fab fa-apple text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold">iPhone / iPad</h3>
                </div>
                
                <div class="p-8">
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fas fa-mobile-alt text-gray-700 text-lg"></i>
                            <span>Compatible con iOS 12.0 o superior</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fas fa-bolt text-gray-700 text-lg"></i>
                            <span>Acceso completo a tus servicios AsoTV</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fas fa-bell text-gray-700 text-lg"></i>
                            <span>Notificaciones en tiempo real</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fas fa-microchip text-gray-700 text-lg"></i>
                            <span>Bajo consumo de datos y almacenamiento</span>
                        </div>
                    </div>

                    <div class="flex gap-3 mb-6">
                        <a href="/app/descargar/ipa" class="flex-1 bg-black text-white px-6 py-3 rounded-xl font-bold text-lg hover:bg-gray-900 transition-all shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i> Descargar IPA
                        </a>
                    </div>

                    <p class="text-xs text-slate-500 text-center font-bold">Tamaño: 58.3 MB</p>
                </div>
            </div>
        </div>


        <!-- Características de la aplicación -->
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden mb-10">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 uppercase flex items-center gap-2">
                    <i class="fas fa-star"></i> Características Principales
                </h2>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex gap-4 items-start">
                        <i class="fas fa-user-circle text-blue-600 text-3xl flex-shrink-0 mt-1"></i>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Tu Perfil</h4>
                            <p class="text-slate-600">Administra tu cuenta, datos personales y contraseña de forma segura.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 items-start">
                        <i class="fas fa-file-invoice text-blue-600 text-3xl flex-shrink-0 mt-1"></i>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Tus Facturas</h4>
                            <p class="text-slate-600">Consulta tus facturas, saldos y realiza pagos desde tu celular.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 items-start">
                        <i class="fas fa-headset text-blue-600 text-3xl flex-shrink-0 mt-1"></i>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Soporte Técnico</h4>
                            <p class="text-slate-600">Reporta problemas y recibe asistencia técnica en tiempo real.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 items-start">
                        <i class="fas fa-lock text-blue-600 text-3xl flex-shrink-0 mt-1"></i>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Segura y Confiable</h4>
                            <p class="text-slate-600">Tus datos están protegidos con encriptación de última generación.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 items-start">
                        <i class="fas fa-bell text-blue-600 text-3xl flex-shrink-0 mt-1"></i>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Notificaciones</h4>
                            <p class="text-slate-600">Recibe alertas sobre facturas, promociones y cambios importantes.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 items-start">
                        <i class="fas fa-tachometer-alt text-blue-600 text-3xl flex-shrink-0 mt-1"></i>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Rápido y Eficiente</h4>
                            <p class="text-slate-600">Interfaz intuitiva diseñada para tu comodidad.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preguntas Frecuentes -->
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 uppercase flex items-center gap-2">
                    <i class="fas fa-question-circle"></i> Preguntas Frecuentes
                </h2>
            </div>

            <div class="p-8 space-y-4">
                <details class="bg-slate-50 p-6 rounded-xl border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                    <summary class="font-bold text-slate-900 text-base flex justify-between items-center">
                        <span>¿La aplicación es gratuita?</span>
                        <i class="fas fa-chevron-down ml-auto"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">Sí, la aplicación es completamente gratuita. Solo necesitas tener una cuenta activa en AsoTV para acceder a todos los servicios.</p>
                </details>

                <details class="bg-slate-50 p-6 rounded-xl border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                    <summary class="font-bold text-slate-900 text-base flex justify-between items-center">
                        <span>¿Qué información personal necesita la app?</span>
                        <i class="fas fa-chevron-down ml-auto"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">La aplicación utiliza tu usuario, contraseña, telefono y dirección de AsoTV para autenticarte. No solicitamos información adicional innecesaria.</p>
                </details>

                <details class="bg-slate-50 p-6 rounded-xl border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                    <summary class="font-bold text-slate-900 text-base flex justify-between items-center">
                        <span>¿Puedo usar la app sin conexión a internet?</span>
                        <i class="fas fa-chevron-down ml-auto"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">No, la aplicación requiere conexión a internet para acceder a tus servicios. Sin embargo, está optimizada para funcionar con conexiones lentas.</p>
                </details>

                <details class="bg-slate-50 p-6 rounded-xl border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                    <summary class="font-bold text-slate-900 text-base flex justify-between items-center">
                        <span>¿Con qué versiones de Android e iOS es compatible?</span>
                        <i class="fas fa-chevron-down ml-auto"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">Android 8.0 o superior e iOS 12.0 o superior. Recomendamos tener la versión más reciente de tu sistema operativo para mejor rendimiento.</p>
                </details>

                
            </div>
        </div>
    </main>

    <script src="{{ asset('js/profile-photo-upload.js') }}"></script>

    <script>
        // Mejorar la experiencia de los detalles (details)
        document.querySelectorAll('details').forEach(detail => {
            detail.addEventListener('toggle', function() {
                const icon = this.querySelector('i');
                if (this.open) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });
    </script>

</body>
</html>
