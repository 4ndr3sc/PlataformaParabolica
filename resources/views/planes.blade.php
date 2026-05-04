<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes Disponibles | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-brand-blue { background-color: #1d4ed8; }
        .nav-logo { height: 70px; width: auto; object-fit: contain; mix-blend-multiply: multiply; }
    </style>
</head>
<body class="bg-slate-50 font-sans">

    <nav class="bg-[#fdfdfd] border-b border-gray-100 shadow-sm">
        <div class="container mx-auto px-6 py-2 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="/"><img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="nav-logo"></a>
                <div class="flex flex-col leading-none">
                    <span class="text-xl font-black text-blue-900 uppercase">ASOTV</span>
                    <span class="text-lg font-bold text-yellow-600 uppercase tracking-tight">GUACHETÁ</span>
                </div>
            </div>
            <a href="/" class="bg-blue-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-800 transition-all shadow-lg flex items-center gap-2 text-base">
                <i class="fas fa-arrow-left"></i> Volver al Inicio
            </a>
        </div>
    </nav>

    <header class="bg-brand-blue py-16 text-white text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-5xl font-extrabold uppercase tracking-tighter">Planes <span class="text-yellow-400">Disponibles</span></h1>
            <p class="mt-4 text-blue-100 text-xl max-w-2xl mx-auto italic">Elige el plan que mejor se adapte a tus necesidades</p>
        </div>
    </header>

    <section class="py-20">
        <div class="container mx-auto px-6">
            <!-- Planes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Plan 1: Solo WiFi -->
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden hover:shadow-xl transition-all">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-8 text-center">
                    <i class="fas fa-wifi text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold">Solo WiFi</h3>
                    <p class="text-blue-100 text-sm mt-2">100 MB Satelital</p>
                </div>
                
                <div class="p-8">
                    <div class="mb-8">
                        <p class="text-slate-600 text-sm mb-4">Incluye:</p>
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-blue-600"></i>
                                <span>100 MB de velocidad</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-blue-600"></i>
                                <span>WiFi en todo tu hogar</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-blue-600"></i>
                                <span>Soporte técnico 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-6">
                        <p class="text-blue-600 text-3xl font-black mb-4">$47.900</p>
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-lg">
                            Solicitar Plan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Plan 2: Solo Televisión -->
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden hover:shadow-xl transition-all">
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 text-white p-8 text-center">
                    <i class="fas fa-tv text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold">Solo Televisión</h3>
                    <p class="text-orange-100 text-sm mt-2">+60 canales HD</p>
                </div>
                
                <div class="p-8">
                    <div class="mb-8">
                        <p class="text-slate-600 text-sm mb-4">Incluye:</p>
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-orange-600"></i>
                                <span>+60 canales HD</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-orange-600"></i>
                                <span>Señal cristalina</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-orange-600"></i>
                                <span>Soporte técnico 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-6">
                        <p class="text-orange-600 text-3xl font-black mb-4">$27.000</p>
                        <button class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-lg">
                            Solicitar Plan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Plan 3: WiFi + TV (Recomendado) -->
            <div class="bg-white rounded-3xl shadow-lg border-2 border-blue-500 overflow-hidden hover:shadow-xl transition-all relative">
                <div class="absolute top-0 right-0 bg-blue-500 text-white px-4 py-2 rounded-bl-2xl text-xs font-bold uppercase">
                    Más Popular
                </div>

                <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-8 text-center">
                    <i class="fas fa-star text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold">WiFi + TV</h3>
                    <p class="text-blue-100 text-sm mt-2">Combo Total Hogar</p>
                </div>
                
                <div class="p-8">
                    <div class="mb-8">
                        <p class="text-slate-600 text-sm mb-4">Incluye:</p>
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-blue-600"></i>
                                <span>100 MB WiFi Satelital</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-blue-600"></i>
                                <span>65 canales HD</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-blue-600"></i>
                                <span>Combo integral del hogar</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="fas fa-check-circle text-blue-600"></i>
                                <span>Soporte técnico 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-6">
                        <p class="text-blue-600 text-3xl font-black mb-4">$74.900</p>
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-lg">
                            Solicitar Plan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 uppercase flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> ¿Por qué elegir AsoTV?
                </h2>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="flex flex-col items-center text-center">
                        <i class="fas fa-clock text-blue-600 text-4xl mb-3"></i>
                        <h4 class="font-bold text-slate-900 mb-2">Instalación Rápida</h4>
                        <p class="text-slate-600 text-sm">Conectamos tu hogar en 24 horas</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <i class="fas fa-headset text-blue-600 text-4xl mb-3"></i>
                        <h4 class="font-bold text-slate-900 mb-2">Soporte 24/7</h4>
                        <p class="text-slate-600 text-sm">Estamos siempre disponibles para ti</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <i class="fas fa-shield-alt text-blue-600 text-4xl mb-3"></i>
                        <h4 class="font-bold text-slate-900 mb-2">100% Seguro</h4>
                        <p class="text-slate-600 text-sm">Tus datos protegidos siempre</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <i class="fas fa-tags text-blue-600 text-4xl mb-3"></i>
                        <h4 class="font-bold text-slate-900 mb-2">Mejor Precio</h4>
                        <p class="text-slate-600 text-sm">Los mejores precios de la región</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white py-12 text-center">
        <div class="flex justify-center space-x-6 mb-6 text-xl">
           <a href="https://www.facebook.com/AsotvGuacheta/?locale=es_LA" target="_blank" class="text-white hover:text-blue-500 transition-all transform hover:scale-110">
        <i class="fab fa-facebook"></i>
    </a>
    
    <a href="https://wa.me/573000000000" target="_blank" class="text-white hover:text-green-500 transition-all transform hover:scale-110">
        <i class="fab fa-whatsapp"></i>
    </a>

    <a href="https://www.instagram.com/asotvguacheta/" target="_blank" class="text-white hover:text-[#E1306C] transition-all transform hover:scale-110">
        <i class="fab fa-instagram"></i>
    </a>
        </div>
        <p class="text-slate-500 text-sm italic uppercase tracking-widest">&copy; 2026 AsoTV Guachetá</p>
    </footer>

</body>
</html>
