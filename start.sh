#!/bin/bash
set -e

echo "========================================="
echo "🚀 Starting InteligenciaMax Application"
echo "========================================="
echo "Build Version: 2025-10-21-DOCKERFILE-FIX"
echo "Timestamp: $(date)"
echo "========================================="

echo "📁 Checking directories..."
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo "🔑 Setting permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 775 public/assets 2>/dev/null || true

echo "🖼️ Checking brand logos..."
# Ensure logo directory exists
mkdir -p public/assets/images/logo_icon

# Verify critical logo files exist (should be in Git now)
if [ ! -f "public/assets/images/logo_icon/logo.png" ]; then
    echo "⚠️ WARNING: Logo files missing! This should not happen."
    echo "   Logos should be versioned in Git."
fi

# Tentar corrigir proprietário se possível
if [ -n "$(command -v chown)" ]; then
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || \
    chown -R $(whoami):$(whoami) storage bootstrap/cache 2>/dev/null || true
fi

echo "🧹 Clearing ALL caches (NO CACHING!)..."
php artisan optimize:clear 2>&1 | grep -v "Failed" || true

echo "========================================="
echo "✅ Caches cleared!"
echo "🌐 Starting PHP server on port ${PORT:-8080}"
echo "📍 Document root: /app (index.php na raiz)"
echo "========================================="

# Start PHP built-in server pointing to root directory
# This project has index.php in root, not in public/
# Remove index.php from command to allow static files to be served
cd /app
exec php -S 0.0.0.0:${PORT:-8080} -t /app
