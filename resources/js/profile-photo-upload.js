/**
 * Sistema Global de Upload de Foto de Perfil
 * Este script maneja el upload de fotos en todos los espacios del sitio
 * y actualiza todos los avatares automáticamente
 */

class ProfilePhotoUpload {
    constructor(options = {}) {
        this.uploadRoute = options.uploadRoute || '/profile/upload-photo';
        this.csrfToken = this.getCSRFToken();
        this.init();
    }

    init() {
        // Buscar todos los elementos clickeables para upload de foto
        this.setupPhotoUploadZones();
        this.setupPhotoInputs();
        this.loadPhotoFromStorage();
    }

    setupPhotoUploadZones() {
        // Seleccionar todos los avatares clickeables (con clase 'photo-upload-trigger')
        const uploadZones = document.querySelectorAll('.photo-upload-trigger');
        
        uploadZones.forEach(zone => {
            zone.style.cursor = 'pointer';
            zone.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Encontrar el input de foto asociado o crear uno
                let photoInput = zone.querySelector('input[type="file"]');
                if (!photoInput) {
                    photoInput = document.getElementById('profile-photo-input');
                }
                if (!photoInput) {
                    photoInput = this.createHiddenPhotoInput();
                }
                
                photoInput.click();
            });

            // Agregar efecto visual al hover
            zone.addEventListener('mouseenter', () => {
                zone.style.opacity = '0.7';
            });
            zone.addEventListener('mouseleave', () => {
                zone.style.opacity = '1';
            });
        });
    }

    setupPhotoInputs() {
        // Seleccionar todos los inputs de tipo file para foto
        const photoInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
        
        photoInputs.forEach(input => {
            input.addEventListener('change', (e) => this.handlePhotoSelect(e));
        });
    }

    handlePhotoSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Validaciones
        if (!file.type.startsWith('image/')) {
            this.showNotification('Por favor, selecciona una imagen válida', 'error');
            return;
        }

        if (file.size > 2048 * 1024) { // 2MB
            this.showNotification('La imagen no debe superar 2MB', 'error');
            return;
        }

        // Mostrar indicador de carga
        this.showNotification('Subiendo foto...', 'loading');

        // Preparar FormData
        const formData = new FormData();
        formData.append('photo', file);

        // Hacer upload
        fetch(this.uploadRoute, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const photoUrl = data.photo_url + '?t=' + new Date().getTime();
                
                // Guardar en localStorage para sincronizar entre tabs/sesiones
                localStorage.setItem('profilePhotoUrl', photoUrl);
                localStorage.setItem('profilePhotoTimestamp', new Date().getTime());
                
                // Actualizar todos los avatares en la página
                this.updateAllAvatars(photoUrl);
                
                this.showNotification('¡Foto actualizada exitosamente!', 'success');
                
                // Limpiar input
                event.target.value = '';
                
                // Disparar evento personalizado para otras partes de la aplicación
                document.dispatchEvent(new CustomEvent('profilePhotoUpdated', { 
                    detail: { photoUrl: photoUrl } 
                }));
            } else {
                this.showNotification('Error al subir la foto: ' + (data.message || 'Intenta nuevamente'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.showNotification('Error al procesar la solicitud', 'error');
        });
    }

    updateAllAvatars(photoUrl) {
        // Actualizar avatares por ID
        const avatarIds = [
            'profile-image-display',
            'profileImg',
            'avatarDisplay'
        ];

        avatarIds.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                if (element.tagName === 'IMG') {
                    element.src = photoUrl;
                    element.classList.remove('hidden');
                } else {
                    element.innerHTML = `<img src="${photoUrl}" alt="Foto de perfil" class="w-full h-full object-cover">`;
                }
            }
        });

        // Actualizar elementos con clase 'profile-avatar'
        const avatarElements = document.querySelectorAll('.profile-avatar');
        avatarElements.forEach(element => {
            if (element.tagName === 'IMG') {
                element.src = photoUrl;
                element.classList.remove('hidden');
            } else {
                element.innerHTML = `<img src="${photoUrl}" alt="Foto de perfil" class="w-full h-full object-cover">`;
            }
        });

        // Actualizar display inicial (si existe) ocultándolo
        const initialDisplayIds = ['profile-initial-display', 'avatarInitial'];
        initialDisplayIds.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.classList.add('hidden');
            }
        });
    }

    loadPhotoFromStorage() {
        const savedPhotoUrl = localStorage.getItem('profilePhotoUrl');
        if (savedPhotoUrl) {
            this.updateAllAvatars(savedPhotoUrl);
        }
    }

    createHiddenPhotoInput() {
        let input = document.getElementById('profile-photo-input');
        if (!input) {
            input = document.createElement('input');
            input.type = 'file';
            input.id = 'profile-photo-input';
            input.name = 'photo';
            input.accept = 'image/*';
            input.style.display = 'none';
            input.addEventListener('change', (e) => this.handlePhotoSelect(e));
            document.body.appendChild(input);
        }
        return input;
    }

    showNotification(message, type) {
        // Buscar elemento de notificación existente
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
            `;
            document.body.appendChild(notification);
        }

        notification.textContent = message;
        notification.style.display = 'block';

        // Estilos según tipo
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

        // Auto-ocultar después de 3 segundos (solo para success y error)
        if (type !== 'loading') {
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }
    }

    getCSRFToken() {
        // Buscar en meta tags
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) return metaToken.getAttribute('content');
        
        // Buscar en inputs (para formularios)
        const inputToken = document.querySelector('input[name="_token"]');
        if (inputToken) return inputToken.value;
        
        return '';
    }
}

// Inicializar automáticamente cuando DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.profilePhotoUpload = new ProfilePhotoUpload({
        uploadRoute: window.uploadPhotoRoute || '/profile/upload-photo'
    });
});

// Agregar estilos de animación
const style = document.createElement('style');
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
