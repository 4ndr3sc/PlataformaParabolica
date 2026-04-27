<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | AsoTV Guachetá</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        /* Estilos para el efecto de la foto de perfil */
        #profile-avatar-zone {
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        #profile-avatar-zone:hover .avatar-overlay {
            opacity: 1;
        }
        .avatar-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
            font-size: 10px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 font-sans flex flex-col md:flex-row h-screen">

    <!-- Sidebar Mobile Overlay -->
    <div id="mobile-menu" class="fixed inset-0 bg-black/50 hidden md:hidden z-40" onclick="closeMobileMenu()"></div>
    
    <!-- Hamburger Menu Button -->
    <button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-slate-950 text-white p-3 rounded-lg border border-slate-800" onclick="toggleMobileMenu()">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <aside id="sidebar" class="w-64 bg-slate-950 border-r border-slate-800 hidden md:flex flex-col flex-shrink-0 h-screen fixed md:relative z-50 md:z-auto">
        <div class="p-4 md:p-6 flex-1">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-black text-blue-500 tracking-tighter uppercase">ASOTV</span>
                    <span class="text-xl font-bold text-yellow-500 uppercase hidden sm:inline">GUACHETA</span>
                </div>
                <button class="md:hidden text-white" onclick="closeMobileMenu()">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <nav class="space-y-4">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 p-3 bg-blue-600/20 text-blue-400 rounded-xl border border-blue-600/50 shadow-lg shadow-blue-900/20">
                    <i class="fas fa-th-large"></i> <span class="font-bold">Resumen</span>
                </a>
                <a href="{{ url('/facturas') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Mis Facturas</span>
                </a>
                <a href="{{ url('/soporte') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <i class="fas fa-tools"></i> <span>Soporte Técnico</span>
                </a>
                <a href="{{ url('/perfil') }}" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
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
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0 mb-6 md:mb-10 mt-12 md:mt-0">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white uppercase tracking-tight">Bienvenido, <span class="text-yellow-500 italic block md:inline">{{ Auth::check() ? Auth::user()->name : 'Usuario' }}</span></h1>
                <p class="text-slate-300 md:text-slate-400 text-sm md:text-base">Aquí tienes el estado de tus servicios en Guachetá.</p>
            </div>
            
            <div class="flex items-center gap-3 md:gap-4 bg-slate-800 p-2 md:pr-6 rounded-full border border-slate-700">
                <div id="profile-avatar-zone" class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center shadow-lg relative photo-upload-trigger">
                    
                    <img id="profile-image-display" 
                         src="{{ (Auth::check() && Auth::user()->profile_photo) ? asset('storage/profile_photos/' . Auth::user()->profile_photo) : '' }}" 
                         class="w-full h-full object-cover {{ (Auth::check() && Auth::user()->profile_photo) ? '' : 'hidden' }}"
                         alt="Foto de perfil">
                    
                    <div id="profile-initial-display" 
                         class="w-full h-full bg-blue-600 flex items-center justify-center font-bold {{ (Auth::check() && Auth::user()->profile_photo) ? 'hidden' : '' }}">
                         {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'U' }}
                    </div>

                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <span class="font-bold text-xs md:text-sm hidden sm:inline">Estado: <span class="text-green-400">Activo</span></span>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-10">
            <div class="bg-slate-800 p-4 md:p-6 rounded-2xl md:rounded-3xl border-b-4 border-blue-500 shadow-xl">
                <p class="text-slate-400 text-xs md:text-sm font-bold uppercase mb-2">Plan Actual</p>
                <h3 class="text-xl md:text-2xl font-black text-white">50MB FIBRA</h3>
                <p class="text-blue-400 text-xs mt-2 font-bold uppercase tracking-widest italic">Velocidad Simétrica</p>
            </div>
            <div class="bg-slate-800 p-4 md:p-6 rounded-2xl md:rounded-3xl border-b-4 border-yellow-500 shadow-xl">
                <p class="text-slate-400 text-xs md:text-sm font-bold uppercase mb-2">Próximo Pago</p>
                <h3 class="text-xl md:text-2xl font-black text-white">$ 65.000</h3>
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
                                avatarZone.appendChild(newImg);
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
                            initialDisplay.classList.add('hidden');
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