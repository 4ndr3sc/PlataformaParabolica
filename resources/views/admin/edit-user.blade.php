@extends('layouts.app')

@section('title', 'Editar Usuario - Panel Administrativo')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Editar Usuario</h1>
                    <p class="text-gray-600 mt-1">Gestiona el perfil y rol del usuario</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left"></i> Atrás
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
                <div>
                    <h3 class="font-semibold mb-2">Errores en el formulario:</h3>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- User Info Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fas fa-user-circle text-blue-500"></i> Información del Usuario
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo</label>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-800">
                        {{ $user->name }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-800">
                        {{ $user->email }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-800">
                        {{ $user->phone ?? 'No registrado' }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Documento</label>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-800">
                        {{ $user->document ?? 'No registrado' }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ciudad</label>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-800">
                        {{ $user->city ?? 'No registrado' }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Departamento</label>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-800">
                        {{ $user->department ?? 'No registrado' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Management Card -->
        <form action="{{ route('admin.update-role', $user->id) }}" method="POST">
            @csrf
            
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-shield-alt text-purple-500"></i> Gestión de Rol
                </h2>

                <!-- Current Role -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Rol Actual</label>
                    <div class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                        @if($user->role === 'administrador')
                            bg-red-100 text-red-800
                        @elseif($user->role === 'tecnico')
                            bg-blue-100 text-blue-800
                        @else
                            bg-gray-100 text-gray-800
                        @endif
                    ">
                        <i class="fas 
                            @if($user->role === 'administrador')
                                fa-crown
                            @elseif($user->role === 'tecnico')
                                fa-tools
                            @else
                                fa-user
                            @endif
                        mr-2"></i>
                        {{ ucfirst($user->role) }}
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="mb-6">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-3">Asignar Nuevo Rol</label>
                    <select name="role" id="role" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @foreach($roles as $rol)
                            <option value="{{ $rol }}" {{ $user->role === $rol ? 'selected' : '' }}>
                                {{ ucfirst($rol) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Role Descriptions -->
                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-blue-900 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> Descripción de Roles
                    </h3>
                    <ul class="text-sm text-blue-800 space-y-2">
                        <li>
                            <span class="font-semibold"><i class="fas fa-user"></i> Cliente:</span> 
                            Acceso básico a la plataforma, ver sus servicios y soporte
                        </li>
                        <li>
                            <span class="font-semibold"><i class="fas fa-tools"></i> Técnico:</span> 
                            Gestionar tickets de soporte y brindar asistencia técnica
                        </li>
                        <li>
                            <span class="font-semibold"><i class="fas fa-crown"></i> Administrador:</span> 
                            Acceso total, gestión de usuarios, roles y panel administrativo
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-medium">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition font-medium">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
