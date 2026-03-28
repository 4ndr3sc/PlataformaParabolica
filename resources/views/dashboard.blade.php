<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 font-sans flex">

    <aside class="w-64 bg-slate-950 min-h-screen border-r border-slate-800 hidden md:block">
        <div class="p-6">
            <div class="flex items-center gap-2 mb-10">
                <span class="text-2xl font-black text-blue-500 tracking-tighter uppercase">ASOTV</span>
                <span class="text-xl font-bold text-yellow-500 uppercase">GUACHETA </span>
            </div>
            
            <nav class="space-y-4">
                <a href="#" class="flex items-center gap-3 p-3 bg-blue-600/20 text-blue-400 rounded-xl border border-blue-600/50 shadow-lg shadow-blue-900/20">
                    <i class="fas fa-th-large"></i> <span class="font-bold">Resumen</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Mis Facturas</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-tools"></i> <span>Soporte Técnico</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-user-cog"></i> <span>Mi Perfil</span>
                </a>
            </nav>
        </div>

        <div class="absolute bottom-6 left-6 right-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition-all font-bold">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-white uppercase tracking-tight">Bienvenido, <span class="text-yellow-500 italic">Usuario</span></h1>
                <p class="text-slate-400">Aquí tienes el estado de tus servicios en Guachetá.</p>
            </div>
            <div class="flex items-center gap-4 bg-slate-800 p-2 pr-6 rounded-full border border-slate-700">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold shadow-lg">U</div>
                <span class="font-bold text-sm">Estado: <span class="text-green-400">Activo</span></span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-slate-800 p-6 rounded-3xl border-b-4 border-blue-500 shadow-xl">
                <p class="text-slate-400 text-sm font-bold uppercase mb-2">Plan Actual</p>
                <h3 class="text-2xl font-black text-white">50MB FIBRA</h3>
                <p class="text-blue-400 text-xs mt-2 font-bold uppercase tracking-widest italic">Velocidad Simétrica</p>
            </div>
            <div class="bg-slate-800 p-6 rounded-3xl border-b-4 border-yellow-500 shadow-xl">
                <p class="text-slate-400 text-sm font-bold uppercase mb-2">Próximo Pago</p>
                <h3 class="text-2xl font-black text-white">$ 65.000</h3>
                <p class="text-yellow-500 text-xs mt-2 font-bold uppercase">Vence en 5 días</p>
            </div>
            <div class="bg-slate-800 p-6 rounded-3xl border-b-4 border-green-500 shadow-xl">
                <p class="text-slate-400 text-sm font-bold uppercase mb-2">Tickets Abiertos</p>
                <h3 class="text-2xl font-black text-white">0</h3>
                <p class="text-green-400 text-xs mt-2 font-bold uppercase">Sin reportes pendientes</p>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-900 to-slate-800 p-8 rounded-3xl shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-black text-white uppercase">Aviso Comunitario</h2>
                <p class="text-blue-100 mt-2 max-w-md leading-relaxed">Mantenimiento programado en la zona rural para el próximo viernes. ¡Seguimos trabajando para ti!</p>
                <button class="mt-6 bg-yellow-500 text-blue-900 px-6 py-2 rounded-xl font-bold uppercase text-sm hover:bg-white transition-all">Más información</button>
            </div>
            <i class="fas fa-broadcast-tower absolute -right-4 -bottom-4 text-blue-500/20 text-9xl"></i>
        </div>
    </main>

</body>
</html>