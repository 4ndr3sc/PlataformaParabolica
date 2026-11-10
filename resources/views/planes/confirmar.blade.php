<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar solicitud | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 px-4 py-10 font-sans text-slate-900">
    <main class="w-full max-w-xl rounded-3xl border border-slate-200 bg-white p-8 shadow-xl">
        <p class="text-sm font-bold uppercase tracking-widest text-blue-700">Solicitud vinculada a tu cuenta</p>
        <h1 class="mt-3 text-3xl font-black">Confirma tu servicio</h1>
        <p class="mt-2 text-slate-600">Revisa el plan antes de enviar la solicitud. ASO TV podrá contactarte para coordinar la activación.</p>

        <div class="my-7 rounded-2xl bg-blue-50 p-6">
            <h2 class="text-xl font-bold">{{ $plan['name'] }}</h2>
            <p class="mt-2 text-2xl font-black text-blue-700">$ {{ number_format($plan['amount'], 0, ',', '.') }} <span class="text-sm font-medium">/ mes</span></p>
            <p class="mt-3 text-sm text-slate-600">La solicitud se registrará en la cuenta {{ Auth::user()->email }}.</p>
        </div>

        <form method="POST" action="{{ route('plans.select') }}" class="flex flex-col gap-3 sm:flex-row">
            @csrf
            <input type="hidden" name="plan" value="{{ $planKey }}">
            <button type="submit" class="rounded-xl bg-blue-700 px-6 py-3 font-bold text-white hover:bg-blue-800">Enviar solicitud</button>
            <a href="{{ url('/planes') }}" class="rounded-xl border border-slate-300 px-6 py-3 text-center font-bold text-slate-700 hover:bg-slate-50">Volver a los planes</a>
        </form>
    </main>
</body>
</html>
