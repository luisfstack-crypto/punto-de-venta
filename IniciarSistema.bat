@echo off
title Iniciando Punto de Venta...

:: 1. Iniciar el servidor en segundo plano
start /B php artisan serve --port=8000

:: 2. Esperar 3 segundos a que cargue
timeout /t 3 /nobreak >nul

:: 3. Abrir el sistema en el navegador predeterminado
start http://localhost:8000

echo Sistema iniciado. No cierre esta ventana mientras use el programa.