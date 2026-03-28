<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex flex-col items-center justify-center min-h-screen py-12 px-4">

    <div class="max-w-xl w-full mb-4">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-900 font-bold text-xs uppercase tracking-widest transition-all group">
            <div class="bg-white p-2 rounded-full shadow-sm group-hover:shadow-md transition-all">
                <i class="fas fa-arrow-left"></i>
            </div>
            Volver al Inicio
        </a>
    </div>

    <div class="max-w-xl w-full space-y-8 bg-white p-10 rounded-3xl shadow-2xl border-b-8 border-yellow-500">
        <div class="text-center">
            <a href="{{ url('/') }}">
                <h2 class="text-4xl font-black text-blue-900 uppercase italic">Únete a nosotros</h2>
            </a>
            <p class="text-slate-600 mt-2 italic">Crea tu cuenta para acceder a todos nuestros servicios digitales</p>
        </div>

        <form action="{{ url('/register') }}" method="POST" class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" name="name" placeholder="Nombres" required 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-yellow-500 bg-slate-50 transition-all">
            </div>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-user-tag"></i>
                </span>
                <input type="text" name="lastname" placeholder="Apellidos" required 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-yellow-500 bg-slate-50 transition-all">
            </div>

            <div class="col-span-2 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" placeholder="Correo electrónico" required 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-yellow-500 bg-slate-50 transition-all">
            </div>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" placeholder="Contraseña" required 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-yellow-500 bg-slate-50 transition-all">
            </div>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-shield-alt"></i>
                </span>
                <input type="password" name="password_confirmation" placeholder="Confirmar" required 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-yellow-500 bg-slate-50 transition-all">
            </div>
            
            <button type="submit" class="col-span-2 bg-yellow-500 text-blue-900 py-4 rounded-xl font-black text-xl hover:bg-blue-900 hover:text-white transition-all shadow-xl uppercase active:scale-95">
                Crear mi cuenta
            </button>
        </form>
        
        <div class="pt-4 border-t border-slate-100">
            <p class="text-center text-sm text-slate-600">
                ¿Ya tienes cuenta? <a href="{{ url('/login') }}" class="font-bold text-blue-900 uppercase hover:underline">Ingresa aquí</a>
            </p>
        </div>
    </div>
</body>
</html>