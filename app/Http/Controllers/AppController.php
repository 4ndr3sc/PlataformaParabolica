<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Mostrar página de descarga de la aplicación móvil
     */
    public function descargar()
    {
        return view('app-descargar');
    }

    /**
     * Descargar el archivo APK de la aplicación
     */
    public function downloadAPK()
    {
        $filePath = storage_path('app/public/AsoTV-App.apk');
        
        // Verificar si el archivo existe
        if (!file_exists($filePath)) {
            return back()->with('error', 'El archivo de la aplicación no está disponible en este momento.');
        }

        // Descargar el archivo
        return response()->download($filePath, 'AsoTV-App.apk');
    }

    /**
     * Descargar el archivo IPA de la aplicación (para iOS)
     */
    public function downloadIPA()
    {
        $filePath = storage_path('app/public/AsoTV-App.ipa');
        
        // Verificar si el archivo existe
        if (!file_exists($filePath)) {
            return back()->with('error', 'La aplicación para iOS no está disponible en este momento.');
        }

        // Descargar el archivo
        return response()->download($filePath, 'AsoTV-App.ipa');
    }
}
