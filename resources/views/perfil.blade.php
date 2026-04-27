<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mi Perfil | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 font-sans flex flex-col md:flex-row h-screen">

    <aside class="w-64 bg-slate-950 border-r border-slate-800 hidden md:flex flex-col flex-shrink-0 h-screen fixed md:relative z-50 md:z-auto">
        <div class="p-6 flex-1">
            <div class="flex items-center gap-2 mb-10">
                <span class="text-2xl font-black text-blue-500 tracking-tighter uppercase">ASOTV</span>
                <span class="text-xl font-bold text-yellow-500 uppercase">GUACHETA </span>
            </div>
            
            <nav class="space-y-4">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-th-large"></i> <span class="font-bold">Resumen</span>
                </a>
                <a href="{{ url('/facturas') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Mis Facturas</span>
                </a>
                <a href="{{ url('/soporte') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-tools"></i> <span>Soporte Técnico</span>
                </a>
                <a href="{{ url('/perfil') }}" class="flex items-center gap-3 p-3 bg-blue-600/20 text-blue-400 rounded-xl border border-blue-600/50 shadow-lg shadow-blue-900/20">
                    <i class="fas fa-user-cog"></i> <span>Mi Perfil</span>
                </a>
                <a href="{{ url('/app/descargar') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-green-500/20 hover:text-green-400 rounded-xl transition-all border border-transparent hover:border-green-500/50">
                    <i class="fas fa-mobile-alt"></i> <span>Aplicación</span>
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-slate-800">
            <a href="{{ url('/logout') }}" class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition-all font-bold">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <main class="flex-1 w-full h-full p-4 md:p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-white uppercase tracking-tight">Mi <span class="text-yellow-500 italic">Perfil</span></h1>
                <p class="text-slate-400">Actualiza tu información personal y configuración de cuenta.</p>
            </div>
            <div class="flex items-center gap-4 bg-slate-800 p-2 pr-6 rounded-full border border-slate-700">
                <div id="profile-avatar-zone" class="w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg overflow-hidden bg-blue-600 border border-blue-500 photo-upload-trigger cursor-pointer relative group">
                    @if($user->profile_photo)
                        <img id="profile-image-display" src="{{ asset('storage/' . $user->profile_photo) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <span id="profile-initial-display">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                    @endif
                    <div class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-camera text-white text-xs"></i>
                    </div>
                </div>
                <span class="font-bold text-sm">Estado: <span class="text-green-400">Activo</span></span>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información Personal -->
            <div class="lg:col-span-2">
                <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden">
                    <div class="p-6 border-b border-slate-700">
                        <h2 class="text-xl font-bold text-white uppercase flex items-center gap-2">
                            <i class="fas fa-user"></i> Información Personal
                        </h2>
                    </div>
                    <form action="{{ url('/perfil/update') }}" method="POST" class="p-8 space-y-6">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Nombre Completo</label>
                                <input type="text" name="name" value="{{ $user->name ?? '' }}" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Email</label>
                                <input type="email" name="email" value="{{ $user->email ?? '' }}" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Teléfono</label>
                                <input type="tel" name="phone" value="{{ $user->phone ?? '' }}" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="+57 3001234567">
                            </div>
                            <div>
                                <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Documento</label>
                                <input type="text" name="document" value="{{ $user->document ?? '' }}" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="12345678901">
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Dirección</label>
                            <input type="text" name="address" value="{{ $user->address ?? '' }}" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Carrera 5 #10-20">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Ciudad</label>
                                <input type="text" name="city" value="{{ $user->city ?? '' }}" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Guachetá">
                            </div>
                            <div>
                                <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Departamento</label>
                                <input type="text" name="department" value="{{ $user->department ?? '' }}" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Cundinamarca">
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-xl">
                                <ul class="list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-xl">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="flex justify-end gap-4 pt-6 border-t border-slate-700">
                            <button type="reset" class="px-6 py-3 rounded-xl text-white border border-slate-600 hover:bg-slate-700 font-bold uppercase text-sm transition">Cancelar</button>
                            <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold uppercase text-sm transition">Guardar Cambios</button>
                        </div>
                    </form>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden mt-8">
                    <div class="p-6 border-b border-slate-700">
                        <h2 class="text-xl font-bold text-white uppercase flex items-center gap-2">
                            <i class="fas fa-lock"></i> Cambiar Contraseña
                        </h2>
                    </div>
                    <form action="{{ url('/perfil/password') }}" method="POST" class="p-8 space-y-6">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
                        <div>
                            <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Contraseña Actual</label>
                            <input type="password" name="current_password" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="••••••••" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Nueva Contraseña</label>
                                <input type="password" name="new_password" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="••••••••" required>
                            </div>
                            <div>
                                <label class="block text-slate-400 font-bold uppercase text-xs mb-2">Confirmar Contraseña</label>
                                <input type="password" name="new_password_confirmation" class="w-full px-4 py-3 rounded-xl bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="••••••••" required>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-xl">
                                <ul class="list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-xl">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="flex justify-end gap-4 pt-6 border-t border-slate-700">
                            <button type="reset" class="px-6 py-3 rounded-xl text-white border border-slate-600 hover:bg-slate-700 font-bold uppercase text-sm transition">Cancelar</button>
                            <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold uppercase text-sm transition">Actualizar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Panel Lateral -->
            <div class="space-y-6">
                <!-- Foto de Perfil -->
                <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden p-6">
                    <h3 class="text-lg font-bold text-white uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-image"></i> Foto de Perfil
                    </h3>
                    <div class="flex flex-col items-center gap-4">
                        <!-- Avatar Circular -->
                        <div id="avatarDisplay" class="photo-upload-trigger w-32 h-32 bg-blue-600 rounded-full flex items-center justify-center font-bold shadow-lg border-4 border-blue-500 overflow-hidden">
                            @if($user->profile_photo)
                                <img id="profileImg" src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de perfil" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl" id="avatarInitial">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                            @endif
                        </div>
                        
                        <!-- Input de Archivo Oculto -->
                        <input type="file" id="photoInput" accept="image/*" class="hidden">
                        
                        <!-- Botón para Subir Foto -->
                        <button type="button" onclick="document.getElementById('photoInput').click()" class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl uppercase text-sm transition flex items-center justify-center gap-2">
                            <i class="fas fa-camera"></i> Cambiar Foto
                        </button>
                        
                        <!-- Indicador de Carga -->
                        <div id="uploadStatus" class="w-full text-center text-sm hidden"></div>
                    </div>
                </div>

                <!-- Estado de Cuenta -->
                <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden p-6">
                    <h3 class="text-lg font-bold text-white uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-shield-alt"></i> Estado de Cuenta
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Estado</span>
                            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-bold">Activo</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Servicio</span>
                            <span class="text-white font-bold">50MB Fibra</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Cliente Desde</span>
                            <span class="text-white font-bold">15/01/2026</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Renovación</span>
                            <span class="text-white font-bold">15/05/2026</span>
                        </div>
                    </div>
                </div>

                <!-- Preferencias -->
                <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden p-6">
                    <h3 class="text-lg font-bold text-white uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-cog"></i> Preferencias
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Notificaciones por Email</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Notificaciones SMS</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Zona de Peligro -->
                <div class="bg-slate-800 rounded-3xl shadow-xl border border-red-900/50 overflow-hidden p-6">
                    <h3 class="text-lg font-bold text-red-400 uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i> Zona de Peligro
                    </h3>
                    <button class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl uppercase text-xs transition">
                        Eliminar Cuenta
                    </button>
                </div>
            </div>
        </div>
    </main>

    <form id="profile-photo-form" style="display: none;">
        @csrf
        <input type="file" id="profile-photo-input" name="photo" accept="image/*">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarZone = document.getElementById('profile-avatar-zone');
            const photoInput = document.getElementById('profile-photo-input');
            const imageDisplay = document.getElementById('profile-image-display');
            const initialDisplay = document.getElementById('profile-initial-display');

            // Al hacer clic en el círculo, abrimos el selector de archivos
            avatarZone.addEventListener('click', () => photoInput.click());

            // Al seleccionar una imagen, se sube automáticamente
            photoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    
                    // Validación del lado del cliente
                    if (!file.type.startsWith('image/')) {
                        showNotification('Por favor selecciona una imagen válida', 'error');
                        return;
                    }
                    
                    if (file.size > 2 * 1024 * 1024) { // 2MB
                        showNotification('La imagen no debe exceder 2MB', 'error');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('photo', file);

                    // Feedback visual
                    avatarZone.style.opacity = '0.5';
                    showNotification('Subiendo foto...', 'loading');

                    fetch("{{ route('profile.upload_photo') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error ' + response.status + ' del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        avatarZone.style.opacity = '1';
                        
                        if (data.success && data.photo_url) {
                            console.log('Foto subida:', data.photo_url);
                            
                            // Agregar timestamp para evitar cache del navegador
                            const photoUrlWithTimestamp = data.photo_url + '?t=' + new Date().getTime();
                            
                            // Crear nueva imagen si no existe o reemplazarla
                            if (!imageDisplay || imageDisplay.tagName !== 'IMG') {
                                const newImg = document.createElement('img');
                                newImg.id = 'profile-image-display';
                                newImg.className = 'w-full h-full object-cover';
                                newImg.alt = 'Foto de perfil';
                                newImg.onload = function() {
                                    console.log('Imagen cargada exitosamente');
                                    showNotification('¡Foto actualizada exitosamente!', 'success');
                                };
                                newImg.onerror = function() {
                                    console.error('Error al cargar la imagen');
                                    showNotification('Error al cargar la imagen', 'error');
                                };
                                newImg.src = photoUrlWithTimestamp;
                                avatarZone.insertBefore(newImg, initialDisplay);
                                imageDisplay = newImg;
                            } else {
                                imageDisplay.onload = function() {
                                    console.log('Imagen actualizada exitosamente');
                                    showNotification('¡Foto actualizada exitosamente!', 'success');
                                };
                                imageDisplay.onerror = function() {
                                    console.error('Error al cargar la imagen');
                                    showNotification('Error al cargar la imagen', 'error');
                                };
                                imageDisplay.src = photoUrlWithTimestamp;
                            }
                            
                            // Ocultar las iniciales
                            if (initialDisplay) {
                                initialDisplay.style.display = 'none';
                            }
                        } else {
                            const errorMsg = data.message || 'No se pudo subir la foto';
                            console.error('Error en respuesta:', data);
                            showNotification('Error: ' + errorMsg, 'error');
                        }
                    })
                    .catch(error => {
                        avatarZone.style.opacity = '1';
                        console.error('Error en la solicitud:', error);
                        showNotification('Error: ' + error.message, 'error');
                    });
                    
                    // Limpiar input para permitir subir la misma imagen nuevamente
                    this.value = '';
                }
            });
            
            // Función de notificación
            function showNotification(message, type) {
                let notification = document.getElementById('upload-notification');
                if (!notification) {
                    notification = document.createElement('div');
                    notification.id = 'upload-notification';
                    notification.style.cssText = `
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        padding: 12px 20px;
                        border-radius: 8px;
                        font-size: 14px;
                        font-weight: bold;
                        z-index: 9999;
                        animation: slideIn 0.3s ease-out;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                    `;
                    document.body.appendChild(notification);
                }

                notification.textContent = message;
                notification.style.display = 'block';

                if (type === 'success') {
                    notification.style.backgroundColor = '#10b981';
                    notification.style.color = '#fff';
                } else if (type === 'error') {
                    notification.style.backgroundColor = '#ef4444';
                    notification.style.color = '#fff';
                } else if (type === 'loading') {
                    notification.style.backgroundColor = '#3b82f6';
                    notification.style.color = '#fff';
                }

                // Auto-ocultar solo si no es loading
                if (type !== 'loading') {
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 4000);
                }
            }
        });
        
        // Agregar estilos de animación si no existen
        if (!document.getElementById('slide-in-animation')) {
            const style = document.createElement('style');
            style.id = 'slide-in-animation';
            style.textContent = `
                @keyframes slideIn {
                    from {
                        transform: translateX(400px);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    </script>

</body>
</html>
