<?php
/**
 * Inicializa brand_version no cache
 * Executar UMA ÚNICA VEZ
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/html; charset=utf-8');

try {
    $timestamp = time();
    cache()->forever('brand_version', $timestamp);
    
    $date = date('Y-m-d H:i:s', $timestamp);
    
    echo '<!DOCTYPE html>';
    echo '<html><head><meta charset="UTF-8">';
    echo '<style>body{font-family:Arial;background:#667eea;color:#fff;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;flex-direction:column;text-align:center;}</style>';
    echo '</head><body>';
    echo '<h1 style="font-size:48px;">✅</h1>';
    echo '<h2>Brand Version Inicializado!</h2>';
    echo '<div style="background:rgba(255,255,255,0.2);padding:20px;border-radius:10px;margin:20px;">';
    echo '<p><strong>brand_version:</strong> ' . $timestamp . '</p>';
    echo '<p><strong>Data/Hora:</strong> ' . $date . '</p>';
    echo '</div>';
    echo '<p style="margin-top:30px;">✅ Agora execute a validação novamente!</p>';
    echo '<p style="background:#dc3545;padding:15px;border-radius:8px;margin-top:20px;"><strong>🔥 DELETE este arquivo agora!</strong></p>';
    echo '</body></html>';
    
} catch (Exception $e) {
    echo '<!DOCTYPE html>';
    echo '<html><head><meta charset="UTF-8">';
    echo '<style>body{font-family:Arial;background:#dc3545;color:#fff;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:20px;}</style>';
    echo '</head><body>';
    echo '<h1>❌ Erro</h1>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '</body></html>';
}
?>
