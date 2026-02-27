@echo off
:: Buscamos el PHP portable
set "PHP_BIN=php"
if exist "%~dp0php\php.exe" set "PHP_BIN=%~dp0php\php.exe"

:: Iniciamos el servidor de Laravel
"%PHP_BIN%" artisan serve