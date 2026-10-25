@php
    $navigationLinks = [
        ['label' => 'Volver al dashboard', 'url' => '/dashboard', 'icon' => 'fas fa-arrow-left'],
        ['label' => 'Usuarios y roles', 'url' => '/admin/dashboard', 'icon' => 'fas fa-user-shield'],
        ['label' => 'Asignar técnico', 'url' => '/admin/tickets/asignar', 'icon' => 'fas fa-user-plus'],
        ['label' => 'Validación', 'url' => '/admin/validacion', 'icon' => 'fas fa-clipboard-check'],
        ['label' => 'Reportes', 'url' => '/admin/reportes', 'icon' => 'fas fa-chart-line'],
    ];
@endphp

<nav aria-label="Funciones administrativas" class="flex min-w-max items-center gap-1">
    @foreach($navigationLinks as $link)
        @php
            $path = trim(parse_url($link['url'], PHP_URL_PATH), '/');
            $isActive = request()->is($path) || request()->is($path . '/*');
        @endphp
        @if($loop->first)
            <span class="mr-2 hidden px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 lg:inline">Administración</span>
        @elseif($loop->index === 1)
            <span aria-hidden="true" class="mx-2 h-7 border-l border-slate-300"></span>
        @endif
        <a href="{{ url($link['url']) }}" class="inline-flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $isActive ? 'border border-blue-200 bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="{{ $link['icon'] }}"></i>
            <span>{{ $link['label'] }}</span>
        </a>
    @endforeach
</nav>
