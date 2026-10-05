<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
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

Route::post('/chatbot/reply', [ChatbotController::class, 'reply'])
    ->middleware('throttle:20,1')
    ->name('chatbot.reply');

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

        if ($user && $user->role === 'tecnico') {
            return redirect('/tecnico/asignaciones');
        }

        // Cargamos los tickets con un try-catch preventivo
        try {
            if ($user && $user->role === 'administrador') {
                $users = \App\Models\User::all();
                $totalTickets = \App\Models\Ticket::count();
                $openTickets = \App\Models\Ticket::where('status', 'abierto')->count();
                $unresolvedTickets = \App\Models\Ticket::whereNotIn('status', ['resuelto', 'cerrado'])->count();
                // Mostrar los tickets más recientes en el dashboard admin
                $tickets = \App\Models\Ticket::latest()->take(10)->get();
                return view('dashboard', compact('user', 'tickets', 'users', 'totalTickets', 'openTickets', 'unresolvedTickets'));
            }

            $tickets = \App\Models\Ticket::where('user_id', $user->id)->get();
        } catch (\Exception $e) {
            $tickets = collect(); // Evita que la vista falle si la tabla no existe
            $users = collect();
            $totalTickets = 0;
            $openTickets = 0;
            $unresolvedTickets = 0;
        }

        return view('dashboard', ['user' => $user, 'tickets' => $tickets, 'users' => $users ?? null, 'totalTickets' => $totalTickets ?? 0, 'openTickets' => $openTickets ?? 0, 'unresolvedTickets' => $unresolvedTickets ?? 0]);
    });

    Route::get('/facturas', function () {
        $user = Auth::user();

        // Métricas para administradores sobre pagos
        $paid_this_month = 0;
        $unpaid_this_month = 0;
        $unpaid_previous_months = 0;
        $total_users = 0;

        // Listas por defecto (vacías) para evitar errores en la vista cuando no existen
        $paid_users_this_month = collect();
        $unpaid_users_this_month = collect();
        $unpaid_users_previous_months = collect();
        $all_users = collect();

        if ($user && $user->role === 'administrador') {
            try {
                $total_users = \App\Models\User::count();

                // Usamos consultas directas a la tabla 'invoices' si existe
                if (\Schema::hasTable('invoices')) {
                    $now = \Carbon\now();
                    $month = $now->month;
                    $year = $now->year;

                    // Usuarios que tienen al menos una factura pagada este mes
                    $paid_this_month = \DB::table('invoices')
                        ->whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->where('status', 'paid')
                        ->distinct('user_id')
                        ->count('user_id');

                    // Usuarios con factura pendiente este mes
                    $unpaid_this_month = \DB::table('invoices')
                        ->whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->whereIn('status', ['pending', 'unpaid'])
                        ->distinct('user_id')
                        ->count('user_id');

                    // Usuarios que no han pagado en meses anteriores (tienen facturas pendientes en meses previos)
                    $unpaid_previous_months = \DB::table('invoices')
                        ->where(function ($q) use ($month, $year) {
                            $q->whereYear('date', '<', $year)
                              ->orWhere(function($q2) use ($month, $year) {
                                  $q2->whereYear('date', $year)->whereMonth('date', '<', $month);
                              });
                        })
                        ->whereIn('status', ['pending', 'unpaid'])
                        ->distinct('user_id')
                        ->count('user_id');

                    // Además, obtener listados de usuarios por categoría (limitados)
                    $paid_users_this_month = collect();
                    $unpaid_users_this_month = collect();
                    $unpaid_users_previous_months = collect();

                    $limit = 1000;

                    $paid_users_this_month = \DB::table('invoices')
                        ->join('users', 'invoices.user_id', '=', 'users.id')
                        ->whereMonth('invoices.date', $month)
                        ->whereYear('invoices.date', $year)
                        ->where('invoices.status', 'paid')
                        ->select('users.id', 'users.name', 'users.email', 'users.phone')
                        ->distinct('users.id')
                        ->limit($limit)
                        ->get();

                    $unpaid_users_this_month = \DB::table('invoices')
                        ->join('users', 'invoices.user_id', '=', 'users.id')
                        ->whereMonth('invoices.date', $month)
                        ->whereYear('invoices.date', $year)
                        ->whereIn('invoices.status', ['pending', 'unpaid'])
                        ->select('users.id', 'users.name', 'users.email', 'users.phone')
                        ->distinct('users.id')
                        ->limit($limit)
                        ->get();

                    $unpaid_users_previous_months = \DB::table('invoices')
                        ->join('users', 'invoices.user_id', '=', 'users.id')
                        ->where(function ($q) use ($month, $year) {
                            $q->whereYear('invoices.date', '<', $year)
                              ->orWhere(function($q2) use ($month, $year) {
                                  $q2->whereYear('invoices.date', $year)->whereMonth('invoices.date', '<', $month);
                              });
                        })
                        ->whereIn('invoices.status', ['pending', 'unpaid'])
                        ->select('users.id', 'users.name', 'users.email', 'users.phone')
                        ->distinct('users.id')
                        ->limit($limit)
                        ->get();

                    // Lista completa (limitada) de usuarios
                    $all_users = \App\Models\User::select('id','name','email','phone')->limit($limit)->get();
                }
            } catch (\Exception $e) {
                // Si no existe la tabla o hay error, dejamos los valores en 0
                $paid_this_month = 0;
                $unpaid_this_month = 0;
                $unpaid_previous_months = 0;
                $paid_users_this_month = collect();
                $unpaid_users_this_month = collect();
                $unpaid_users_previous_months = collect();
                $all_users = collect();
            }
        }

        return view('facturas', compact('user', 'paid_this_month', 'unpaid_this_month', 'unpaid_previous_months', 'total_users', 'paid_users_this_month', 'unpaid_users_this_month', 'unpaid_users_previous_months', 'all_users'));
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

    Route::middleware('role:tecnico')->group(function () {
        Route::get('/tecnico/asignaciones', function () {
            $tickets = \App\Models\Ticket::where('technician_id', Auth::id())->latest()->take(10)->get();
            return view('tecnico.operaciones', [
                'user' => Auth::user(),
                'section' => 'asignaciones',
                'title' => 'Asignaciones',
                'tickets' => $tickets,
                'metrics' => [
                    ['label' => 'Asignados', 'value' => $tickets->count(), 'color' => 'blue'],
                    ['label' => 'Abiertos', 'value' => $tickets->where('status', 'abierto')->count(), 'color' => 'yellow'],
                    ['label' => 'Resueltos', 'value' => $tickets->where('status', 'resuelto')->count(), 'color' => 'green'],
                ],
            ]);
        });

        Route::get('/tecnico/estados', function () {
            $tickets = \App\Models\Ticket::where('technician_id', Auth::id())->latest()->take(10)->get();
            return view('tecnico.operaciones', [
                'user' => Auth::user(),
                'section' => 'estados',
                'title' => 'Actualizar estados',
                'tickets' => $tickets,
                'metrics' => [
                    ['label' => 'En revisión', 'value' => $tickets->where('status', 'en_progreso')->count(), 'color' => 'yellow'],
                    ['label' => 'Abiertos', 'value' => $tickets->where('status', 'abierto')->count(), 'color' => 'blue'],
                    ['label' => 'Cerrados', 'value' => $tickets->where('status', 'cerrado')->count(), 'color' => 'slate'],
                ],
            ]);
        });

        Route::post('/tecnico/tickets/{id}/estado', function ($id, \Illuminate\Http\Request $request) {
            $request->validate([
                'status' => 'required|in:abierto,en_progreso,resuelto,cerrado',
            ]);

            $ticket = \App\Models\Ticket::where('id', $id)->where('technician_id', Auth::id())->firstOrFail();
            $ticket->update(['status' => $request->status]);

            $redirectTo = str_contains(url()->previous(), '/tecnico/estados') ? '/tecnico/estados' : '/tecnico/asignaciones';
            return redirect($redirectTo)->with('success', 'Estado del ticket actualizado correctamente.');
        });

        Route::get('/tecnico/historial', function () {
            $tickets = \App\Models\Ticket::where('technician_id', Auth::id())->latest()->take(12)->get();
            return view('tecnico.operaciones', [
                'user' => Auth::user(),
                'section' => 'historial',
                'title' => 'Historial de soporte',
                'tickets' => $tickets,
                'metrics' => [
                    ['label' => 'Total', 'value' => $tickets->count(), 'color' => 'blue'],
                    ['label' => 'Resueltos', 'value' => $tickets->where('status', 'resuelto')->count(), 'color' => 'green'],
                    ['label' => 'Pendientes', 'value' => $tickets->whereNotIn('status', ['resuelto', 'cerrado'])->count(), 'color' => 'yellow'],
                ],
            ]);
        });
    });

    // Acciones de Perfil
    Route::post('/perfil/update', [AuthController::class, 'updateProfile']);
    Route::post('/perfil/password', [AuthController::class, 'updatePassword']);
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload_photo');

    // Gestión de Tickets
    Route::get('/soporte/crear', [TicketController::class, 'showCreateForm']);
    Route::post('/ticket/crear', [TicketController::class, 'store']);

    // --- Rutas de Administración (Solo Administradores) ---
    Route::middleware('role:administrador')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.store-user');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit-user');
        Route::post('/admin/users/{id}/update-role', [AdminController::class, 'updateRole'])->name('admin.update-role');
        Route::post('/admin/users/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggle-status');
        Route::get('/admin/tickets/asignar', [AdminController::class, 'ticketAssignmentPage'])->name('admin.ticket-assignment');
        Route::get('/admin/validacion', [AdminController::class, 'validationOverview'])->name('admin.validacion');
        Route::get('/admin/reportes', [AdminController::class, 'reports'])->name('admin.reportes');
        Route::get('/admin/reportes/exportar', [AdminController::class, 'exportReports'])->name('admin.reportes.export');
        Route::post('/admin/tickets/{ticketId}/assign', [AdminController::class, 'assignTicketToTechnician'])->name('admin.assign-ticket');
        Route::patch('/admin/tickets/{ticketId}/status', [AdminController::class, 'updateTicketStatus'])->name('admin.update-ticket-status');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });
});