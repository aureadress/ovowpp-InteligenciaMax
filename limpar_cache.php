<?php
/**
 * Script de Limpeza de Cache - Laravel
 * Executar UMA ÚNICA VEZ após atualizar configurações
 * 
 * Como usar:
 * 1. Acessar: https://seu-dominio.com/limpar_cache.php
 * 2. Aguardar a confirmação
 * 3. Deletar este arquivo
 */

// Carrega o autoloader do Laravel
require __DIR__.'/vendor/autoload.php';

// Carrega a aplicação Laravel
$app = require_once __DIR__.'/bootstrap/app.php';

// Inicia o kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Define o tipo de conteúdo como HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Limpeza de Cache - Inteligência MAX</title>
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
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 700px;
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
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
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
        .command-output {
            background: #1e1e1e;
            color: #00ff00;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            margin: 10px 0;
            overflow-x: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .next-steps {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
        }
        .next-steps h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .next-steps ol {
            margin-left: 20px;
        }
        .next-steps li {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .delete-warning {
            background: #dc3545;
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .stats-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .stats-box h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        .stat-item {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 15px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 12px;
            opacity: 0.9;
        }
        .progress-bar {
            background: #e0e0e0;
            border-radius: 10px;
            height: 8px;
            overflow: hidden;
            margin: 15px 0;
        }
        .progress-fill {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            height: 100%;
            transition: width 0.5s ease;
            animation: progressAnimation 2s ease-in-out;
        }
        @keyframes progressAnimation {
            0% { width: 0%; }
            100% { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🧹</div>
        <h1>Limpeza de Cache</h1>
        <p class="subtitle">Inteligência MAX - Sistema de Rebranding</p>

        <div class="progress-bar">
            <div class="progress-fill" style="width: 0%;" id="progress"></div>
        </div>

<?php
$startTime = microtime(true);
$results = [];
$totalSteps = 0;
$successSteps = 0;

try {
    // Passo 1: Config Cache
    echo '<div class="step info">';
    echo '<div class="step-icon">⚙️</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Limpando cache de configuração...</div>';
    echo '<div class="step-desc">Removendo arquivos de configuração em cache</div>';
    echo '</div>';
    echo '</div>';
    flush();

    $totalSteps++;
    $output1 = shell_exec('cd ' . __DIR__ . ' && php artisan config:clear 2>&1');
    $results['config'] = $output1;
    
    if (strpos($output1, 'Configuration cache cleared') !== false || strpos($output1, 'cleared') !== false) {
        $successSteps++;
        echo '<div class="step success">';
        echo '<div class="step-icon">✅</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Cache de configuração limpo!</div>';
        echo '<div class="command-output">' . htmlspecialchars($output1) . '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="step error">';
        echo '<div class="step-icon">❌</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Erro ao limpar cache de configuração</div>';
        echo '<div class="command-output">' . htmlspecialchars($output1) . '</div>';
        echo '</div>';
        echo '</div>';
    }
    flush();

    // Passo 2: View Cache
    echo '<div class="step info">';
    echo '<div class="step-icon">👁️</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Limpando cache de views...</div>';
    echo '<div class="step-desc">Removendo templates compilados do Blade</div>';
    echo '</div>';
    echo '</div>';
    flush();

    $totalSteps++;
    $output2 = shell_exec('cd ' . __DIR__ . ' && php artisan view:clear 2>&1');
    $results['view'] = $output2;
    
    if (strpos($output2, 'Compiled views cleared') !== false || strpos($output2, 'cleared') !== false) {
        $successSteps++;
        echo '<div class="step success">';
        echo '<div class="step-icon">✅</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Cache de views limpo!</div>';
        echo '<div class="command-output">' . htmlspecialchars($output2) . '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="step error">';
        echo '<div class="step-icon">❌</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Erro ao limpar cache de views</div>';
        echo '<div class="command-output">' . htmlspecialchars($output2) . '</div>';
        echo '</div>';
        echo '</div>';
    }
    flush();

    // Passo 3: Application Cache
    echo '<div class="step info">';
    echo '<div class="step-icon">💾</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Limpando cache da aplicação...</div>';
    echo '<div class="step-desc">Removendo dados em cache do sistema</div>';
    echo '</div>';
    echo '</div>';
    flush();

    $totalSteps++;
    $output3 = shell_exec('cd ' . __DIR__ . ' && php artisan cache:clear 2>&1');
    $results['cache'] = $output3;
    
    if (strpos($output3, 'Application cache cleared') !== false || strpos($output3, 'cleared') !== false) {
        $successSteps++;
        echo '<div class="step success">';
        echo '<div class="step-icon">✅</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Cache da aplicação limpo!</div>';
        echo '<div class="command-output">' . htmlspecialchars($output3) . '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="step error">';
        echo '<div class="step-icon">❌</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Erro ao limpar cache da aplicação</div>';
        echo '<div class="command-output">' . htmlspecialchars($output3) . '</div>';
        echo '</div>';
        echo '</div>';
    }
    flush();

    // Passo 4: Route Cache (opcional)
    echo '<div class="step info">';
    echo '<div class="step-icon">🛣️</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Limpando cache de rotas...</div>';
    echo '<div class="step-desc">Removendo rotas em cache</div>';
    echo '</div>';
    echo '</div>';
    flush();

    $totalSteps++;
    $output4 = shell_exec('cd ' . __DIR__ . ' && php artisan route:clear 2>&1');
    $results['route'] = $output4;
    
    if (strpos($output4, 'Route cache cleared') !== false || strpos($output4, 'cleared') !== false || strpos($output4, 'does not exist') !== false) {
        $successSteps++;
        echo '<div class="step success">';
        echo '<div class="step-icon">✅</div>';
        echo '<div class="step-content">';
        echo '<div class="step-title">Cache de rotas limpo!</div>';
        echo '<div class="command-output">' . htmlspecialchars($output4) . '</div>';
        echo '</div>';
        echo '</div>';
    }
    flush();

    $endTime = microtime(true);
    $executionTime = round($endTime - $startTime, 2);

    // Estatísticas
    echo '<div class="stats-box">';
    echo '<h3>📊 Estatísticas da Limpeza</h3>';
    echo '<div class="stats-grid">';
    
    echo '<div class="stat-item">';
    echo '<div class="stat-value">' . $successSteps . '/' . $totalSteps . '</div>';
    echo '<div class="stat-label">Tarefas Concluídas</div>';
    echo '</div>';
    
    echo '<div class="stat-item">';
    echo '<div class="stat-value">' . $executionTime . 's</div>';
    echo '<div class="stat-label">Tempo de Execução</div>';
    echo '</div>';
    
    echo '<div class="stat-item">';
    echo '<div class="stat-value">' . round(($successSteps / $totalSteps) * 100) . '%</div>';
    echo '<div class="stat-label">Taxa de Sucesso</div>';
    echo '</div>';
    
    echo '</div>';
    echo '</div>';

    // Próximos passos
    echo '<div class="next-steps">';
    echo '<h3>✅ Cache Limpo com Sucesso!</h3>';
    echo '<p style="margin-bottom: 15px;">O sistema está pronto para usar com as novas configurações.</p>';
    echo '<ol>';
    echo '<li><strong>Recarregue seu site</strong> com <code style="background:rgba(255,255,255,0.2);padding:3px 8px;border-radius:3px;">Ctrl+F5</code> ou <code style="background:rgba(255,255,255,0.2);padding:3px 8px;border-radius:3px;">Cmd+Shift+R</code></li>';
    echo '<li><strong>Verifique</strong> se o nome "Inteligência MAX" está aparecendo corretamente</li>';
    echo '<li><strong>Teste</strong> as principais funcionalidades do sistema</li>';
    echo '<li><strong>DELETE ESTE ARQUIVO</strong> imediatamente por segurança!</li>';
    echo '</ol>';
    echo '</div>';

    echo '<div class="delete-warning">';
    echo '🔥 ATENÇÃO: Delete o arquivo "limpar_cache.php" AGORA!';
    echo '</div>';

} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<div class="step-icon">❌</div>';
    echo '<div class="step-content">';
    echo '<div class="step-title">Erro Crítico</div>';
    echo '<div class="command-output">' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '</div>';
    echo '</div>';
}
?>

        <script>
            // Animar barra de progresso
            setTimeout(function() {
                document.getElementById('progress').style.width = '100%';
            }, 100);
        </script>
    </div>
</body>
</html>
