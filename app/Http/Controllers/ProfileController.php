<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Verifica y crea el symlink de storage si no existe
     */
    private function ensureStorageSymlink()
    {
        $symlink = public_path('storage');
        $storagePath = storage_path('app/public');
        
        if (!is_link($symlink)) {
            try {
                if (file_exists($symlink)) {
                    if (is_dir($symlink)) {
                        rmdir($symlink);
                    } else {
                        unlink($symlink);
                    }
                }
                symlink($storagePath, $symlink);
                Log::info('Storage symlink creado exitosamente');
            } catch (\Exception $e) {
                Log::warning('No se pudo crear symlink de storage: ' . $e->getMessage());
            }
        }
    }

    public function uploadPhoto(Request $request)
    {
        try {
            // Asegurar que el symlink existe
            $this->ensureStorageSymlink();

            // 1. Validar que sea una imagen
            $validated = $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
            ]);

            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            // 2. Eliminar foto antigua si existe
            if ($user->profile_photo) {
                try {
                    Storage::disk('public')->delete($user->profile_photo);
                } catch (\Exception $e) {
                    Log::warning('No se pudo eliminar foto antigua: ' . $e->getMessage());
                }
            }

            // 3. Guardar nueva foto en storage/app/public/profile_photos
            $file = $request->file('photo');
            if (!$file || !$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo no es válido'
                ], 422);
            }

            $path = $file->store('profile_photos', 'public');
            
            if (!$path) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al guardar el archivo'
                ], 500);
            }

            // 4. Actualizar base de datos
            $user->profile_photo = $path;
            $user->save();
            
            // 5. Refrescar el usuario en la sesión
            Auth::refresh();

            // 6. Generar URL de forma robusta para XAMPP/SQLite
            $photoUrl = asset('storage/' . $path);
            
            // Verificar que el archivo existe en el storage
            if (!Storage::disk('public')->exists($path)) {
                Log::error('Archivo guardado pero no encontrado: ' . $path);
                return response()->json([
                    'success' => false,
                    'message' => 'Archivo guardado pero no accesible'
                ], 500);
            }
            
            return response()->json([
                'success' => true,
                'photo_url' => $photoUrl,
                'photo_path' => $path,
                'message' => 'Foto actualizada correctamente'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validación fallida: ' . implode(', ', $e->errors()['photo'] ?? ['Error desconocido']),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al subir foto de perfil: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}