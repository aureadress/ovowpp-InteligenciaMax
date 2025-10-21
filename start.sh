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

echo "🧹 Clearing ALL caches (NO CACHING!)..."
php artisan config:clear 2>/dev/null || echo "⚠️  Config clear skipped"
php artisan cache:clear 2>/dev/null || echo "⚠️  Cache clear skipped"
php artisan view:clear 2>/dev/null || echo "⚠️  View clear skipped"

echo "========================================="
echo "✅ All caches cleared successfully!"
echo "🌐 Starting PHP server on port ${PORT:-8080}"
echo "📍 Document root: /app (index.php na raiz)"
echo "========================================="

# Start PHP built-in server pointing to root directory
# This project has index.php in root, not in public/
cd /app
exec php -S 0.0.0.0:${PORT:-8080} -t /app index.php
