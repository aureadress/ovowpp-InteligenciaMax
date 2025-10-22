<?php
/**
 * CORREÇÃO DEFINITIVA - Logo Hardcoded OvoWpp
 * Remove PERMANENTEMENTE logos fixos e força uso de configuração dinâmica
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
    <title>Correção Definitiva - Logos OvoWpp</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
            padding: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }
        h1 {
            color: #dc3545;
            font-size: 40px;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .logo { text-align: center; font-size: 100px; margin-bottom: 20px; }
        .section {
            margin-bottom: 40px;
        }
        .section-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin-bottom: 12px;
            border-radius: 5px;
            display: flex;
            align-items: flex-start;
        }
        .step.deleted { background: #f8d7da; border-left-color: #dc3545; }
        .step.success { background: #d4edda; border-left-color: #28a745; }
        .step.warning { background: #fff3cd; border-left-color: #ffc107; }
        .step-icon { font-size: 24px; margin-right: 15px; min-width: 30px; }
        .step-content { flex: 1; }
        .step-title { font-weight: bold; margin-bottom: 5px; font-size: 15px; }
        .step-desc { color: #666; font-size: 13px; }
        .code {
            background: #1e1e1e;
            color: #00ff00;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 11px;
            margin-top: 8px;
            word-break: break-all;
        }
        .summary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
        }
        .summary h2 { margin-bottom: 20px; font-size: 30px; }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 25px;
        }
        .summary-item {
            background: rgba(255,255,255,0.25);
            padding: 25px;
            border-radius: 10px;
        }
        .summary-value { font-size: 48px; font-weight: bold; }
        .summary-label { font-size: 14px; margin-top: 8px; opacity: 0.95; }
        .next-steps {
            background: #e7f3ff;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 25px;
            margin-top: 30px;
        }
        .next-steps h3 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .next-steps ol {
            margin-left: 25px;
            line-height: 2.2;
            font-size: 15px;
        }
        .next-steps code {
            background: #f8f9fa;
            padding: 3px 8px;
            border-radius: 3px;
            font-family: monospace;
            color: #dc3545;
        }
        .delete-warning {
            background: #dc3545;
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 22px;
            margin-top: 30px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🔥🗑️✨</div>
        <h1>Correção Definitiva</h1>
        <p class="subtitle">Removendo logos fixos da OvoWpp e forçando uso de configuração dinâmica</p>

<?php
$totalDeleted = 0;
$totalErrors = 0;

// SEÇÃO 1: DELETAR ARQUIVOS FÍSICOS
echo '<div class="section">';
echo '<div class="section-title">🗑️ SEÇÃO 1: Deletando Logos Físicos Hardcoded</div>';

$filesToDelete = [
    'public/assets/images/logo_icon/favicon.png',
    'public/assets/images/logo_icon/logo-dark.png',
    'public/assets/images/logo_icon/logo.png',
    'public/assets/images/inteligenciamax/favicon.png',
    'public/assets/images/inteligenciamax/logo-dark.png',
    'public/assets/images/inteligenciamax/logo.png',
    'public/assets/images/logo.png',
    'public/assets/images/logo.jpg',
    'public/assets/images/favicon.png',
    'public/assets/images/favicon.ico',
    'public/assets/templates/basic/images/logo.png',
    'public/assets/templates/basic/images/logo.jpg',
];

foreach ($filesToDelete as $file) {
    $fullPath = base_path($file);
    
    if (file_exists($fullPath)) {
        $fileSize = filesize($fullPath);
        
        echo '<div class="step deleted">';
        echo '<div class="step-icon">🔥</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">DELETANDO: ' . $file . '</div>';
        echo '<div class="step-desc">Tamanho: ' . number_format($fileSize / 1024, 2) . ' KB</div>';
        
        if (@unlink($fullPath)) {
            $totalDeleted++;
            echo '<div class="step-desc" style="color: #28a745; margin-top: 5px; font-weight: bold;">✅ DELETADO!</div>';
        } else {
            $totalErrors++;
            echo '<div class="step-desc" style="color: #dc3545; margin-top: 5px; font-weight: bold;">❌ ERRO AO DELETAR</div>';
        }
        
        echo '</div></div>';
    } else {
        echo '<div class="step">';
        echo '<div class="step-icon">✓</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">' . basename($file) . '</div>';
        echo '<div class="step-desc">Não existe (OK)</div>';
        echo '</div></div>';
    }
}

echo '</div>'; // Fim SEÇÃO 1

// SEÇÃO 2: REMOVER DO GIT
echo '<div class="section">';
echo '<div class="section-title">📦 SEÇÃO 2: Removendo do Git (para não restaurar no deploy)</div>';

$gitFiles = [
    'public/assets/images/logo_icon/',
    'public/assets/images/inteligenciamax/',
];

foreach ($gitFiles as $path) {
    echo '<div class="step warning">';
    echo '<div class="step-icon">📦</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Removendo do Git: ' . $path . '</div>';
    
    exec("cd " . base_path() . " && git rm -r --cached {$path} 2>&1", $output, $returnCode);
    
    if ($returnCode === 0) {
        echo '<div class="step-desc" style="color: #28a745; margin-top: 5px;">✅ Removido do índice do Git</div>';
        echo '<div class="code">' . implode("\n", $output) . '</div>';
    } else {
        echo '<div class="step-desc" style="color: #ffc107; margin-top: 5px;">⚠️ Não estava no Git ou já foi removido</div>';
    }
    
    echo '</div></div>';
}

// Adicionar ao .gitignore
echo '<div class="step info" style="background: #d1ecf1; border-left-color: #17a2b8;">';
echo '<div class="step-icon">📝</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Atualizando .gitignore</div>';

$gitignorePath = base_path('.gitignore');
$gitignoreContent = file_exists($gitignorePath) ? file_get_contents($gitignorePath) : '';

$ignoreLines = [
    'public/assets/images/logo_icon/*',
    'public/assets/images/inteligenciamax/*',
    '!public/assets/images/logo_icon/.gitkeep',
    '!public/assets/images/inteligenciamax/.gitkeep',
];

$needsUpdate = false;
foreach ($ignoreLines as $line) {
    if (strpos($gitignoreContent, $line) === false) {
        $gitignoreContent .= "\n" . $line;
        $needsUpdate = true;
    }
}

if ($needsUpdate) {
    file_put_contents($gitignorePath, $gitignoreContent);
    echo '<div class="step-desc" style="color: #28a745;">✅ .gitignore atualizado para ignorar logos</div>';
} else {
    echo '<div class="step-desc">✓ .gitignore já configurado</div>';
}

echo '</div></div>';

echo '</div>'; // Fim SEÇÃO 2

// SEÇÃO 3: ATUALIZAR CACHE E CONFIGURAÇÃO
echo '<div class="section">';
echo '<div class="section-title">🔄 SEÇÃO 3: Atualizando Cache e Configurações</div>';

// Atualizar brand_version
try {
    $newVersion = time();
    cache()->forever('brand_version', $newVersion);
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">brand_version atualizado</div>';
    echo '<div class="code">Timestamp: ' . $newVersion . ' (' . date('Y-m-d H:i:s') . ')</div>';
    echo '</div></div>';
} catch (Exception $e) {
    echo '<div class="step deleted">';
    echo '<div class="step-icon">❌</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Erro ao atualizar brand_version</div>';
    echo '<div class="code">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div></div>';
}

// Limpar caches
$cacheCommands = [
    'view:clear' => 'Views compiladas',
    'cache:clear' => 'Application cache',
    'config:clear' => 'Configuration cache',
    'optimize:clear' => 'Optimized files',
];

foreach ($cacheCommands as $command => $description) {
    try {
        Artisan::call($command);
        echo '<div class="step success">';
        echo '<div class="step-icon">✅</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">' . $description . ' limpo</div>';
        echo '<div class="step-desc">Comando: php artisan ' . $command . '</div>';
        echo '</div></div>';
    } catch (Exception $e) {
        echo '<div class="step warning">';
        echo '<div class="step-icon">⚠️</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Aviso ao executar: ' . $command . '</div>';
        echo '</div></div>';
    }
}

// Storage link
try {
    if (!file_exists(public_path('storage'))) {
        Artisan::call('storage:link');
        echo '<div class="step success">';
        echo '<div class="step-icon">✅</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Storage link criado</div>';
        echo '</div></div>';
    }
} catch (Exception $e) {
    // Ignorar erro
}

echo '</div>'; // Fim SEÇÃO 3

// SEÇÃO 4: CRIAR .gitkeep
echo '<div class="section">';
echo '<div class="section-title">📁 SEÇÃO 4: Garantindo Estrutura de Diretórios</div>';

$dirs = [
    'public/assets/images/logo_icon',
    'public/assets/images/inteligenciamax',
];

foreach ($dirs as $dir) {
    $fullPath = base_path($dir);
    
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0775, true);
    }
    
    $gitkeepFile = $fullPath . '/.gitkeep';
    if (!file_exists($gitkeepFile)) {
        file_put_contents($gitkeepFile, '');
        echo '<div class="step success">';
        echo '<div class="step-icon">✅</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">.gitkeep criado em: ' . $dir . '</div>';
        echo '<div class="step-desc">Diretório será mantido vazio no git</div>';
        echo '</div></div>';
    }
}

echo '</div>'; // Fim SEÇÃO 4

$successRate = ($totalDeleted + $totalErrors) > 0 ? round(($totalDeleted / ($totalDeleted + $totalErrors)) * 100) : 100;
?>

        <div class="summary">
            <h2>🎉 Correção Definitiva Completa!</h2>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value"><?php echo $totalDeleted; ?></div>
                    <div class="summary-label">Arquivos Deletados</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value"><?php echo $totalErrors; ?></div>
                    <div class="summary-label">Erros</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value"><?php echo $successRate; ?>%</div>
                    <div class="summary-label">Sucesso</div>
                </div>
            </div>
        </div>

        <div class="next-steps">
            <h3>✅ PRÓXIMOS PASSOS CRÍTICOS:</h3>
            <ol>
                <li><strong>Fazer commit das mudanças:</strong>
                    <br><code>git add -A</code>
                    <br><code>git commit -m "fix: remover logos hardcoded OvoWpp permanentemente"</code>
                    <br><code>git push origin main</code>
                </li>
                <li><strong>Aguardar deploy</strong> no Railway (1-2 minutos)</li>
                <li><strong>Limpar cache do navegador:</strong> <code>Ctrl+Shift+Delete</code></li>
                <li><strong>Abrir navegação anônima:</strong> <code>Ctrl+Shift+N</code></li>
                <li><strong>Acessar:</strong> <code>/admin/setting/brand</code></li>
                <li><strong>Fazer upload</strong> dos novos logos da Inteligência MAX</li>
                <li><strong>Recarregar</strong> com <code>Ctrl+F5</code></li>
                <li><strong>Verificar</strong> se aparecem os novos logos</li>
                <li><strong>DELETE ESTE ARQUIVO</strong> após usar!</li>
            </ol>
        </div>

        <div class="delete-warning">
            🔥 DELETE "correcao_definitiva_logos.php" AGORA!
        </div>
    </div>
</body>
</html>
