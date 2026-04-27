<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descarga AsoTV App | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .gradient-blue { background: linear-gradient(90deg, #1e3a8a 0%, #1d4ed8 100%); }
        .app-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .nav-logo { 
            height: 70px; 
            width: auto; 
            object-fit: contain;
            mix-blend-multiply: multiply; 
        }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <!-- Navbar -->
    <div class="container mx-auto px-6 py-2 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo AsoTV Guachetá" class="nav-logo">
            <div class="flex flex-col leading-none">
                <span class="text-xl font-black text-blue-900 tracking-tighter uppercase font-serif">ASOTV</span>
                <span class="text-lg font-bold text-yellow-600 tracking-tight uppercase">GUACHETÁ</span>
            </div>
        </div>
        
        <div class="hidden md:flex space-x-6 items-center">
            <a href="/" class="text-blue-900 font-medium hover:text-blue-600 transition">Inicio</a>
            <a href="/#television" class="text-slate-600 font-medium hover:text-blue-600 transition">Televisión</a>
            <a href="/#internet" class="text-slate-600 font-medium hover:text-blue-600 transition">Internet</a>

            <div class="h-6 w-px bg-slate-200 mx-2"></div>

            <div class="flex items-center gap-3">
                <a href="/login" class="text-blue-900 font-bold text-sm uppercase tracking-wider hover:text-blue-700 transition px-4 py-2">
                    <i class="fas fa-user-circle mr-2"></i>Ingresar
                </a>

                <a href="/register" class="bg-blue-900 text-white px-5 py-2.5 rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-blue-800 transition-all shadow-md active:scale-95 border-b-4 border-blue-950">
                    Regístrate
                </a>
            </div>
        </div>
    </div>

    <!-- Header de la app -->
    <header class="gradient-blue text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <i class="fas fa-mobile-alt text-6xl mb-6"></i>
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">AsoTV <span class="text-yellow-400">Aplicación Móvil</span></h1>
            <p class="text-xl text-blue-100 mt-4">Lleva AsoTV contigo a todas partes. Accede a tus servicios desde tu dispositivo móvil.</p>
        </div>
    </header>

    <!-- Sección de descargas -->
    <section class="py-20 container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-blue-900 uppercase">Descarga tu Aplicación</h2>
            <div class="h-1.5 w-24 bg-yellow-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Mostrar mensajes de error si existen -->
        @if ($message = session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-12 max-w-4xl mx-auto mb-16">
            <!-- Card Android -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden hover:shadow-3xl transition-all transform hover:-translate-y-2">
                <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-8 text-center">
                    <i class="fab fa-android text-6xl mb-4"></i>
                    <h3 class="text-3xl font-bold">Android</h3>
                </div>
                
                <div class="p-8">
                    <div class="space-y-4 mb-8">
                        <p class="text-slate-600">📱 Compatible con Android 8.0 o superior</p>
                        <p class="text-slate-600">⚡ Acceso completo a tus servicios AsoTV</p>
                        <p class="text-slate-600">🔔 Notificaciones en tiempo real</p>
                        <p class="text-slate-600">💾 Bajo consumo de datos y almacenamiento</p>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <a href="/app/descargar/apk" class="flex-1 bg-green-600 text-white px-6 py-4 rounded-xl font-black text-lg hover:bg-green-700 transition-all shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                        <a href="https://play.google.com/store" target="_blank" class="flex-1 bg-slate-200 text-slate-800 px-6 py-4 rounded-xl font-bold text-lg hover:bg-slate-300 transition-all flex items-center justify-center gap-2">
                            <i class="fab fa-google-play"></i> Play Store
                        </a>
                    </div>

                    <p class="text-xs text-slate-500 text-center">APK directo: 64.5 MB</p>
                </div>
            </div>

            <!-- Card iOS -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden hover:shadow-3xl transition-all transform hover:-translate-y-2">
                <div class="bg-gradient-to-br from-gray-800 to-black text-white p-8 text-center">
                    <i class="fab fa-apple text-6xl mb-4"></i>
                    <h3 class="text-3xl font-bold">iPhone / iPad</h3>
                </div>
                
                <div class="p-8">
                    <div class="space-y-4 mb-8">
                        <p class="text-slate-600">📱 Compatible con iOS 12.0 o superior</p>
                        <p class="text-slate-600">⚡ Acceso completo a tus servicios AsoTV</p>
                        <p class="text-slate-600">🔔 Notificaciones en tiempo real</p>
                        <p class="text-slate-600">💾 Bajo consumo de datos y almacenamiento</p>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <a href="/app/descargar/ipa" class="flex-1 bg-black text-white px-6 py-4 rounded-xl font-black text-lg hover:bg-gray-900 transition-all shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                        <a href="https://apps.apple.com" target="_blank" class="flex-1 bg-slate-200 text-slate-800 px-6 py-4 rounded-xl font-bold text-lg hover:bg-slate-300 transition-all flex items-center justify-center gap-2">
                            <i class="fab fa-app-store"></i> App Store
                        </a>
                    </div>

                    <p class="text-xs text-slate-500 text-center">IPA directo: 58.3 MB</p>
                </div>
            </div>
        </div>

        <!-- Características de la aplicación -->
        <div class="max-w-4xl mx-auto mt-20">
            <h3 class="text-3xl font-bold text-blue-900 text-center mb-12">Características de la App</h3>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="flex gap-4 items-start">
                    <i class="fas fa-user-circle text-blue-600 text-4xl flex-shrink-0 mt-2"></i>
                    <div>
                        <h4 class="text-xl font-bold text-blue-900 mb-2">Tu Perfil</h4>
                        <p class="text-slate-600">Administra tu cuenta, datos personales y contraseña de forma segura.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <i class="fas fa-file-invoice text-blue-600 text-4xl flex-shrink-0 mt-2"></i>
                    <div>
                        <h4 class="text-xl font-bold text-blue-900 mb-2">Tus Facturas</h4>
                        <p class="text-slate-600">Consulta tus facturas, saldos y realiza pagos desde tu celular.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <i class="fas fa-headset text-blue-600 text-4xl flex-shrink-0 mt-2"></i>
                    <div>
                        <h4 class="text-xl font-bold text-blue-900 mb-2">Soporte Técnico</h4>
                        <p class="text-slate-600">Reporta problemas y recibe asistencia técnica en tiempo real.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <i class="fas fa-lock text-blue-600 text-4xl flex-shrink-0 mt-2"></i>
                    <div>
                        <h4 class="text-xl font-bold text-blue-900 mb-2">Segura y Confiable</h4>
                        <p class="text-slate-600">Tus datos están protegidos con encriptación de última generación.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <i class="fas fa-bell text-blue-600 text-4xl flex-shrink-0 mt-2"></i>
                    <div>
                        <h4 class="text-xl font-bold text-blue-900 mb-2">Notificaciones</h4>
                        <p class="text-slate-600">Recibe alertas sobre facturas, promociones y cambios importantes.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start">
                    <i class="fas fa-lightning-bolt text-blue-600 text-4xl flex-shrink-0 mt-2"></i>
                    <div>
                        <h4 class="text-xl font-bold text-blue-900 mb-2">Rápido y Eficiente</h4>
                        <p class="text-slate-600">Interfaz intuitiva diseñada para tu comodidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Preguntas Frecuentes -->
    <section class="py-20 bg-slate-100">
        <div class="container mx-auto px-6 max-w-4xl">
            <h3 class="text-3xl font-bold text-blue-900 text-center mb-12">Preguntas Frecuentes</h3>

            <div class="space-y-6">
                <details class="bg-white p-6 rounded-lg shadow-md cursor-pointer">
                    <summary class="font-bold text-blue-900 text-lg flex justify-between items-center">
                        <span>¿La aplicación es gratuita?</span>
                        <i class="fas fa-chevron-down"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">Sí, la aplicación es completamente gratuita. Solo necesitas tener una cuenta activa en AsoTV para acceder a todos los servicios.</p>
                </details>

                <details class="bg-white p-6 rounded-lg shadow-md cursor-pointer">
                    <summary class="font-bold text-blue-900 text-lg flex justify-between items-center">
                        <span>¿Qué información personal necesita la app?</span>
                        <i class="fas fa-chevron-down"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">La aplicación utiliza tu usuario y contraseña de AsoTV para autenticarte. No solicitamos información adicional innecesaria.</p>
                </details>

                <details class="bg-white p-6 rounded-lg shadow-md cursor-pointer">
                    <summary class="font-bold text-blue-900 text-lg flex justify-between items-center">
                        <span>¿Puedo usar la app sin conexión a internet?</span>
                        <i class="fas fa-chevron-down"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">No, la aplicación requiere conexión a internet para acceder a tus servicios. Sin embargo, está optimizada para funcionar con conexiones lentas.</p>
                </details>

                <details class="bg-white p-6 rounded-lg shadow-md cursor-pointer">
                    <summary class="font-bold text-blue-900 text-lg flex justify-between items-center">
                        <span>¿Con qué versiones de Android e iOS es compatible?</span>
                        <i class="fas fa-chevron-down"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">Android 8.0 o superior e iOS 12.0 o superior. Recomendamos tener la versión más reciente de tu sistema operativo para mejor rendimiento.</p>
                </details>

                <details class="bg-white p-6 rounded-lg shadow-md cursor-pointer">
                    <summary class="font-bold text-blue-900 text-lg flex justify-between items-center">
                        <span>¿Cómo reporto un problema con la app?</span>
                        <i class="fas fa-chevron-down"></i>
                    </summary>
                    <p class="text-slate-600 mt-4">Puedes contactarnos a través de la sección de Soporte dentro de la aplicación o enviarnos un mensaje a nuestro WhatsApp.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="gradient-blue text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">¿Listo para llevar AsoTV contigo?</h2>
            <p class="text-xl text-blue-100 mb-8">Descarga la aplicación ahora y accede a todos tus servicios desde tu dispositivo móvil.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/app/descargar/apk" class="bg-green-500 text-white px-8 py-4 rounded-xl font-black text-lg hover:bg-green-600 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fab fa-android"></i> Descargar para Android
                </a>
                <a href="/app/descargar/ipa" class="bg-black text-white px-8 py-4 rounded-xl font-black text-lg hover:bg-gray-900 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fab fa-apple"></i> Descargar para iOS
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-950 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <div class="flex justify-center items-center gap-3 mb-6">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo AsoTV" class="h-12 rounded bg-white p-1">
                <span class="text-2xl font-bold tracking-tighter italic uppercase">ASOTV GUACHETÁ</span>
            </div>
            <p class="text-blue-200 mb-8 max-w-lg mx-auto italic">"Uniendo a Guachetá a través de la comunicación y la tecnología."</p>
            <div class="flex justify-center space-x-8 text-2xl mb-8">
                <a href="https://www.facebook.com/AsotvGuacheta/?locale=es_LA" class="text-white hover:text-blue-500 transition-all transform hover:scale-110">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://wa.me/573000000000" class="text-white hover:text-green-500 transition-all transform hover:scale-110">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://www.instagram.com/asotvguacheta/" class="text-white hover:text-[#E1306C] transition-all transform hover:scale-110">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <div class="border-t border-blue-900 pt-8 text-sm text-blue-400 uppercase tracking-widest font-bold">
                &copy; 2026 AsoTV Guachetá - Cundinamarca, Colombia.
            </div>
        </div>
    </footer>

    <script>
        // Mejorar la experiencia de los detalles (details)
        document.querySelectorAll('details').forEach(detail => {
            detail.addEventListener('toggle', function() {
                if (this.open) {
                    this.querySelector('summary i').classList.remove('fa-chevron-down');
                    this.querySelector('summary i').classList.add('fa-chevron-up');
                } else {
                    this.querySelector('summary i').classList.remove('fa-chevron-up');
                    this.querySelector('summary i').classList.add('fa-chevron-down');
                }
            });
        });
    </script>

</body>
</html>
