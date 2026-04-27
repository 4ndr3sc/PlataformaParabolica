<?php
// Script de prueba para diagnosticar el almacenamiento de fotos

require 'bootstrap/app.php';

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = \Illuminate\Http\Request::capture()
);

// Obtener usuario autenticado (simulado con el primero)
$user = DB::table('users')->first();

if (!$user) {
    echo "No hay usuarios en la base de datos\n";
    exit;
}

echo "=== DIAGNÓSTICO DE ALMACENAMIENTO ===\n\n";
echo "Usuario: " . $user->name . "\n";
echo "Email: " . $user->email . "\n";
echo "profile_photo: " . ($user->profile_photo ?? 'NULL') . "\n\n";

if ($user->profile_photo) {
    $photoPath = $user->profile_photo;
    $fullPath = storage_path('app/public/' . $photoPath);
    
    echo "=== RUTAS ===\n";
    echo "Ruta relativa guardada: " . $photoPath . "\n";
    echo "Ruta completa storage: " . $fullPath . "\n";
    echo "Ruta pública: http://localhost/storage/" . $photoPath . "\n\n";
    
    echo "=== VERIFICACIONES ===\n";
    echo "¿Archivo existe en storage? " . (file_exists($fullPath) ? "SÍ" : "NO") . "\n";
    echo "¿Symlink /public/storage existe? " . (is_dir(public_path('storage')) ? "SÍ" : "NO") . "\n";
    
    if (file_exists($fullPath)) {
        echo "Tamaño del archivo: " . filesize($fullPath) . " bytes\n";
        echo "Permisos: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "\n";
    }
    
    echo "\n=== ACCESO DIRECTO ===\n";
    if (file_exists(public_path('storage/' . $photoPath))) {
        echo "¿Accesible vía /public/storage? SÍ\n";
    } else {
        echo "¿Accesible vía /public/storage? NO\n";
    }
}
?>
