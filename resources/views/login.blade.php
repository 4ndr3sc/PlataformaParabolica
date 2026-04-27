<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex flex-col items-center justify-center min-h-screen py-12 px-4">

    <div class="max-w-md w-full mb-4">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-900 font-bold text-xs uppercase tracking-widest transition-all group">
            <div class="bg-white p-2 rounded-full shadow-sm group-hover:shadow-md transition-all">
                <i class="fas fa-arrow-left"></i>
            </div>
            Volver al Inicio
        </a>
    </div>

    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-2xl border-t-8 border-blue-900">
        
        <div class="text-center">
            <a href="{{ url('/') }}" class="inline-block hover:opacity-80 transition">
                <div class="flex justify-center items-center gap-2 mb-2">
                    <span class="text-3xl font-black text-blue-900 tracking-tighter uppercase">ASOTV</span>
                    <span class="text-2xl font-bold text-yellow-600 tracking-tight uppercase">GUACHETÁ</span>
                </div>
            </a>
            <h2 class="text-2xl font-extrabold text-slate-800 mt-4 uppercase tracking-tight">Acceso Clientes</h2>
            <p class="text-slate-500 text-sm italic">Ingresa para gestionar tus servicios</p>
        </div>
        
        <form action="{{ url('/login') }}" method="POST" class="mt-8 space-y-5">
            @csrf 
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" required 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all" 
                    placeholder="Correo electrónico">
            </div>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" required 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all" 
                    placeholder="Contraseña">
            </div>

            <div class="flex items-center justify-end">
                <a href="#" class="text-xs font-bold text-blue-700 hover:underline uppercase">¿Olvidaste tu contraseña?</a>
            </div>
            
            <button type="submit" 
                class="w-full py-4 rounded-xl text-white bg-blue-900 font-black uppercase shadow-lg hover:bg-blue-800 active:scale-95 transition-all tracking-widest">
                <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
            </button>
        </form>
        
        <div class="pt-6 border-t border-slate-100">
            <p class="text-center text-sm text-slate-600">
                ¿Aún no eres parte de AsoTV? <br>
                <a href="{{ url('/register') }}" class="inline-block mt-2 font-black text-orange-500 uppercase hover:text-orange-600 transition">
                    Crea tu cuenta aquí
                </a>
            </p>
        </div>
    </div>
</body>
</html>