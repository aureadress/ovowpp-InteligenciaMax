<?php
/**
 * Script para Deletar Logos Antigos e Limpar Sistema
 * Remove logos da OvoWpp e força sistema a usar novos logos
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
    <title>Limpeza de Logos Antigos - Inteligência MAX</title>
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
        .logo { text-align: center; font-size: 72px; margin-bottom: 20px; }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin-bottom: 12px;
            border-radius: 5px;
            display: flex;
            align-items: flex-start;
        }
        .step.success { background: #d4edda; border-left-color: #28a745; }
        .step.error { background: #f8d7da; border-left-color: #dc3545; }
        .step.warning { background: #fff3cd; border-left-color: #ffc107; }
        .step-icon { font-size: 24px; margin-right: 15px; min-width: 30px; }
        .step-content { flex: 1; }
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
        }
        .summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .summary h2 { margin-bottom: 15px; }
        .summary-value {
            font-size: 48px;
            font-weight: bold;
            margin: 20px 0;
        }
        .warning-box {
            background: #dc3545;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            margin-top: 30px;
        }
        .next-steps {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 25px;
        }
        .next-steps h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .next-steps ol {
            margin-left: 25px;
            line-height: 2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🗑️✨</div>
        <h1>Limpeza de Logos Antigos</h1>

<?php
$deletedCount = 0;
$notFoundCount = 0;

// Diretórios para verificar logos
$logoPaths = [
    'logoIcon' => public_path('assets/images/logoIcon'),
    'inteligenciamax' => public_path('assets/images/inteligenciamax'),
    'ovowpp' => public_path('assets/images/ovowpp'),
];

echo '<h3 style="color: #667eea; margin-bottom: 20px;">🔍 Procurando e Deletando Logos Antigos</h3>';

foreach ($logoPaths as $name => $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '/*.{png,jpg,jpeg,ico,svg}', GLOB_BRACE);
        
        if (count($files) > 0) {
            echo '<div class="step warning">';
            echo '<div class="step-icon">📁</div>';
            echo '<div class="step-content">';
            echo '<div class="step-title">Diretório: ' . $name . ' (' . count($files) . ' arquivos)</div>';
            echo '<div class="code">' . $dir . '</div>';
            echo '</div>';
            echo '</div>';
            
            foreach ($files as $file) {
                $fileName = basename($file);
                $fileSize = filesize($file);
                
                echo '<div class="step">';
                echo '<div class="step-icon">🖼️</div>';
                echo '<div class="step-content">';
                echo '<div class="step-title">' . $fileName . '</div>';
                echo '<div class="step-desc">Tamanho: ' . number_format($fileSize / 1024, 2) . ' KB</div>';
                
                // Deletar arquivo
                if (@unlink($file)) {
                    $deletedCount++;
                    echo '</div></div>';
                    
                    echo '<div class="step success">';
                    echo '<div class="step-icon">✅</div>';
                    echo '<div class="step-content">';
                    echo '<div class="step-title">DELETADO: ' . $fileName . '</div>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div class="step-desc" style="color: #dc3545; margin-top: 5px;">❌ Erro ao deletar</div>';
                    echo '</div></div>';
                }
            }
        } else {
            echo '<div class="step">';
            echo '<div class="step-icon">📂</div>';
            echo '<div class="step-content">';
            echo '<div class="step-title">' . $name . ': Nenhum arquivo encontrado</div>';
            echo '<div class="code">' . $dir . '</div>';
            echo '</div>';
            echo '</div>';
            $notFoundCount++;
        }
    } else {
        echo '<div class="step">';
        echo '<div class="step-icon">❓</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">' . $name . ': Diretório não existe</div>';
        echo '<div class="code">' . $dir . '</div>';
        echo '</div>';
        echo '</div>';
    }
}

// Limpar cache de imagens do navegador
echo '<h3 style="color: #667eea; margin: 30px 0 20px;">🔄 Forçando Atualização de Cache</h3>';

echo '<div class="step info">';
echo '<div class="step-icon">⚡</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Atualizando brand_version...</div>';
echo '</div>';
echo '</div>';

try {
    $newVersion = time();
    cache()->forever('brand_version', $newVersion);
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Brand version atualizado!</div>';
    echo '<div class="code">Novo timestamp: ' . $newVersion . ' (' . date('Y-m-d H:i:s') . ')</div>';
    echo '</div>';
    echo '</div>';
} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<div class="step-icon">❌</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Erro ao atualizar brand_version</div>';
    echo '<div class="code">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}

// Limpar caches Laravel
echo '<div class="step info">';
echo '<div class="step-icon">🧹</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Limpando caches Laravel...</div>';
echo '</div>';
echo '</div>';

try {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Caches limpos!</div>';
    echo '</div>';
    echo '</div>';
} catch (Exception $e) {
    echo '<div class="step warning">';
    echo '<div class="step-icon">⚠️</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Aviso ao limpar cache</div>';
    echo '<div class="code">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}
?>

        <div class="summary">
            <h2>📊 Resumo da Limpeza</h2>
            <div class="summary-value"><?php echo $deletedCount; ?></div>
            <div>Arquivos Deletados</div>
        </div>

        <div class="next-steps">
            <h3>✅ Próximos Passos - IMPORTANTE!</h3>
            <ol>
                <li><strong>Feche TODAS as abas</strong> do admin/site abertas</li>
                <li><strong>Limpe o cache do navegador</strong>:
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        <li>Chrome/Edge: <code>Ctrl+Shift+Delete</code> → Imagens e arquivos em cache</li>
                        <li>Ou navegação anônima: <code>Ctrl+Shift+N</code></li>
                    </ul>
                </li>
                <li><strong>Acesse</strong>: <code>/admin/setting/brand</code></li>
                <li><strong>Faça upload</strong> dos novos logos da Inteligência MAX:
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        <li>Logo principal (recomendado: 200x50px PNG)</li>
                        <li>Logo dark mode (opcional)</li>
                        <li>Favicon (32x32px ou 64x64px PNG)</li>
                    </ul>
                </li>
                <li><strong>Clique em "Update"</strong></li>
                <li><strong>Recarregue a página</strong> com <code>Ctrl+F5</code></li>
                <li><strong>Verifique</strong> se os novos logos aparecem</li>
                <li><strong>DELETE ESTE ARQUIVO</strong> por segurança</li>
            </ol>
        </div>

        <div class="warning-box">
            🔥 DELETE o arquivo "limpar_logos_antigos.php" AGORA!
        </div>
    </div>
</body>
</html>
