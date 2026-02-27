@echo off
title Instalador Automatico - Punto de Venta General

:: FORZAR DIRECTORIO DE TRABAJO (Crucial para que encuentre vendor y database)
cd /d "%~dp0"

echo --------------------------------------------------
echo [INICIO] Configurando entorno portable...
echo --------------------------------------------------

:: Configuración de PHP Portable
set "PHP_BIN=php"
if exist "php\php.exe" (
    echo [INFO] Detectado PHP Portable en la carpeta local.
    set "PHP_BIN=php\php.exe"
) else (
    echo [WARNING] No se detecto carpeta 'php' local. Buscando PHP global...
)

:: Prueba de PHP (Para ver si funciona)
"%PHP_BIN%" -v >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR CRITICO]
    echo No se pudo ejecutar PHP. Verifique que:
    echo 1. La carpeta 'php' existe y tiene 'php.exe'.
    echo 2. Ha instalado 'Visual C++ Redistributable' si es necesario.
    pause
    exit
)
echo [OK] PHP funcional detectado.

:: 1. Variables de Entorno (Limpieza profunda)
echo [1/5] Configurando .env...
if exist .env del .env
copy .env.example .env >nul

:: 2. Base de Datos
echo [2/5] Verificando base de datos...
if not exist "database" mkdir database
if exist "database\database.sqlite" del "database\database.sqlite"
type nul > database\database.sqlite
timeout /t 1 >nul

:: 3. Dependencias
echo [3/5] Verificando carpeta vendor...
if not exist "vendor" (
    echo [ERROR FATAL] Falta la carpeta 'vendor'.
    echo Por favor copie la carpeta 'vendor' completa desde su PC de desarrollo.
    pause
    exit
) else (
    echo [OK] Carpeta vendor detectada.
)

:: 4. Ejecutar Comandos Laravel (Paso Crítico)
echo.
echo [4/5] Generando llaves y base de datos...

:: Forzamos la limpieza de caché antes de empezar
"%PHP_BIN%" artisan config:clear

"%PHP_BIN%" artisan key:generate --force
if %errorlevel% neq 0 ( echo [ERROR] Fallo al generar Key. & pause )

:: TRUCO: Pasamos las variables de entorno DIRECTAS para asegurar SQLite
set DB_CONNECTION=sqlite
set DB_DATABASE=%cd%\database\database.sqlite

"%PHP_BIN%" artisan migrate:fresh --seed --force
if %errorlevel% neq 0 ( 
    echo.
    echo [ERROR CRITICO] Fallaron las migraciones.
    echo Revise si tiene habilitado 'extension=pdo_sqlite' en php/php.ini
    pause
    exit
)

"%PHP_BIN%" artisan storage:link

:: 5. Optimización
echo.
echo [5/5] Optimizando sistema...
"%PHP_BIN%" artisan config:cache
"%PHP_BIN%" artisan route:cache
"%PHP_BIN%" artisan view:cache

echo.
echo --------------------------------------------------
echo [EXITO] EL SISTEMA SE INSTALO CORRECTAMENTE
echo --------------------------------------------------
echo Puede cerrar esta ventana.
goto END

:ERROR
echo.
echo [ERROR] Ocurrio un problema durante la instalacion.
echo Revise los mensajes de arriba.

:END
echo.
pause