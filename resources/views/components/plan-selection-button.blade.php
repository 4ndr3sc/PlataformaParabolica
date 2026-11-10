@if(Auth::check() && Auth::user()->role === 'cliente')
    <form method="POST" action="{{ route('plans.select') }}">
        @csrf
        <input type="hidden" name="plan" value="{{ $planKey }}">
        <button type="submit" class="w-full {{ $buttonClass }} rounded-xl px-4 py-3 font-bold text-white shadow-lg transition-all">
            Solicitar servicio
        </button>
    </form>
@elseif(!Auth::check())
    <a href="{{ route('plans.begin-request', $planKey) }}" class="block w-full {{ $buttonClass }} rounded-xl px-4 py-3 text-center font-bold text-white shadow-lg transition-all">Solicitar servicio</a>
@else
    <button type="button" disabled class="w-full cursor-not-allowed rounded-xl bg-slate-400 px-4 py-3 font-bold text-white">Disponible para clientes</button>
@endif
