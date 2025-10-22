<?php
/**
 * Script de Validação Completa do Sistema
 * Verifica cache-busting, configurações, permissões e integridade
 * 
 * Como usar:
 * 1. Acesse: https://inteligenciamax.com.br/validar_sistema_completo.php
 * 2. Analise os resultados
 * 3. Corrija problemas se houver
 * 4. DELETE este arquivo após validação
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
    <title>Validação Completa - Inteligência MAX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #667eea;
            font-size: 36px;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 40px;
            font-size: 16px;
        }
        .logo {
            text-align: center;
            font-size: 72px;
            margin-bottom: 20px;
        }
        .category {
            margin-bottom: 40px;
        }
        .category-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .category-icon {
            font-size: 28px;
        }
        .test-item {
            background: #f8f9fa;
            border-left: 4px solid #ccc;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            align-items: flex-start;
        }
        .test-item.success {
            background: #d4edda;
            border-left-color: #28a745;
        }
        .test-item.error {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        .test-item.warning {
            background: #fff3cd;
            border-left-color: #ffc107;
        }
        .test-icon {
            font-size: 24px;
            margin-right: 15px;
            min-width: 30px;
        }
        .test-content {
            flex: 1;
        }
        .test-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 15px;
        }
        .test-desc {
            color: #666;
            font-size: 13px;
        }
        .test-details {
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 8px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-height: 200px;
            overflow-y: auto;
        }
        .score-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .score-value {
            font-size: 72px;
            font-weight: bold;
            margin: 20px 0;
        }
        .score-label {
            font-size: 20px;
            opacity: 0.9;
        }
        .score-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .score-item {
            background: rgba(255,255,255,0.2);
            padding: 20px;
            border-radius: 10px;
        }
        .score-item-value {
            font-size: 36px;
            font-weight: bold;
        }
        .score-item-label {
            font-size: 14px;
            margin-top: 5px;
            opacity: 0.9;
        }
        .action-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-top: 30px;
        }
        .action-box h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .action-box ul {
            margin-left: 25px;
        }
        .action-box li {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .delete-warning {
            background: #dc3545;
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-top: 30px;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-error { background: #dc3545; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🔍✅</div>
        <h1>Validação Completa do Sistema</h1>
        <p class="subtitle">Inteligência MAX - Diagnóstico de Cache-Busting e Configurações</p>

<?php
$startTime = microtime(true);
$categories = [];
$totalTests = 0;
$passedTests = 0;
$failedTests = 0;
$warningTests = 0;

function addTest($category, $status, $title, $description, $details = null) {
    global $categories, $totalTests, $passedTests, $failedTests, $warningTests;
    
    if (!isset($categories[$category])) {
        $categories[$category] = [];
    }
    
    $categories[$category][] = [
        'status' => $status,
        'title' => $title,
        'description' => $description,
        'details' => $details
    ];
    
    $totalTests++;
    if ($status === 'success') $passedTests++;
    if ($status === 'error') $failedTests++;
    if ($status === 'warning') $warningTests++;
}

// CATEGORIA 1: Arquivos CSS Dinâmicos
$colorPhpAdmin = public_path('assets/admin/css/color.php');
$colorPhpFrontend = public_path('assets/templates/basic/css/color.php');

if (file_exists($colorPhpAdmin)) {
    if (is_readable($colorPhpAdmin)) {
        $size = filesize($colorPhpAdmin);
        addTest('CSS Dinâmico', 'success', 'color.php Admin OK', 
            'Arquivo encontrado e legível', 
            "Path: {$colorPhpAdmin}\nSize: " . number_format($size / 1024, 2) . " KB");
    } else {
        addTest('CSS Dinâmico', 'error', 'color.php Admin não legível', 
            'Verificar permissões', $colorPhpAdmin);
    }
} else {
    addTest('CSS Dinâmico', 'error', 'color.php Admin não encontrado', 
        'Arquivo não existe', $colorPhpAdmin);
}

if (file_exists($colorPhpFrontend)) {
    if (is_readable($colorPhpFrontend)) {
        $size = filesize($colorPhpFrontend);
        addTest('CSS Dinâmico', 'success', 'color.php Frontend OK', 
            'Arquivo encontrado e legível', 
            "Path: {$colorPhpFrontend}\nSize: " . number_format($size / 1024, 2) . " KB");
    } else {
        addTest('CSS Dinâmico', 'error', 'color.php Frontend não legível', 
            'Verificar permissões', $colorPhpFrontend);
    }
} else {
    addTest('CSS Dinâmico', 'error', 'color.php Frontend não encontrado', 
        'Arquivo não existe', $colorPhpFrontend);
}

// CATEGORIA 2: Helper Functions
$functions = [
    'brandVersion' => 'Retorna versão de cache de brand',
    'assetVersion' => 'Adiciona versão aos assets',
    'logoWithVersion' => 'URL do logo com cache-busting',
    'colorCssUrl' => 'URL do CSS dinâmico'
];

foreach ($functions as $func => $desc) {
    if (function_exists($func)) {
        try {
            if ($func === 'brandVersion') {
                $result = brandVersion();
                addTest('Helper Functions', 'success', "{$func}() OK", $desc, "Retorna: {$result}");
            } elseif ($func === 'assetVersion') {
                $result = assetVersion('test.css', true);
                addTest('Helper Functions', 'success', "{$func}() OK", $desc, "Exemplo: {$result}");
            } elseif ($func === 'logoWithVersion') {
                $result = logoWithVersion('logo.png');
                addTest('Helper Functions', 'success', "{$func}() OK", $desc, "Retorna: {$result}");
            } elseif ($func === 'colorCssUrl') {
                $resultAdmin = colorCssUrl('admin');
                $resultFront = colorCssUrl('basic');
                addTest('Helper Functions', 'success', "{$func}() OK", $desc, 
                    "Admin: {$resultAdmin}\nFrontend: {$resultFront}");
            }
        } catch (Exception $e) {
            addTest('Helper Functions', 'warning', "{$func}() com erro", 
                'Function existe mas falhou ao executar', $e->getMessage());
        }
    } else {
        addTest('Helper Functions', 'error', "{$func}() não encontrada", 
            'Helper function não existe', "Adicione ao helpers.php");
    }
}

// CATEGORIA 3: Cache
try {
    $brandVersion = cache()->get('brand_version');
    if ($brandVersion) {
        $date = date('Y-m-d H:i:s', $brandVersion);
        addTest('Cache', 'success', 'brand_version OK', 
            'Cache de versão configurado', 
            "Version: {$brandVersion}\nData: {$date}");
    } else {
        addTest('Cache', 'warning', 'brand_version não definido', 
            'Será criado no próximo update', 'Execute: cache()->forever(\'brand_version\', time())');
    }
} catch (Exception $e) {
    addTest('Cache', 'error', 'Erro ao acessar cache', 
        'Problema com sistema de cache', $e->getMessage());
}

// CATEGORIA 4: Banco de Dados
try {
    $general = DB::table('general_settings')->first();
    
    if ($general) {
        addTest('Banco de Dados', 'success', 'general_settings OK', 'Tabela encontrada', null);
        
        if (isset($general->base_color)) {
            addTest('Banco de Dados', 'success', 'base_color OK', 
                'Cor primária configurada', "#{$general->base_color}");
        } else {
            addTest('Banco de Dados', 'warning', 'base_color não definido', 
                'Defina em /admin/setting/general', null);
        }
        
        if (isset($general->site_name)) {
            addTest('Banco de Dados', 'success', 'site_name OK', 
                'Nome do site configurado', $general->site_name);
        }
    } else {
        addTest('Banco de Dados', 'error', 'general_settings não encontrado', 
            'Tabela não existe', 'Verificar migração do banco');
    }
} catch (Exception $e) {
    addTest('Banco de Dados', 'error', 'Erro ao conectar banco', 
        'Problema de conexão', $e->getMessage());
}

// CATEGORIA 5: Diretório e Logos
$logoPath = public_path('assets/images/logoIcon');

if (is_dir($logoPath)) {
    addTest('Arquivos', 'success', 'Diretório de logos OK', 
        'Diretório existe', $logoPath);
    
    if (is_writable($logoPath)) {
        addTest('Arquivos', 'success', 'Diretório gravável', 
            'Permissões corretas', 'Pode fazer upload de logos');
    } else {
        addTest('Arquivos', 'error', 'Diretório não gravável', 
            'Permissões incorretas', "Execute: chmod -R 775 {$logoPath}");
    }
    
    $logos = [
        'logo.png' => 'Logo principal',
        'logo_dark.png' => 'Logo dark mode',
        'favicon.png' => 'Favicon'
    ];
    
    foreach ($logos as $file => $desc) {
        $fullPath = $logoPath . '/' . $file;
        if (file_exists($fullPath)) {
            $size = filesize($fullPath);
            addTest('Arquivos', 'success', "{$file} OK", $desc, 
                "Size: " . number_format($size / 1024, 2) . " KB");
        } else {
            addTest('Arquivos', 'warning', "{$file} não encontrado", 
                "Faça upload em /admin/setting/brand", $fullPath);
        }
    }
} else {
    addTest('Arquivos', 'error', 'Diretório de logos não existe', 
        'Criar diretório', "mkdir -p {$logoPath}");
}

// CATEGORIA 6: Permissões
$paths = [
    'storage' => storage_path(),
    'bootstrap/cache' => base_path('bootstrap/cache'),
    'public' => public_path(),
];

foreach ($paths as $name => $path) {
    if (is_dir($path)) {
        if (is_writable($path)) {
            addTest('Permissões', 'success', "{$name} OK", 
                'Diretório gravável', $path);
        } else {
            addTest('Permissões', 'error', "{$name} não gravável", 
                'Permissões incorretas', "chmod -R 775 {$path}");
        }
    } else {
        addTest('Permissões', 'error', "{$name} não existe", 
            'Diretório não encontrado', $path);
    }
}

// CATEGORIA 7: URLs e Acesso
$baseUrl = config('app.url');
addTest('Configuração', 'success', 'APP_URL configurada', 
    'URL base do sistema', $baseUrl);

$colorUrlAdmin = $baseUrl . '/assets/admin/css/color.php';
$colorUrlFrontend = $baseUrl . '/assets/templates/basic/css/color.php';

addTest('Configuração', 'success', 'URLs de color.php', 
    'Teste manual necessário', 
    "Admin: {$colorUrlAdmin}\nFrontend: {$colorUrlFrontend}");

// CATEGORIA 8: Laravel
$laravelVersion = app()->version();
addTest('Sistema', 'success', 'Laravel Version', 
    'Framework funcionando', $laravelVersion);

$phpVersion = phpversion();
addTest('Sistema', 'success', 'PHP Version', 
    'Interpretador funcionando', $phpVersion);

$endTime = microtime(true);
$executionTime = round($endTime - $startTime, 2);

// CALCULAR SCORE
$percentage = $totalTests > 0 ? round(($passedTests / $totalTests) * 100) : 0;

// RENDERIZAR RESULTADOS
echo '<div class="score-box">';
echo '<div class="score-label">Score Geral</div>';
echo '<div class="score-value">' . $percentage . '%</div>';
echo '<div class="score-grid">';

echo '<div class="score-item">';
echo '<div class="score-item-value" style="color: #28a745;">' . $passedTests . '</div>';
echo '<div class="score-item-label">✅ Sucessos</div>';
echo '</div>';

echo '<div class="score-item">';
echo '<div class="score-item-value" style="color: #ffc107;">' . $warningTests . '</div>';
echo '<div class="score-item-label">⚠️ Avisos</div>';
echo '</div>';

echo '<div class="score-item">';
echo '<div class="score-item-value" style="color: #dc3545;">' . $failedTests . '</div>';
echo '<div class="score-item-label">❌ Erros</div>';
echo '</div>';

echo '<div class="score-item">';
echo '<div class="score-item-value">' . $executionTime . 's</div>';
echo '<div class="score-item-label">⏱️ Tempo</div>';
echo '</div>';

echo '</div>';
echo '</div>';

// RENDERIZAR CATEGORIAS
foreach ($categories as $categoryName => $tests) {
    $categoryPassed = 0;
    $categoryTotal = count($tests);
    
    foreach ($tests as $test) {
        if ($test['status'] === 'success') $categoryPassed++;
    }
    
    $categoryPercentage = $categoryTotal > 0 ? round(($categoryPassed / $categoryTotal) * 100) : 0;
    
    echo '<div class="category">';
    echo '<div class="category-header">';
    echo '<span>' . $categoryName . '</span>';
    echo '<span class="badge ';
    if ($categoryPercentage >= 80) echo 'badge-success';
    elseif ($categoryPercentage >= 50) echo 'badge-warning';
    else echo 'badge-error';
    echo '">' . $categoryPassed . '/' . $categoryTotal . ' (' . $categoryPercentage . '%)</span>';
    echo '</div>';
    
    foreach ($tests as $test) {
        $statusIcon = [
            'success' => '✅',
            'error' => '❌',
            'warning' => '⚠️'
        ];
        
        echo '<div class="test-item ' . $test['status'] . '">';
        echo '<div class="test-icon">' . $statusIcon[$test['status']] . '</div>';
        echo '<div class="test-content">';
        echo '<div class="test-title">' . htmlspecialchars($test['title']) . '</div>';
        echo '<div class="test-desc">' . htmlspecialchars($test['description']) . '</div>';
        
        if ($test['details']) {
            echo '<div class="test-details">' . nl2br(htmlspecialchars($test['details'])) . '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
}

// AÇÕES RECOMENDADAS
echo '<div class="action-box">';
echo '<h3>📝 Próximas Ações</h3>';

if ($failedTests > 0) {
    echo '<h4 style="color: #dc3545; margin-top: 15px;">❌ Corrija os Erros Primeiro:</h4>';
    echo '<ul>';
    foreach ($categories as $tests) {
        foreach ($tests as $test) {
            if ($test['status'] === 'error') {
                echo '<li><strong>' . htmlspecialchars($test['title']) . '</strong>: ' . htmlspecialchars($test['description']) . '</li>';
            }
        }
    }
    echo '</ul>';
}

if ($warningTests > 0) {
    echo '<h4 style="color: #ffc107; margin-top: 15px;">⚠️ Atenção aos Avisos:</h4>';
    echo '<ul>';
    foreach ($categories as $tests) {
        foreach ($tests as $test) {
            if ($test['status'] === 'warning') {
                echo '<li><strong>' . htmlspecialchars($test['title']) . '</strong>: ' . htmlspecialchars($test['description']) . '</li>';
            }
        }
    }
    echo '</ul>';
}

if ($percentage >= 80) {
    echo '<h4 style="color: #28a745; margin-top: 15px;">🎉 Sistema Validado! Teste Agora:</h4>';
    echo '<ul>';
    echo '<li>Acesse <strong>/admin/setting/general</strong> e mude a cor</li>';
    echo '<li>Acesse <strong>/admin/setting/brand</strong> e faça upload de novo logo</li>';
    echo '<li>Recarregue as páginas e verifique se mudanças aparecem</li>';
    echo '<li>Acesse os arquivos color.php diretamente no navegador</li>';
    echo '<li><strong>DELETE ESTE ARQUIVO</strong> após validação</li>';
    echo '</ul>';
}

echo '</div>';

echo '<div class="delete-warning">';
echo '🔥 DELETE este arquivo após validação: validar_sistema_completo.php';
echo '</div>';
?>

    </div>
</body>
</html>
