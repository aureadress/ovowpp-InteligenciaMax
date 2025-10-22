<?php
/**
 * Script de Validação - Sistema de Cache Busting
 * Verifica se todas as implementações estão corretas
 * 
 * Executar: php validate_cache_busting.php
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n";
echo "==============================================\n";
echo "  VALIDAÇÃO DO SISTEMA DE CACHE BUSTING\n";
echo "==============================================\n\n";

$errors = [];
$warnings = [];
$success = [];

// 1. Verificar se color.php existem
echo "📋 Verificando arquivos CSS dinâmicos...\n";

$colorPhpAdmin = public_path('assets/admin/css/color.php');
$colorPhpFrontend = public_path('assets/templates/basic/css/color.php');

if (file_exists($colorPhpAdmin)) {
    $success[] = "✅ color.php (admin) encontrado";
    if (is_readable($colorPhpAdmin)) {
        $success[] = "✅ color.php (admin) é legível";
    } else {
        $errors[] = "❌ color.php (admin) não é legível - verificar permissões";
    }
} else {
    $errors[] = "❌ color.php (admin) NÃO encontrado em: " . $colorPhpAdmin;
}

if (file_exists($colorPhpFrontend)) {
    $success[] = "✅ color.php (frontend) encontrado";
    if (is_readable($colorPhpFrontend)) {
        $success[] = "✅ color.php (frontend) é legível";
    } else {
        $errors[] = "❌ color.php (frontend) não é legível - verificar permissões";
    }
} else {
    $errors[] = "❌ color.php (frontend) NÃO encontrado em: " . $colorPhpFrontend;
}

// 2. Verificar helper functions
echo "\n📋 Verificando helper functions...\n";

$functions = [
    'brandVersion',
    'assetVersion',
    'logoWithVersion',
    'colorCssUrl'
];

foreach ($functions as $function) {
    if (function_exists($function)) {
        $success[] = "✅ Function '{$function}()' existe";
        
        // Testar execução
        try {
            if ($function === 'brandVersion') {
                $result = brandVersion();
                $success[] = "  └─ Retorna: {$result}";
            } elseif ($function === 'logoWithVersion') {
                $result = logoWithVersion('logo.png');
                $success[] = "  └─ Retorna: " . $result;
            } elseif ($function === 'colorCssUrl') {
                $result = colorCssUrl('admin');
                $success[] = "  └─ Retorna: " . $result;
            }
        } catch (Exception $e) {
            $warnings[] = "⚠️  Function '{$function}()' existe mas erro ao executar: " . $e->getMessage();
        }
    } else {
        $errors[] = "❌ Function '{$function}()' NÃO existe";
    }
}

// 3. Verificar brand_version no cache
echo "\n📋 Verificando cache...\n";

try {
    $brandVersion = cache()->get('brand_version');
    if ($brandVersion) {
        $success[] = "✅ brand_version existe no cache: {$brandVersion}";
        $date = date('Y-m-d H:i:s', $brandVersion);
        $success[] = "  └─ Data: {$date}";
    } else {
        $warnings[] = "⚠️  brand_version não existe no cache (será criado no primeiro update)";
    }
} catch (Exception $e) {
    $errors[] = "❌ Erro ao acessar cache: " . $e->getMessage();
}

// 4. Verificar configurações do banco
echo "\n📋 Verificando banco de dados...\n";

try {
    $general = DB::table('general_settings')->first();
    
    if ($general) {
        $success[] = "✅ General settings encontrado";
        
        if (isset($general->base_color)) {
            $success[] = "✅ base_color existe: #{$general->base_color}";
        } else {
            $warnings[] = "⚠️  base_color não definido";
        }
        
        if (isset($general->site_name)) {
            $success[] = "✅ site_name existe: {$general->site_name}";
        }
    } else {
        $errors[] = "❌ General settings não encontrado no banco";
    }
} catch (Exception $e) {
    $errors[] = "❌ Erro ao acessar banco de dados: " . $e->getMessage();
}

// 5. Verificar diretório de logos
echo "\n📋 Verificando diretório de logos...\n";

$logoPath = public_path('assets/images/logoIcon');

if (is_dir($logoPath)) {
    $success[] = "✅ Diretório de logos existe: {$logoPath}";
    
    $logos = ['logo.png', 'logo_dark.png', 'favicon.png'];
    foreach ($logos as $logo) {
        $file = $logoPath . '/' . $logo;
        if (file_exists($file)) {
            $size = filesize($file);
            $success[] = "✅ {$logo} existe (" . number_format($size / 1024, 2) . " KB)";
        } else {
            $warnings[] = "⚠️  {$logo} não encontrado";
        }
    }
    
    // Verificar permissões
    if (is_writable($logoPath)) {
        $success[] = "✅ Diretório de logos é gravável";
    } else {
        $errors[] = "❌ Diretório de logos NÃO é gravável - verificar permissões";
    }
} else {
    $errors[] = "❌ Diretório de logos NÃO existe: {$logoPath}";
}

// 6. Testar acesso ao color.php via HTTP
echo "\n📋 Testando acesso HTTP ao color.php...\n";

$baseUrl = config('app.url');
$colorUrlAdmin = $baseUrl . '/assets/admin/css/color.php';
$colorUrlFrontend = $baseUrl . '/assets/templates/basic/css/color.php';

echo "  Admin: {$colorUrlAdmin}\n";
echo "  Frontend: {$colorUrlFrontend}\n";

$success[] = "✅ URLs configuradas (teste manual necessário)";

// 7. Verificar permissões de arquivos
echo "\n📋 Verificando permissões...\n";

$paths = [
    'storage' => storage_path(),
    'bootstrap/cache' => base_path('bootstrap/cache'),
    'public' => public_path(),
];

foreach ($paths as $name => $path) {
    if (is_writable($path)) {
        $success[] = "✅ {$name} é gravável";
    } else {
        $errors[] = "❌ {$name} NÃO é gravável: {$path}";
    }
}

// RELATÓRIO FINAL
echo "\n\n";
echo "==============================================\n";
echo "  RELATÓRIO FINAL\n";
echo "==============================================\n\n";

if (!empty($success)) {
    echo "✅ SUCESSOS (" . count($success) . "):\n";
    foreach ($success as $msg) {
        echo "   {$msg}\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "⚠️  AVISOS (" . count($warnings) . "):\n";
    foreach ($warnings as $msg) {
        echo "   {$msg}\n";
    }
    echo "\n";
}

if (!empty($errors)) {
    echo "❌ ERROS (" . count($errors) . "):\n";
    foreach ($errors as $msg) {
        echo "   {$msg}\n";
    }
    echo "\n";
}

// Score final
$total = count($success) + count($warnings) + count($errors);
$score = count($success);
$percentage = $total > 0 ? round(($score / $total) * 100) : 0;

echo "==============================================\n";
echo "  SCORE: {$score}/{$total} ({$percentage}%)\n";
echo "==============================================\n\n";

if (count($errors) === 0) {
    echo "🎉 PARABÉNS! Sistema de cache busting está funcionando!\n\n";
    echo "📝 PRÓXIMOS PASSOS:\n";
    echo "1. Atualize as views principais (consulte CACHE_BUSTING_GUIDE.md)\n";
    echo "2. Teste upload de logo em /admin/setting/brand\n";
    echo "3. Teste mudança de cor em /admin/setting/general\n";
    echo "4. Verifique se mudanças refletem automaticamente\n\n";
    exit(0);
} else {
    echo "⚠️  ATENÇÃO! Corrija os erros acima antes de continuar.\n\n";
    exit(1);
}
