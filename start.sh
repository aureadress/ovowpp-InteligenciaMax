#!/bin/bash
set -e

echo "========================================="
echo "🚀 Starting InteligenciaMax Application"
echo "========================================="
echo "Build Version: 2025-10-21-DOCKERFILE"
echo "Timestamp: $(date)"
echo "========================================="

echo "📁 Checking directories..."
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo "🔑 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "🧹 Clearing ALL caches (NO CACHING!)..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "========================================="
echo "✅ All caches cleared successfully!"
echo "🌐 Starting Laravel server on port ${PORT:-8080}"
echo "========================================="

# Start Laravel server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
