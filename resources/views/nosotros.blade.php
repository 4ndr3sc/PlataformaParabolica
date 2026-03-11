<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiénes Somos | AsoTV Guachetá</title>
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
            <a href="/" class="text-blue-900 font-bold hover:text-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Inicio
            </a>
        </div>
    </nav>

    <header class="bg-brand-blue py-20 text-white text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-5xl font-extrabold uppercase tracking-tighter">Nuestra <span class="text-yellow-400">Historia</span></h1>
            <p class="mt-4 text-blue-100 text-xl max-w-2xl mx-auto italic">Uniendo a nuestra comunidad desde el corazón de Guachetá.</p>
        </div>
    </header>

    <section class="py-20">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="grid md:grid-cols-2 gap-16 items-center mb-20">
                <div>
                    <h2 class="text-3xl font-bold text-blue-900 mb-6 uppercase italic">¿Quiénes Somos?</h2>
                    <p class="text-slate-600 text-lg leading-relaxed mb-4">
                        Somos la "Asociación de Televisión Comunitaria de Guachetá", una organización sin ánimo de lucro nacida para ser la voz de nuestro municipio. 
                    </p>
                    <p class="text-slate-600 text-lg leading-relaxed">
                        No somos solo un proveedor de servicios; somos una familia que trabaja para que cada hogar guachetuno tenga acceso a la mejor información local y a una conectividad de fibra óptica de clase mundial.
                    </p>
                </div>
                <div class="bg-blue-100 p-4 rounded-3xl rotate-2">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&q=80&w=600" class="rounded-2xl shadow-lg border-4 border-white">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-10 rounded-3xl shadow-xl border-t-8 border-blue-700">
                    <div class="text-blue-700 text-3xl mb-4"><i class="fas fa-bullseye"></i></div>
                    <h3 class="text-2xl font-bold text-blue-900 mb-4 uppercase tracking-tighter">Misión</h3>
                    <p class="text-slate-600">Proveer servicios de telecomunicaciones con excelencia técnica y calidez humana, reinvirtiendo en el desarrollo social y cultural de Guachetá.</p>
                </div>
                <div class="bg-white p-10 rounded-3xl shadow-xl border-t-8 border-yellow-500">
                    <div class="text-yellow-500 text-3xl mb-4"><i class="fas fa-eye"></i></div>
                    <h3 class="text-2xl font-bold text-blue-900 mb-4 uppercase tracking-tighter">Visión</h3>
                    <p class="text-slate-600">Ser la empresa líder en innovación digital de la región, conectando cada rincón de nuestro territorio con el mundo exterior.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white py-12 text-center">
        <div class="flex justify-center space-x-6 mb-6 text-xl">
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
        <p class="text-slate-500 text-sm italic uppercase tracking-widest">&copy; 2026 AsoTV Guachetá</p>
    </footer>

</body>
</html>