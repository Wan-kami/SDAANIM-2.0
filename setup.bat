@echo off
echo ============================================
echo   SDAANIM - Esperando Animal BQ
echo ============================================
echo.

cd /d "%~dp0"

echo [1/5] Instalando dependencias con Composer...
call composer install
if %ERRORLEVEL% NEQ 0 (
    echo Error en composer install
    pause
    exit /b 1
)

echo.
echo [2/5] Generando clave de aplicacion...
call php artisan key:generate
if %ERRORLEVEL% NEQ 0 (
    echo Error en key:generate
    pause
    exit /b 1
)

echo.
echo [3/5] Ejecutando migraciones...
call php artisan migrate --force
if %ERRORLEVEL% NEQ 0 (
    echo Error en migraciones
    pause
    exit /b 1
)

echo.
echo [4/5] Creando enlace simbolico de storage...
call php artisan storage:link
if %ERRORLEVEL% NEQ 0 (
    echo Advertencia: No se pudo crear enlace simbolico
)

echo.
echo [5/5] Limpiando cache...
call php artisan config:clear
call php artisan cache:clear

echo.
echo ============================================
echo   Configuracion completada!
echo ============================================
echo.
echo Para iniciar el servidor, ejecuta:
echo   php artisan serve
echo.
pause
