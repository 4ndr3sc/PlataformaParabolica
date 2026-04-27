<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        // 1. Validar que sea una imagen
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $user = Auth::user();

        // 2. Eliminar foto antigua si existe
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // 3. Guardar nueva foto en storage/app/public/profile_photos
        $path = $request->file('photo')->store('profile_photos', 'public');

        // 4. Actualizar base de datos
        $user->profile_photo = $path;
        $user->save();
        
        // 5. Refrescar el usuario en la sesión
        Auth::refresh();

        // 6. Generar URL de forma robusta para XAMPP/SQLite
        $photoUrl = url('storage/' . $path);
        
        return response()->json([
            'success' => true,
            'photo_url' => $photoUrl,
            'photo_path' => $path,
            'message' => 'Foto actualizada correctamente'
        ]);
    }
}