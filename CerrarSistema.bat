@echo off
title Cerrando Sistema Punto de Venta...
echo --------------------------------------------------
echo [INFO] Deteniendo servicios del sistema...
echo --------------------------------------------------

:: Forzamos el cierre de todos los procesos PHP
:: /F = Force, /IM = Image Name
taskkill /F /IM php.exe /T 2>nul

echo.
echo [EXITO] El sistema se ha cerrado correctamente.
echo Ahora es seguro cerrar esta ventana o retirar el USB.
echo --------------------------------------------------
timeout /t 3
