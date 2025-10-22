<?php
/**
 * Script de Limpeza Completa de Cache
 * Executa todos os comandos de limpeza necessários
 * 
 * Como usar:
 * 1. Acesse: https://inteligenciamax.com.br/limpar_cache_completo.php
 * 2. Aguarde conclusão
 * 3. DELETE este arquivo após usar
 */

// Carrega o Laravel
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
    <title>Limpeza Completa de Cache - Inteligência MAX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            max-width: 900px;
            width: 100%;
            animation: slideIn 0.5s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .logo {
            text-align: center;
            font-size: 64px;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 20px;
            color: #667eea;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
            font-weight: bold;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin-bottom: 12px;
            border-radius: 5px;
            display: flex;
            align-items: flex-start;
            transition: all 0.3s ease;
        }
        .step:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.2);
        }
        .step-icon {
            font-size: 24px;
            margin-right: 15px;
            min-width: 30px;
        }
        .step-content {
            flex: 1;
        }
        .step-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            font-size: 16px;
        }
        .step-desc {
            color: #666;
            font-size: 13px;
            margin-bottom: 8px;
        }
        .command-output {
            background: #1e1e1e;
            color: #00ff00;
            padding: 12px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin-top: 8px;
            overflow-x: auto;
            max-height: 150px;
            overflow-y: auto;
        }
        .success {
            background: #d4edda;
            border-left-color: #28a745;
        }
        .error {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        .warning {
            background: #fff3cd;
            border-left-color: #ffc107;
        }
        .info {
            background: #d1ecf1;
            border-left-color: #17a2b8;
        }
        .stats-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .stat-item {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 15px;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 12px;
            opacity: 0.9;
        }
        .delete-warning {
            background: #dc3545;
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .next-steps {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .next-steps h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .next-steps ol {
            margin-left: 25px;
            color: #333;
        }
        .next-steps li {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .progress-bar {
            background: #e0e0e0;
            border-radius: 10px;
            height: 10px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-fill {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            height: 100%;
            transition: width 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🧹✨</div>
        <h1>Limpeza Completa de Cache</h1>
        <p class="subtitle">Inteligência MAX - Sistema de Cache-Busting</p>

        <div class="progress-bar">
            <div class="progress-fill" id="progress" style="width: 0%"></div>
        </div>

<?php
$startTime = microtime(true);
$results = [];
$totalSteps = 0;
$successSteps = 0;

// SEÇÃO 1: CACHE LARAVEL
echo '<div class="section">';
echo '<div class="section-title">📦 CACHE LARAVEL</div>';

// 1. Config Cache
echo '<div class="step info">';
echo '<div class="step-icon">⚙️</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Limpando cache de configuração...</div>';
echo '<div class="step-desc">Remove configurações em cache</div>';
echo '</div>';
echo '</div>';
flush();

$totalSteps++;
try {
    Artisan::call('config:clear');
    $output = Artisan::output();
    $successSteps++;
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Cache de configuração limpo!</div>';
    echo '<div class="command-output">' . htmlspecialchars($output) . '</div>';
    echo '</div>';
    echo '</div>';
} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<div class="step-icon">❌</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Erro ao limpar config cache</div>';
    echo '<div class="command-output">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}
flush();

// 2. View Cache
echo '<div class="step info">';
echo '<div class="step-icon">👁️</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Limpando cache de views...</div>';
echo '<div class="step-desc">Remove templates Blade compilados</div>';
echo '</div>';
echo '</div>';
flush();

$totalSteps++;
try {
    Artisan::call('view:clear');
    $output = Artisan::output();
    $successSteps++;
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Cache de views limpo!</div>';
    echo '<div class="command-output">' . htmlspecialchars($output) . '</div>';
    echo '</div>';
    echo '</div>';
} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<div class="step-icon">❌</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Erro ao limpar view cache</div>';
    echo '<div class="command-output">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}
flush();

// 3. Application Cache
echo '<div class="step info">';
echo '<div class="step-icon">💾</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Limpando cache da aplicação...</div>';
echo '<div class="step-desc">Remove dados em cache do sistema</div>';
echo '</div>';
echo '</div>';
flush();

$totalSteps++;
try {
    Artisan::call('cache:clear');
    $output = Artisan::output();
    $successSteps++;
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Cache da aplicação limpo!</div>';
    echo '<div class="command-output">' . htmlspecialchars($output) . '</div>';
    echo '</div>';
    echo '</div>';
} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<div class="step-icon">❌</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Erro ao limpar application cache</div>';
    echo '<div class="command-output">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}
flush();

// 4. Route Cache
echo '<div class="step info">';
echo '<div class="step-icon">🛣️</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Limpando cache de rotas...</div>';
echo '<div class="step-desc">Remove rotas em cache</div>';
echo '</div>';
echo '</div>';
flush();

$totalSteps++;
try {
    Artisan::call('route:clear');
    $output = Artisan::output();
    $successSteps++;
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Cache de rotas limpo!</div>';
    echo '<div class="command-output">' . htmlspecialchars($output) . '</div>';
    echo '</div>';
    echo '</div>';
} catch (Exception $e) {
    echo '<div class="step warning">';
    echo '<div class="step-icon">⚠️</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Aviso: route cache</div>';
    echo '<div class="command-output">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}
flush();

// 5. Optimize Clear
echo '<div class="step info">';
echo '<div class="step-icon">🚀</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Executando optimize:clear...</div>';
echo '<div class="step-desc">Limpeza otimizada completa</div>';
echo '</div>';
echo '</div>';
flush();

$totalSteps++;
try {
    Artisan::call('optimize:clear');
    $output = Artisan::output();
    $successSteps++;
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Optimize clear executado!</div>';
    echo '<div class="command-output">' . htmlspecialchars($output) . '</div>';
    echo '</div>';
    echo '</div>';
} catch (Exception $e) {
    echo '<div class="step warning">';
    echo '<div class="step-icon">⚠️</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Aviso: optimize clear</div>';
    echo '<div class="command-output">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}
flush();

echo '</div>'; // Fim SEÇÃO 1

// SEÇÃO 2: CACHE BRAND
echo '<div class="section">';
echo '<div class="section-title">🎨 CACHE BRAND (LOGO/CORES)</div>';

// 6. Brand Version Reset
echo '<div class="step info">';
echo '<div class="step-icon">🔄</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Resetando brand_version...</div>';
echo '<div class="step-desc">Força reload de logo, favicon e cores</div>';
echo '</div>';
echo '</div>';
flush();

$totalSteps++;
try {
    $newVersion = time();
    cache()->forever('brand_version', $newVersion);
    $successSteps++;
    
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Brand version atualizado!</div>';
    echo '<div class="command-output">Novo brand_version: ' . $newVersion . '</div>';
    echo '</div>';
    echo '</div>';
} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<div class="step-icon">❌</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Erro ao atualizar brand_version</div>';
    echo '<div class="command-output">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}
flush();

echo '</div>'; // Fim SEÇÃO 2

// SEÇÃO 3: VALIDAÇÃO
echo '<div class="section">';
echo '<div class="section-title">✅ VALIDAÇÃO</div>';

// 7. Verificar color.php
echo '<div class="step info">';
echo '<div class="step-icon">🎨</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Verificando arquivos color.php...</div>';
echo '</div>';
echo '</div>';
flush();

$totalSteps++;
$colorPhpAdmin = public_path('assets/admin/css/color.php');
$colorPhpFrontend = public_path('assets/templates/basic/css/color.php');

if (file_exists($colorPhpAdmin) && file_exists($colorPhpFrontend)) {
    $successSteps++;
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Arquivos color.php encontrados!</div>';
    echo '<div class="command-output">';
    echo '✓ Admin: ' . $colorPhpAdmin . "\n";
    echo '✓ Frontend: ' . $colorPhpFrontend;
    echo '</div>';
    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="step warning">';
    echo '<div class="step-icon">⚠️</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Alguns arquivos color.php não encontrados</div>';
    echo '<div class="command-output">';
    echo (file_exists($colorPhpAdmin) ? '✓' : '✗') . ' Admin: ' . $colorPhpAdmin . "\n";
    echo (file_exists($colorPhpFrontend) ? '✓' : '✗') . ' Frontend: ' . $colorPhpFrontend;
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
flush();

// 8. Verificar Helper Functions
echo '<div class="step info">';
echo '<div class="step-icon">🔧</div>';
echo '<div class="step-content">';
echo '<div class="step-title">Verificando helper functions...</div>';
echo '</div>';
echo '</div>';
flush();

$totalSteps++;
$functions = ['brandVersion', 'assetVersion', 'logoWithVersion', 'colorCssUrl'];
$allExist = true;
$functionStatus = [];

foreach ($functions as $func) {
    $exists = function_exists($func);
    $functionStatus[] = ($exists ? '✓' : '✗') . ' ' . $func . '()';
    if (!$exists) $allExist = false;
}

if ($allExist) {
    $successSteps++;
    echo '<div class="step success">';
    echo '<div class="step-icon">✅</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Todas helper functions encontradas!</div>';
    echo '<div class="command-output">' . implode("\n", $functionStatus) . '</div>';
    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="step warning">';
    echo '<div class="step-icon">⚠️</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Algumas helper functions não encontradas</div>';
    echo '<div class="command-output">' . implode("\n", $functionStatus) . '</div>';
    echo '</div>';
    echo '</div>';
}
flush();

echo '</div>'; // Fim SEÇÃO 3

$endTime = microtime(true);
$executionTime = round($endTime - $startTime, 2);

// ESTATÍSTICAS
echo '<div class="stats-box">';
echo '<h2 style="margin-bottom: 20px;">📊 Estatísticas da Limpeza</h2>';
echo '<div class="stats-grid">';

echo '<div class="stat-item">';
echo '<div class="stat-value">' . $successSteps . '/' . $totalSteps . '</div>';
echo '<div class="stat-label">Tarefas Concluídas</div>';
echo '</div>';

echo '<div class="stat-item">';
echo '<div class="stat-value">' . $executionTime . 's</div>';
echo '<div class="stat-label">Tempo de Execução</div>';
echo '</div>';

$percentage = $totalSteps > 0 ? round(($successSteps / $totalSteps) * 100) : 0;
echo '<div class="stat-item">';
echo '<div class="stat-value">' . $percentage . '%</div>';
echo '<div class="stat-label">Taxa de Sucesso</div>';
echo '</div>';

echo '<div class="stat-item">';
echo '<div class="stat-value">' . brandVersion() . '</div>';
echo '<div class="stat-label">Brand Version</div>';
echo '</div>';

echo '</div>';
echo '</div>';

// PRÓXIMOS PASSOS
echo '<div class="next-steps">';
echo '<h3>✅ Limpeza Concluída com Sucesso!</h3>';
echo '<p style="margin-bottom: 15px;">O sistema foi completamente limpo e está pronto para uso.</p>';
echo '<ol>';
echo '<li><strong>Recarregue todas as abas abertas</strong> do admin/user/home com <code style="background:#e0e0e0;padding:3px 8px;border-radius:3px;">Ctrl+F5</code></li>';
echo '<li><strong>Teste atualizar logo</strong> em /admin/setting/brand</li>';
echo '<li><strong>Teste mudar cor</strong> em /admin/setting/general</li>';
echo '<li><strong>Verifique</strong> se as mudanças aparecem imediatamente</li>';
echo '<li><strong>DELETE ESTE ARQUIVO</strong> agora por segurança!</li>';
echo '</ol>';
echo '</div>';

echo '<div class="delete-warning">';
echo '🔥 ATENÇÃO: Delete o arquivo "limpar_cache_completo.php" AGORA!';
echo '</div>';
?>

        <script>
            // Animar barra de progresso
            document.getElementById('progress').style.width = '100%';
        </script>
    </div>
</body>
</html>
