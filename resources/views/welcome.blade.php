<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsoTV Guachetá | Conectando nuestra región</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .gradient-blue { background: linear-gradient(90deg, #1e3a8a 0%, #1d4ed8 100%); }
        .hero-pattern { background-image: url('https://www.transparenttextures.com/patterns/cubes.png'); }
        
        /* Ajuste de logo para que se funda con la barra superior #fdfdfd */
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

    <div class="container mx-auto px-6 py-2 flex justify-between items-center">
            
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo AsoTV Guachetá" class="nav-logo">
                <div class="flex flex-col leading-none">
                    <span class="text-xl font-black text-blue-900 tracking-tighter uppercase font-serif">ASOTV</span>
                    <span class="text-lg font-bold text-yellow-600 tracking-tight uppercase">GUACHETÁ</span>
                </div>
            </div>
            
            <div class="hidden md:flex space-x-6 items-center">
                <a href="#" class="text-blue-900 font-medium hover:text-blue-600 transition">Inicio</a>
                <a href="#television" class="text-slate-600 font-medium hover:text-blue-600 transition">Televisión</a>
                <a href="#internet" class="text-slate-600 font-medium hover:text-blue-600 transition">Internet</a>

                <div class="h-6 w-px bg-slate-200 mx-2"></div>

                <div class="flex items-center gap-3">
                    <a href="/login" class="text-blue-900 font-bold text-sm uppercase tracking-wider hover:text-blue-700 transition px-4 py-2">
                        <i class="fas fa-user-circle mr-2"></i>Ingresar
                    </a>

                    <a href="/register" class="bg-blue-900 text-white px-5 py-2.5 rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-blue-800 transition-all shadow-md active:scale-95 border-b-4 border-blue-950">
                        Regístrate
                    </a>

                    <a href="#contacto" class="inline-flex items-center justify-center bg-orange-500 text-white px-6 py-2.5 rounded-full hover:bg-orange-600 transition-all shadow-lg font-black text-xs uppercase tracking-widest active:scale-95 ml-2">
                        <i class="fas fa-file-signature mr-2"></i>Solicitar
                    </a>
                </div>
            </div>

            <div class="md:hidden text-blue-900 text-2xl">
                <i class="fas fa-bars"></i>
            </div>
        </div>

    <header class="gradient-blue text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 hero-pattern"></div>
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center relative z-10">
            <div>
                <span class="bg-yellow-500 text-blue-900 px-3 py-1 rounded-full text-sm font-bold uppercase tracking-widest shadow-md">Orgullo de Guachetá</span>
                <h1 class="text-5xl md:text-6xl font-extrabold mt-6 leading-tight">Mucho más que <span class="text-yellow-400">televisión por cable</span></h1>
                <p class="text-xl text-blue-100 mt-6 leading-relaxed">Somos la Asociación de Televisión Comunitaria que une a nuestro municipio con el mundo. Cultura, información y fibra óptica.</p>
                
                <div class="flex flex-wrap gap-4 mt-10">
                    <a href="#servicios" class="bg-yellow-500 text-blue-900 px-8 py-4 rounded-xl font-extrabold text-lg hover:bg-white hover:text-blue-900 transition-all shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-satellite-dish mr-2"></i> Nuestros Servicios
                    </a>
                    
                    <a href="/nosotros" class="bg-blue-600 border border-blue-400 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-500 transition shadow-lg inline-flex items-center">
                        <i class="fas fa-users mr-3 text-blue-200"></i> ¿Quiénes Somos?
                    </a>
                </div>
            </div>
            <div class="hidden md:block">
                <img src="https://images.unsplash.com/photo-1526628953301-3e589a6a8b74?auto=format&fit=crop&q=80&w=800" alt="Conectividad" class="rounded-3xl shadow-2xl border-8 border-white/10 rotate-2">
            </div>
        </div>
    </header>

    <section id="servicios" class="py-20 container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold text-blue-900 uppercase italic">Conectando tu Hogar</h2>
        <div class="h-1.5 w-24 bg-yellow-500 mx-auto mt-4 mb-16 rounded-full"></div>

        <div class="grid md:grid-cols-3 gap-10">
            <div class="bg-white p-10 rounded-3xl shadow-lg border-b-4 border-blue-600 hover:scale-105 transition-transform">
                <div class="text-blue-700 text-4xl mb-6"><i class="fas fa-tv"></i></div>
                <h3 class="text-2xl font-bold mb-4 text-blue-900">TV Digital</h3>
                <p class="text-slate-600 italic">Disfruta de más de 80 canales con señal nítida y contenido para toda la familia.</p>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-lg border-b-4 border-yellow-500 hover:scale-105 transition-transform">
                <div class="text-yellow-500 text-4xl mb-6"><i class="fas fa-bolt"></i></div>
                <h3 class="text-2xl font-bold mb-4 text-blue-900">Fibra Óptica</h3>
                <p class="text-slate-600 italic">Internet de alta velocidad para tareas, trabajo y entretenimiento sin cortes.</p>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-lg border-b-4 border-green-600 hover:scale-105 transition-transform">
                <div class="text-green-600 text-4xl mb-6"><i class="fas fa-heart"></i></div>
                <h3 class="text-2xl font-bold mb-4 text-blue-900">100% Local</h3>
                <p class="text-slate-600 italic">Apoyamos el talento guachetuno a través de nuestro canal comunitario.</p>
            </div>
        </div>
    </section>

    <section id="television" class="py-20 bg-slate-100">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center gap-16">
                <div class="md:w-1/2 relative">
                <img src="{{ asset('images/canales.webp') }}" alt="Canales" class="rounded-3xl shadow-2xl relative z-10 border-b-8 border-blue-900">
                    <div class="absolute -bottom-6 -right-6 bg-yellow-500 text-blue-900 p-6 rounded-2xl shadow-xl z-20 font-bold">
                        <p class="text-3xl">+80</p>
                        <p class="text-xs uppercase tracking-tighter">Canales Digitales</p>
                    </div>
                </div>

                <div class="md:w-1/2">
                    <h2 class="text-4xl font-extrabold text-blue-900 leading-tight mb-6 uppercase">
                        Televisión con <span class="text-yellow-600 italic">Identidad</span>
                    </h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">En AsoTV Guachetá, la televisión es mucho más que entretenimiento. Es el medio donde nuestra comunidad se informa y celebra sus tradiciones.</p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                            <span class="text-slate-700 font-semibold">Canal 8: El canal de los guachetunos.</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                            <span class="text-slate-700 font-semibold">Misas y eventos culturales en vivo.</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                            <span class="text-slate-700 font-semibold">Noticias de minería y agricultura local.</span>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </section>
            <section id="internet" class="py-24 bg-[#1d4ed8] text-white border-t-8 border-yellow-500">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row-reverse items-center gap-16">
            
            <div class="md:w-1/2">
                <h2 class="text-4xl md:text-5xl font-extrabold mb-6 uppercase tracking-tighter">
                    Internet <span class="text-yellow-400 italic">Fibra Óptica</span>
                </h2>
                <p class="text-lg text-blue-50 mb-8 leading-relaxed">
                    Conexión de ultra velocidad para que nada te detenga. Navega, estudia y trabaja con la estabilidad que solo AsoTV te ofrece en Guachetá.
                </p>
                
                <div class="grid grid-cols-2 gap-6 mb-10">
                    <div class="p-5 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-bolt text-yellow-400 text-3xl mb-3"></i>
                        <p class="font-black uppercase text-sm tracking-widest text-white">Ultra Velocidad</p>
                    </div>
                    <div class="p-5 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-wifi text-yellow-400 text-3xl mb-3"></i>
                        <p class="font-black uppercase text-sm tracking-widest text-white">Señal Estable</p>
                    </div>
                </div>
                
                <a href="#contacto" class="inline-block bg-white text-blue-700 px-10 py-4 rounded-xl font-black text-lg hover:bg-yellow-400 hover:text-blue-900 transition-all shadow-xl uppercase tracking-tighter">
                    Consultar Cobertura
                </a>
            </div>

            <div class="md:w-1/2">
                <img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&q=80&w=800" 
                     alt="Internet AsoTV" 
                     class="rounded-3xl shadow-2xl border-l-8 border-yellow-500">
            </div>
            
        </div>
    </div>
</section>
        </div>
    </section>

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

</body>
</html>