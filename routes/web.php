<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Auth;

// --- Rutas públicas ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/nosotros', function () {
    return view('nosotros');
});

Route::get('/planes', function () {
    return view('planes', ['user' => Auth::user()]);
});

// Ruta de diagnóstico del storage
Route::get('/storage-fix', function () {
    $storagePath = storage_path('app/public');
    $symlink = public_path('storage');
    
    // Intentar crear symlink si no existe
    if (!is_link($symlink)) {
        try {
            if (file_exists($symlink)) {
                // Eliminar si es una carpeta regular
                if (is_dir($symlink)) {
                    rmdir($symlink);
                } else {
                    unlink($symlink);
                }
            }
            // Crear symlink
            symlink($storagePath, $symlink);
            return response()->json([
                'success' => true,
                'message' => 'Symlink creado exitosamente',
                'symlink_path' => $symlink,
                'storage_path' => $storagePath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear symlink: ' . $e->getMessage(),
                'symlink_path' => $symlink,
                'storage_path' => $storagePath
            ], 500);
        }
    }
    
    return response()->json([
        'success' => true,
        'message' => 'Symlink ya existe',
        'symlink_path' => $symlink,
        'is_link' => is_link($symlink)
    ]);
});

// Ruta de diagnóstico
Route::get('/test-storage', function () {
    $user = Auth::user();
    if (!$user) {
        return 'No autenticado';
    }
    
    $photoPath = $user->profile_photo;
    $publicUrl = $photoPath ? asset('storage/' . $photoPath) : 'Sin foto';
    $storageExists = $photoPath ? file_exists(storage_path('app/public/' . $photoPath)) : false;
    $symlinkPath = public_path('storage');
    $symlinkExists = is_dir($symlinkPath);
    
    return response()->json([
        'user' => $user->name,
        'photo_path' => $photoPath,
        'public_url' => $publicUrl,
        'storage_file_exists' => $storageExists,
        'symlink_path' => $symlinkPath,
        'symlink_exists' => $symlinkExists,
        'storage_full_path' => storage_path('app/public/' . $photoPath),
    ]);
});

// Rutas de la aplicación móvil (Públicas)
Route::get('/app/descargar', [AppController::class, 'descargar']);
Route::get('/app/descargar/apk', [AppController::class, 'downloadAPK']);
Route::get('/app/descargar/ipa', [AppController::class, 'downloadIPA']);

// Rutas de Autenticación (Invitados)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () { return view('login'); })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', function () { return view('register'); });
    Route::post('/register', [AuthController::class, 'register']);
});

// --- Rutas protegidas (Solo usuarios logueados) ---
Route::middleware(['auth'])->group(function () {
    
    Route::get('/logout', [AuthController::class, 'logout']);
    
    Route::get('/dashboard', function () {
        $user = Auth::user();
        // Cargamos los tickets con un try-catch preventivo
        try {
            $tickets = \App\Models\Ticket::where('user_id', $user->id)->get();
        } catch (\Exception $e) {
            $tickets = collect(); // Evita que la vista falle si la tabla no existe
        }
        return view('dashboard', ['user' => $user, 'tickets' => $tickets]);
    });

    Route::get('/facturas', function () {
        return view('facturas', ['user' => Auth::user()]);
    });

    // Ruta de Soporte (Única y protegida)
    Route::get('/soporte', function () {
        $user = Auth::user();
        // Cargamos los tickets con un try-catch preventivo
        try {
            $tickets = \App\Models\Ticket::where('user_id', $user->id)->get();
        } catch (\Exception $e) {
            $tickets = collect(); // Evita que la vista falle si la tabla no existe
        }
        return view('soporte', ['user' => $user, 'tickets' => $tickets]);
    })->name('soporte');

    Route::get('/perfil', function () {
        return view('perfil', ['user' => Auth::user()]);
    });

    // Acciones de Perfil
    Route::post('/perfil/update', [AuthController::class, 'updateProfile']);
    Route::post('/perfil/password', [AuthController::class, 'updatePassword']);
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload_photo');

    // Gestión de Tickets
    Route::get('/soporte/crear', [TicketController::class, 'showCreateForm']);
    Route::post('/ticket/crear', [TicketController::class, 'store']);
});