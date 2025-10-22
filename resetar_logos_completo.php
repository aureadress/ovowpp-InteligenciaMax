<?php
/**
 * RESET COMPLETO DE LOGOS
 * Deleta TODOS os logos antigos e prepara sistema para novos uploads
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
    <title>Reset Completo de Logos - Inteligência MAX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
            padding: 40px;
            max-width: 900px;
            width: 100%;
        }
        h1 {
            color: #dc3545;
            font-size: 36px;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        .logo { text-align: center; font-size: 80px; margin-bottom: 20px; }
        .warning-banner {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .warning-banner h3 {
            color: #856404;
            margin-bottom: 10px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #dc3545;
            padding: 15px 20px;
            margin-bottom: 12px;
            border-radius: 5px;
            display: flex;
            align-items: flex-start;
        }
        .step.deleted { background: #f8d7da; border-left-color: #dc3545; }
        .step.success { background: #d4edda; border-left-color: #28a745; }
        .step.info { background: #d1ecf1; border-left-color: #17a2b8; }
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
        .summary h2 { margin-bottom: 20px; font-size: 28px; }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 25px;
        }
        .summary-item {
            background: rgba(255,255,255,0.2);
            padding: 20px;
            border-radius: 10px;
        }
        .summary-value { font-size: 42px; font-weight: bold; }
        .summary-label { font-size: 14px; margin-top: 5px; opacity: 0.95; }
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
            font-size: 22px;
        }
        .next-steps ol {
            margin-left: 25px;
            line-height: 2;
            font-size: 15px;
        }
        .next-steps strong { color: #007bff; }
        .delete-warning {
            background: #dc3545;
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
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
        <div class="logo">🔥🗑️</div>
        <h1>Reset Completo de Logos</h1>
        <p class="subtitle">Deletando TODOS os logos antigos (OvoWpp, placeholders, etc.)</p>

        <div class="warning-banner">
            <h3>⚠️ ATENÇÃO: Operação Destrutiva!</h3>
            <p>Todos os logos serão PERMANENTEMENTE deletados.</p>
            <p>Você precisará fazer upload de novos logos após este processo.</p>
        </div>

<?php
$deletedFiles = [];
$errors = [];
$totalDeleted = 0;

// Lista de TODOS os arquivos de logo para deletar
$filesToDelete = [
    'public/assets/images/logo_icon/favicon.png',
    'public/assets/images/logo_icon/logo-dark.png',
    'public/assets/images/logo_icon/logo.png',
    'public/assets/images/inteligenciamax/favicon.png',
    'public/assets/images/inteligenciamax/logo-dark.png',
    'public/assets/images/inteligenciamax/logo.png',
];

echo '<h3 style="color: #dc3545; margin: 20px 0;">🗑️ Deletando Arquivos</h3>';

foreach ($filesToDelete as $file) {
    $fullPath = base_path($file);
    
    if (file_exists($fullPath)) {
        $fileSize = filesize($fullPath);
        $fileMd5 = md5_file($fullPath);
        
        echo '<div class="step deleted">';
        echo '<div class="step-icon">🗑️</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">DELETANDO: ' . basename($file) . '</div>';
        echo '<div class="step-desc">';
        echo 'Tamanho: ' . number_format($fileSize / 1024, 2) . ' KB | ';
        echo 'MD5: ' . substr($fileMd5, 0, 16) . '...';
        echo '</div>';
        echo '<div class="code">' . $file . '</div>';
        
        // Tentar deletar
        if (@unlink($fullPath)) {
            $totalDeleted++;
            $deletedFiles[] = $file;
            echo '<div class="step-desc" style="color: #28a745; margin-top: 8px; font-weight: bold;">✅ DELETADO COM SUCESSO!</div>';
        } else {
            $errors[] = $file;
            echo '<div class="step-desc" style="color: #dc3545; margin-top: 8px; font-weight: bold;">❌ ERRO AO DELETAR</div>';
        }
        
        echo '</div></div>';
    } else {
        echo '<div class="step">';
        echo '<div class="step-icon">❓</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">' . basename($file) . '</div>';
        echo '<div class="step-desc">Arquivo não existe (já foi deletado ou nunca existiu)</div>';
        echo '<div class="code">' . $file . '</div>';
        echo '</div></div>';
    }
}

// Garantir que diretórios existem
echo '<h3 style="color: #007bff; margin: 30px 0 20px;">📁 Verificando Estrutura de Diretórios</h3>';

$requiredDirs = [
    'public/assets/images/logo_icon',
    'public/assets/images/inteligenciamax',
];

foreach ($requiredDirs as $dir) {
    $fullPath = base_path($dir);
    
    if (!is_dir($fullPath)) {
        echo '<div class="step info">';
        echo '<div class="step-icon">📂</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Criando: ' . $dir . '</div>';
        
        if (mkdir($fullPath, 0775, true)) {
            echo '<div class="step-desc" style="color: #28a745;">✅ Criado com sucesso!</div>';
        } else {
            echo '<div class="step-desc" style="color: #dc3545;">❌ Erro ao criar</div>';
        }
        
        echo '</div></div>';
    } else {
        echo '<div class="step success">';
        echo '<div class="step-icon">✅</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">' . $dir . '</div>';
        echo '<div class="step-desc">Diretório existe e está pronto</div>';
        echo '</div></div>';
    }
}

// Atualizar brand_version
echo '<h3 style="color: #007bff; margin: 30px 0 20px;">🔄 Atualizando Cache</h3>';

try {
    $newVersion = time();
    cache()->forever('brand_version', $newVersion);
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">brand_version atualizado!</div>';
    echo '<div class="code">Novo timestamp: ' . $newVersion . ' (' . date('Y-m-d H:i:s') . ')</div>';
    echo '</div></div>';
    
    // Limpar caches
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Caches do Laravel limpos!</div>';
    echo '</div></div>';
    
} catch (Exception $e) {
    echo '<div class="step deleted">';
    echo '<div class="step-icon">❌</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Erro ao atualizar cache</div>';
    echo '<div class="code">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div></div>';
}

$errorCount = count($errors);
$successRate = count($filesToDelete) > 0 ? round(($totalDeleted / count($filesToDelete)) * 100) : 100;
?>

        <div class="summary">
            <h2>🎉 Reset Completo!</h2>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value"><?php echo $totalDeleted; ?></div>
                    <div class="summary-label">Arquivos Deletados</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value"><?php echo $errorCount; ?></div>
                    <div class="summary-label">Erros</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value"><?php echo $successRate; ?>%</div>
                    <div class="summary-label">Taxa de Sucesso</div>
                </div>
            </div>
        </div>

        <div class="next-steps">
            <h3>✅ Próximos Passos - CRÍTICO!</h3>
            <ol>
                <li><strong>FECHE TODAS AS ABAS</strong> do admin/site abertas no navegador</li>
                <li><strong>LIMPE O CACHE DO NAVEGADOR</strong>:
                    <ul style="margin-left: 20px; margin-top: 8px;">
                        <li>Chrome/Edge: <code>Ctrl+Shift+Delete</code></li>
                        <li>Marque "Imagens e arquivos em cache"</li>
                        <li>Clique "Limpar dados"</li>
                    </ul>
                </li>
                <li><strong>ABRA NAVEGAÇÃO ANÔNIMA</strong>: <code>Ctrl+Shift+N</code></li>
                <li><strong>ACESSE</strong>: <code>https://inteligenciamax.com.br/admin/setting/brand</code></li>
                <li><strong>FAÇA UPLOAD</strong> dos novos logos da Inteligência MAX:
                    <ul style="margin-left: 20px; margin-top: 8px;">
                        <li><strong>Logo</strong>: PNG transparente, ~200x50px</li>
                        <li><strong>Favicon</strong>: PNG 32x32px ou 64x64px</li>
                        <li>(Logo Dark é opcional)</li>
                    </ul>
                </li>
                <li><strong>CLIQUE EM "UPDATE"</strong></li>
                <li><strong>AGUARDE</strong> mensagem "Brand setting updated successfully"</li>
                <li><strong>RECARREGUE</strong> a página com <code>Ctrl+F5</code></li>
                <li><strong>VERIFIQUE</strong> se os novos logos aparecem</li>
                <li><strong>DELETE ESTE ARQUIVO</strong> imediatamente!</li>
            </ol>
        </div>

        <div class="delete-warning">
            🔥 ATENÇÃO: Delete "resetar_logos_completo.php" AGORA!
        </div>
    </div>
</body>
</html>
