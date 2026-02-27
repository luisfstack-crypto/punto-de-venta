<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registramos TODOS los alias aquí para que Laravel 11/12 los reconozca
        $middleware->alias([
            // Permisos de Spatie
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            
            // Middlewares personalizados del sistema de ventas
            'check_producto_inicializado' => \App\Http\Middleware\CheckProductoInicializado::class,
            'check_movimiento_caja_user' => \App\Http\Middleware\CheckMovimientoCajaUserMiddleware::class,
            'check-caja-aperturada-user' => \App\Http\Middleware\CheckCajaAperturadaUser::class,
            'check-show-venta-user' => \App\Http\Middleware\CheckShowVentaUser::class,
            'check-show-compra-user' => \App\Http\Middleware\CheckShowCompraUser::class,
            'check-user-estado' => \App\Http\Middleware\CheckUserEstado::class, // Fix para el Error 500
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();