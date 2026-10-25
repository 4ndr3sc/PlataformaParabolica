@php
    $horizontalNavigation = $horizontalNavigation ?? false;
    $navigationGroups = [
        [
            'label' => 'Funciones de usuario',
            'links' => [
                ['label' => 'Resumen', 'url' => '/dashboard', 'icon' => 'fas fa-th-large'],
                ['label' => 'Mis facturas', 'url' => '/facturas', 'icon' => 'fas fa-file-invoice-dollar'],
                ['label' => 'Soporte técnico', 'url' => '/soporte', 'icon' => 'fas fa-tools'],
                ['label' => 'Crear solicitud', 'url' => '/soporte/crear', 'icon' => 'fas fa-plus-circle'],
                ['label' => 'Aplicación', 'url' => '/app/descargar', 'icon' => 'fas fa-mobile-alt'],
                ['label' => 'Mi perfil', 'url' => '/perfil', 'icon' => 'fas fa-user-cog'],
            ],
        ],
        [
            'label' => 'Funciones de técnico',
            'links' => [
                ['label' => 'Asignaciones', 'url' => '/tecnico/asignaciones', 'icon' => 'fas fa-clipboard-list'],
                ['label' => 'Actualizar estados', 'url' => '/tecnico/estados', 'icon' => 'fas fa-tasks'],
                ['label' => 'Historial de soporte', 'url' => '/tecnico/historial', 'icon' => 'fas fa-history'],
            ],
        ],
        [
            'label' => 'Funciones de administración',
            'links' => [
                ['label' => 'Control de accesos', 'url' => '/admin/dashboard', 'icon' => 'fas fa-user-shield'],
                ['label' => 'Asignar técnico', 'url' => '/admin/tickets/asignar', 'icon' => 'fas fa-user-plus'],
                ['label' => 'Control de validación', 'url' => '/admin/validacion', 'icon' => 'fas fa-clipboard-check'],
                ['label' => 'Reportes y analítica', 'url' => '/admin/reportes', 'icon' => 'fas fa-chart-line'],
            ],
        ],
    ];
    $isDarkNavigation = request()->is('aplicacion') || request()->is('app/descargar');
    $linkClass = $isDarkNavigation
        ? 'text-slate-400 hover:bg-slate-800 hover:text-white'
        : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900';
    $activeClass = $isDarkNavigation
        ? 'bg-blue-600/20 text-blue-400 border border-blue-600/50'
        : 'bg-blue-100 text-blue-600 border border-blue-300';
@endphp

<div class="{{ $horizontalNavigation ? 'flex min-w-max gap-4' : '' }}">
    @foreach($navigationGroups as $group)
        <section class="{{ $horizontalNavigation ? ($loop->first ? 'pr-4' : 'border-l border-slate-300 pl-4') : ($loop->first ? '' : 'border-t border-slate-300 pt-3 mt-3') }}">
            <h2 class="px-3 pb-1 text-[10px] font-bold uppercase tracking-widest {{ $isDarkNavigation ? 'text-slate-500' : 'text-slate-400' }}">
                {{ $group['label'] }}
            </h2>
            <div class="{{ $horizontalNavigation ? 'flex gap-1' : 'space-y-1' }}">
                @foreach($group['links'] as $link)
                    @php
                        $path = trim(parse_url($link['url'], PHP_URL_PATH), '/');
                        $isActive = request()->is($path) || request()->is($path . '/*');
                    @endphp
                    <a href="{{ url($link['url']) }}" class="flex items-center gap-3 p-3 {{ $isActive ? $activeClass : $linkClass }} rounded-xl transition-all whitespace-nowrap">
                        <i class="{{ $link['icon'] }}"></i>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach
</div>
