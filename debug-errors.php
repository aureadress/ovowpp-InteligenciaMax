#!/usr/bin/env php
<?php

/**
 * Script para debugar erros 500 no Laravel
 */

echo "🔍 Verificando configuração do Laravel...\n\n";

// Carregar autoload
require __DIR__ . '/vendor/autoload.php';

// Carregar aplicação
$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot aplicação
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "✅ Aplicação inicializada\n\n";

// Verificar .env
echo "📋 Verificando variáveis de ambiente:\n";
echo str_repeat("-", 50) . "\n";

$envVars = [
    'APP_NAME',
    'APP_ENV',
    'APP_KEY',
    'APP_DEBUG',
    'APP_URL',
    'APP_LOCALE',
    'APP_FALLBACK_LOCALE',
    'DB_CONNECTION',
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'DB_USERNAME',
];

foreach ($envVars as $var) {
    $value = env($var);
    if (empty($value)) {
        echo "❌ $var: NÃO CONFIGURADO\n";
    } else {
        if ($var === 'APP_KEY') {
            echo "✅ $var: " . (strlen($value) > 10 ? substr($value, 0, 20) . "..." : "CONFIGURADO") . "\n";
        } elseif ($var === 'DB_PASSWORD' || $var === 'DB_USERNAME') {
            echo "✅ $var: ****\n";
        } else {
            echo "✅ $var: $value\n";
        }
    }
}

echo "\n";

// Verificar conexão com banco de dados
echo "🗄️  Verificando conexão com banco de dados:\n";
echo str_repeat("-", 50) . "\n";

try {
    $pdo = DB::connection()->getPdo();
    echo "✅ Conexão com banco estabelecida\n";
    
    // Testar query
    $result = DB::select('SELECT 1 as test');
    echo "✅ Query de teste executada com sucesso\n";
    
    // Verificar tabelas
    $tables = DB::select('SHOW TABLES');
    echo "✅ Total de tabelas: " . count($tables) . "\n";
    
} catch (\Exception $e) {
    echo "❌ ERRO de conexão: " . $e->getMessage() . "\n";
    echo "   Código: " . $e->getCode() . "\n";
}

echo "\n";

// Verificar storage
echo "📁 Verificando diretórios de storage:\n";
echo str_repeat("-", 50) . "\n";

$storageDirs = [
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    if (is_dir($fullPath)) {
        if (is_writable($fullPath)) {
            echo "✅ $dir - OK (escrita permitida)\n";
        } else {
            echo "⚠️  $dir - SEM PERMISSÃO DE ESCRITA\n";
        }
    } else {
        echo "❌ $dir - NÃO EXISTE\n";
    }
}

echo "\n";

// Verificar últimos logs
echo "📜 Últimos erros no log:\n";
echo str_repeat("-", 50) . "\n";

$logFile = __DIR__ . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -50);
    
    $errorLines = [];
    foreach ($lastLines as $line) {
        if (stripos($line, 'error') !== false || 
            stripos($line, 'exception') !== false ||
            stripos($line, 'fatal') !== false) {
            $errorLines[] = $line;
        }
    }
    
    if (empty($errorLines)) {
        echo "✅ Nenhum erro recente encontrado\n";
    } else {
        echo "⚠️  Encontrados " . count($errorLines) . " erros:\n\n";
        foreach (array_slice($errorLines, -10) as $line) {
            echo $line;
        }
    }
} else {
    echo "⚠️  Arquivo de log não encontrado\n";
}

echo "\n";

// Testar rota raiz
echo "🌐 Testando rota raiz:\n";
echo str_repeat("-", 50) . "\n";

try {
    $request = Illuminate\Http\Request::create('/', 'GET');
    $response = $app->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);
    
    echo "✅ Status: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() === 500) {
        echo "❌ Erro 500 detectado\n";
        echo "Conteúdo da resposta:\n";
        echo substr($response->getContent(), 0, 500) . "...\n";
    }
    
} catch (\Exception $e) {
    echo "❌ EXCEÇÃO ao testar rota: " . $e->getMessage() . "\n";
    echo "   Arquivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "   Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n✅ Diagnóstico concluído!\n";
