<?php
/**
 * Script de Correção de Estrutura de Diretórios
 * Cria diretórios necessários e corrige permissões
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correção de Estrutura - Inteligência MAX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }
        h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 30px;
            text-align: center;
        }
        .logo { text-align: center; font-size: 64px; margin-bottom: 20px; }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .step.success { background: #d4edda; border-left-color: #28a745; }
        .step.error { background: #f8d7da; border-left-color: #dc3545; }
        .step-icon { font-size: 24px; margin-right: 10px; }
        .step-title { font-weight: bold; margin-bottom: 5px; }
        .step-desc { color: #666; font-size: 13px; }
        .code {
            background: #1e1e1e;
            color: #00ff00;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            margin-top: 8px;
            overflow-x: auto;
        }
        .summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .summary h2 { margin-bottom: 20px; }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .stat-item {
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 10px;
        }
        .stat-value { font-size: 32px; font-weight: bold; }
        .stat-label { font-size: 13px; opacity: 0.9; margin-top: 5px; }
        .warning {
            background: #dc3545;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🔧</div>
        <h1>Correção de Estrutura</h1>

<?php
$results = [];
$successCount = 0;
$errorCount = 0;

// Diretórios necessários
$directories = [
    'public/assets/images/logoIcon' => 'Diretório de logos',
    'public/assets/admin/css' => 'CSS Admin',
    'public/assets/templates/basic/css' => 'CSS Frontend',
    'storage/app/public' => 'Storage público',
    'storage/framework/cache' => 'Cache framework',
    'storage/framework/sessions' => 'Sessões',
    'storage/framework/views' => 'Views compiladas',
    'storage/logs' => 'Logs',
    'bootstrap/cache' => 'Bootstrap cache',
];

echo '<h3 style="color: #667eea; margin-bottom: 20px;">📁 Criando Diretórios</h3>';

foreach ($directories as $dir => $description) {
    $fullPath = base_path($dir);
    
    echo '<div class="step">';
    echo '<span class="step-icon">📂</span>';
    echo '<div style="display: inline-block; width: calc(100% - 40px);">';
    echo '<div class="step-title">' . $description . '</div>';
    
    if (is_dir($fullPath)) {
        echo '<div class="step-desc">✓ Já existe</div>';
        echo '<div class="code">' . $fullPath . '</div>';
        echo '</div></div>';
    } else {
        if (mkdir($fullPath, 0775, true)) {
            $successCount++;
            echo '</div></div>';
            
            echo '<div class="step success">';
            echo '<span class="step-icon">✅</span>';
            echo '<div style="display: inline-block; width: calc(100% - 40px);">';
            echo '<div class="step-title">' . $description . ' - CRIADO!</div>';
            echo '<div class="code">' . $fullPath . '</div>';
            echo '</div></div>';
        } else {
            $errorCount++;
            echo '</div></div>';
            
            echo '<div class="step error">';
            echo '<span class="step-icon">❌</span>';
            echo '<div style="display: inline-block; width: calc(100% - 40px);">';
            echo '<div class="step-title">' . $description . ' - ERRO!</div>';
            echo '<div class="step-desc">Não foi possível criar</div>';
            echo '<div class="code">' . $fullPath . '</div>';
            echo '</div></div>';
        }
    }
}

// Verificar e ajustar permissões
echo '<h3 style="color: #667eea; margin: 30px 0 20px;">🔐 Verificando Permissões</h3>';

$permissionPaths = [
    'storage' => storage_path(),
    'bootstrap/cache' => base_path('bootstrap/cache'),
    'public/assets' => public_path('assets'),
];

foreach ($permissionPaths as $name => $path) {
    echo '<div class="step">';
    echo '<span class="step-icon">🔒</span>';
    echo '<div style="display: inline-block; width: calc(100% - 40px);">';
    echo '<div class="step-title">' . $name . '</div>';
    
    if (is_writable($path)) {
        echo '<div class="step-desc">✓ Gravável</div>';
        echo '</div></div>';
    } else {
        echo '<div class="step-desc">⚠️ Não gravável - pode precisar ajuste manual</div>';
        echo '<div class="code">chmod -R 775 ' . $path . '</div>';
        echo '</div></div>';
    }
}

// Copiar logos padrão se não existirem
echo '<h3 style="color: #667eea; margin: 30px 0 20px;">🖼️ Verificando Logos</h3>';

$logoPath = public_path('assets/images/logoIcon');
$defaultLogos = [
    'logo.png' => 'Logo principal',
    'logo_dark.png' => 'Logo dark mode',
    'favicon.png' => 'Favicon',
];

// Verificar se o diretório inteligenciamax existe (logos alternativos)
$altLogoPath = public_path('assets/images/inteligenciamax');

foreach ($defaultLogos as $file => $desc) {
    $targetFile = $logoPath . '/' . $file;
    $altFile = $altLogoPath . '/' . str_replace('.png', '', $file) . '.png';
    
    echo '<div class="step">';
    echo '<span class="step-icon">🖼️</span>';
    echo '<div style="display: inline-block; width: calc(100% - 40px);">';
    echo '<div class="step-title">' . $desc . '</div>';
    
    if (file_exists($targetFile)) {
        $size = filesize($targetFile);
        echo '<div class="step-desc">✓ Existe (' . number_format($size/1024, 2) . ' KB)</div>';
    } elseif (file_exists($altFile)) {
        // Copiar do diretório alternativo
        if (copy($altFile, $targetFile)) {
            echo '<div class="step-desc" style="color: #28a745;">✓ Copiado de inteligenciamax/</div>';
            $successCount++;
        } else {
            echo '<div class="step-desc" style="color: #ffc107;">⚠️ Não encontrado - faça upload em /admin/setting/brand</div>';
        }
    } else {
        echo '<div class="step-desc" style="color: #ffc107;">⚠️ Não encontrado - faça upload em /admin/setting/brand</div>';
    }
    
    echo '</div></div>';
}

// Criar brand_version
echo '<h3 style="color: #667eea; margin: 30px 0 20px;">🎨 Inicializando Cache</h3>';

try {
    $timestamp = time();
    cache()->forever('brand_version', $timestamp);
    
    echo '<div class="step success">';
    echo '<span class="step-icon">✅</span>';
    echo '<div style="display: inline-block; width: calc(100% - 40px);">';
    echo '<div class="step-title">brand_version criado!</div>';
    echo '<div class="code">Version: ' . $timestamp . ' (' . date('Y-m-d H:i:s', $timestamp) . ')</div>';
    echo '</div></div>';
    $successCount++;
} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<span class="step-icon">❌</span>';
    echo '<div style="display: inline-block; width: calc(100% - 40px);">';
    echo '<div class="step-title">Erro ao criar brand_version</div>';
    echo '<div class="code">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div></div>';
    $errorCount++;
}

// Storage link
echo '<h3 style="color: #667eea; margin: 30px 0 20px;">🔗 Storage Link</h3>';

try {
    if (!file_exists(public_path('storage'))) {
        Artisan::call('storage:link');
        echo '<div class="step success">';
        echo '<span class="step-icon">✅</span>';
        echo '<div style="display: inline-block; width: calc(100% - 40px);">';
        echo '<div class="step-title">Storage link criado!</div>';
        echo '</div></div>';
        $successCount++;
    } else {
        echo '<div class="step">';
        echo '<span class="step-icon">✓</span>';
        echo '<div style="display: inline-block; width: calc(100% - 40px);">';
        echo '<div class="step-title">Storage link já existe</div>';
        echo '</div></div>';
    }
} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<span class="step-icon">⚠️</span>';
    echo '<div style="display: inline-block; width: calc(100% - 40px);">';
    echo '<div class="step-title">Storage link: ' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div></div>';
}

$totalActions = $successCount + $errorCount;
$successRate = $totalActions > 0 ? round(($successCount / $totalActions) * 100) : 100;
?>

        <div class="summary">
            <h2>📊 Resumo da Correção</h2>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-value"><?php echo $successCount; ?></div>
                    <div class="stat-label">✅ Correções</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?php echo $errorCount; ?></div>
                    <div class="stat-label">❌ Erros</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?php echo $successRate; ?>%</div>
                    <div class="stat-label">Taxa Sucesso</div>
                </div>
            </div>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 20px;">
            <h3 style="color: #667eea; margin-bottom: 15px;">✅ Próximos Passos</h3>
            <ol style="margin-left: 25px; line-height: 2;">
                <li>Execute a <strong>validação completa</strong> novamente</li>
                <li>Se logos não existirem, <strong>faça upload</strong> em /admin/setting/brand</li>
                <li><strong>Teste mudar cor</strong> em /admin/setting/general</li>
                <li><strong>DELETE este arquivo</strong> após usar</li>
            </ol>
        </div>

        <div class="warning">
            🔥 DELETE o arquivo "corrigir_estrutura.php" AGORA!
        </div>
    </div>
</body>
</html>
