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
mkdir -p public/assets/admin/css public/assets/templates/basic/css

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

echo "🎨 Generating theme CSS files..."
# Generate static CSS files from database colors
php artisan tinker --execute="
$theme = \App\Models\ThemeSetting::active();
if ($theme) {
    $controller = new \App\Http\Controllers\Admin\ThemeSettingController();
    $reflector = new \ReflectionClass($controller);
    $method = $reflector->getMethod('generateStaticCSS');
    $method->setAccessible(true);
    $ok = $method->invoke($controller, $theme);
    echo ($ok ? '✅ Theme CSS files generated successfully!\n' : '❌ Failed to generate theme CSS files.\n');
} else {
    echo '⚠️ No theme settings found, using default CSS files from Git.\n';
}
" 2>&1 | grep -E "✅|⚠️|❌" || echo "⚠️ CSS generation skipped (using Git defaults)"

echo "========================================="
echo "✅ Caches cleared!"
echo "🌐 Starting PHP server on port ${PORT:-8080}"
echo "📍 Document root: /app/public (Laravel public/)"
echo "========================================="

cd /app
exec php -S 0.0.0.0:${PORT:-8080} -t public index.php
