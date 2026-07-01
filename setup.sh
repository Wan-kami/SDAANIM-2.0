#!/bin/bash

clear

echo "===================================================="
echo "             INSTALADOR DE SDAANIM"
echo "===================================================="
echo ""

#====================================
# Verificar proyecto Laravel
#====================================

if [ ! -f artisan ]; then
    echo "❌ Error: Ejecuta este script desde la raíz del proyecto."
    exit 1
fi

if [ ! -f .env.example ]; then
    echo "❌ Error: No existe el archivo .env.example."
    exit 1
fi

#====================================
# Verificar PHP
#====================================

if ! command -v php >/dev/null 2>&1; then
    echo "❌ PHP no está instalado."
    exit 1
fi

#====================================
# Verificar Composer
#====================================

if ! command -v composer >/dev/null 2>&1; then
    echo "❌ Composer no está instalado."
    exit 1
fi

#====================================
# Verificar Node.js
#====================================

if ! command -v node >/dev/null 2>&1; then
    echo "❌ Node.js no está instalado."
    exit 1
fi

#====================================
# Verificar npm
#====================================

if ! command -v npm >/dev/null 2>&1; then
    echo "❌ npm no está instalado."
    exit 1
fi

echo "✔ Todos los requisitos fueron encontrados."
echo ""

echo "PHP: $(php -v | head -n1)"
echo "Composer: $(composer --version)"
echo "Node: $(node -v)"
echo "npm: $(npm -v)"

echo ""
echo "===================================================="

#====================================
# Instalar Composer
#====================================

echo ""
echo "📦 Instalando dependencias de Composer..."
composer install

if [ $? -ne 0 ]; then
    echo ""
    echo "❌ Error durante composer install."
    exit 1
fi

#====================================
# Instalar npm
#====================================

echo ""
echo "📦 Instalando dependencias de Node..."
npm install

if [ $? -ne 0 ]; then
    echo ""
    echo "❌ Error durante npm install."
    exit 1
fi

#====================================
# Crear .env
#====================================

echo ""

if [ ! -f .env ]; then
    cp .env.example .env
    echo "✔ Archivo .env creado."
else
    echo "✔ El archivo .env ya existe."
fi

#====================================
# Generar APP_KEY
#====================================

echo ""
echo "🔑 Generando APP_KEY..."
php artisan key:generate

#====================================
# Crear Storage Link
#====================================

echo ""
echo "📁 Creando enlace de Storage..."
php artisan storage:link >/dev/null 2>&1 || true

#====================================
# Limpiar Caché
#====================================

echo ""
echo "🧹 Limpiando cachés..."
php artisan optimize:clear

#====================================
# Migraciones
#====================================

echo ""

read -p "¿Deseas ejecutar las migraciones? (s/n): " RESP

if [[ "$RESP" =~ ^[Ss]$ ]]; then

    php artisan migrate

    echo ""

    read -p "¿Deseas ejecutar los seeders? (s/n): " RESP2

    if [[ "$RESP2" =~ ^[Ss]$ ]]; then
        php artisan db:seed
    fi

fi

#====================================
# Final
#====================================

echo ""
echo "===================================================="
echo "         SDAANIM INSTALADO CORRECTAMENTE"
echo "===================================================="

echo ""
echo "✅ El proyecto ya está listo."

echo ""
echo "Para ejecutarlo abre DOS terminales."

echo ""
echo "Terminal 1:"
echo "------------------------------------"
echo "npm run dev"

echo ""
echo "Terminal 2:"
echo "------------------------------------"
echo "php artisan serve"

echo ""
echo "Luego abre tu navegador en:"
echo "http://127.0.0.1:8000"

echo ""
echo "🐶 ¡Gracias por usar SDAANIM!"
echo ""