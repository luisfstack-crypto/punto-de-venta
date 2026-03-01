<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\compraController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\ExportPDFController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\InventarioControlller;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\presentacioneController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\proveedorController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ventaController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page redirect logic
Route::get('/', [homeController::class, 'index'])->name('panel');

// Login routes (Public)
Route::get('/login', [loginController::class, 'index'])->name('login.index');
Route::post('/login', [loginController::class, 'login'])->name('login.login');

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register.register');

// Ruta temporal para ejecutar migraciones y seeders en Railway
Route::get('/setup-railway-db', function () {
    try {
        error_log('Ejecutando migraciones...');
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        
        error_log('Ejecutando DatabaseSeeder...');
        // Llamamos al DatabaseSeeder completo para asegurar Documentos, Comprobantes, Permisos y Usuario
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        
        $output = \Illuminate\Support\Facades\Artisan::output();
        
        return "¡Configuración completada en Railway! <br><br> Detalle: <pre>" . $output . "</pre><br>Ya puedes intentar iniciar sesión.";
    } catch (\Exception $e) {
        return "Error crítico al configurar: " . $e->getMessage() . "<br>Línea: " . $e->getLine();
    }
});

// Waiting for approval route
Route::get('/waiting-approval', function () {
    return view('auth.waiting');
})->name('waiting.approval');

// Protected Admin Routes
Route::group(['middleware' => ['auth', 'check-user-status'], 'prefix' => 'admin'], function () {
    
    // Resource Routes
    Route::resource('categorias', categoriaController::class)->except('show');
    Route::resource('presentaciones', presentacioneController::class)->except('show');
    Route::resource('marcas', marcaController::class)->except('show');
    Route::resource('productos', ProductoController::class)->except('show', 'destroy');
    Route::resource('clientes', clienteController::class)->except('show');
    Route::resource('proveedores', proveedorController::class)->except('show');
    Route::resource('compras', compraController::class)->except('edit', 'update', 'destroy');
    Route::resource('ventas', ventaController::class)->except('edit', 'update', 'destroy');
    
    // Rutas exclusivas para el rol de administrador
    Route::group(['middleware' => ['role:administrador']], function () {
        Route::resource('users', userController::class)->except('show');
        Route::get('/users/pending', [AdminUserController::class, 'pendingUsers'])->name('admin.users.pending');
        Route::get('/users/receipt/{user}', [AdminUserController::class, 'showReceipt'])->name('admin.users.receipt');
        Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
        Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('admin.users.reject');
    });

    Route::resource('roles', roleController::class)->except('show');
    Route::resource('profile', profileController::class)->only('index', 'update');
    Route::resource('activityLog', ActivityLogController::class)->only('index');
    Route::resource('inventario', InventarioControlller::class)->only('index', 'create', 'store');
    Route::resource('kardex', KardexController::class)->only('index');
    Route::resource('empresa', EmpresaController::class)->only('index', 'update');
    Route::resource('empleados', EmpleadoController::class)->except('show');
    Route::resource('cajas', CajaController::class)->except('edit', 'update', 'show');
    Route::resource('movimientos', MovimientoController::class)->except('show', 'edit', 'update', 'destroy');
    Route::resource('cotizaciones', CotizacionController::class)->parameters(['cotizaciones' => 'cotizacion']);
    Route::get('cotizaciones/{cotizacion}/email', [CotizacionController::class, 'sendEmail'])->name('cotizaciones.email');

    Route::get('cotizaciones/{cotizacion}/duplicate', [CotizacionController::class, 'duplicate'])->name('cotizaciones.duplicate');
    Route::patch('cotizaciones/{cotizacion}/renew', [CotizacionController::class, 'renew'])->name('cotizaciones.renew'); // New Renew Route
    Route::patch('cotizaciones/{cotizacion}/status', [CotizacionController::class, 'updateStatus'])->name('cotizaciones.update-status');

    // Reports and Exports
    Route::get('/export-pdf-compra/{id}', [ExportPDFController::class, 'exportPdfCompra'])->name('export.pdf-compra'); // Example if exists
    Route::get('/export-pdf-cotizacion/{id}', [ExportPDFController::class, 'exportPdfCotizacion'])->name('export.pdf-cotizacion');

    Route::get('/export-pdf-comprobante-venta/{id}', [ExportPDFController::class, 'exportPdfComprobanteVenta'])
        ->name('export.pdf-comprobante-venta');

    Route::get('/export-excel-vental-all', [ExportExcelController::class, 'exportExcelVentasAll'])
        ->name('export.excel-ventas-all');

    Route::post('/importar-excel-empleados', [ImportExcelController::class, 'importExcelEmpleados'])
        ->name('import.excel-empleados');

    // Notifications
    Route::post('/notifications/mark-as-read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    })->name('notifications.markAsRead');

    // Authentication logout
    Route::get('/logout', [logoutController::class, 'logout'])->name('logout');
});