#!/usr/bin/env php
<?php

/**
 * Script para encontrar todas as chaves de tradução usadas no projeto
 * e compará-las com o arquivo pt_BR.json
 */

echo "🔍 Buscando chaves de tradução no projeto...\n\n";

$projectRoot = dirname(__DIR__);
$translationFile = $projectRoot . '/resources/lang/pt_BR.json';

// Carregar traduções existentes
$existingTranslations = [];
if (file_exists($translationFile)) {
    $content = file_get_contents($translationFile);
    $existingTranslations = json_decode($content, true) ?? [];
    echo "✅ Carregadas " . count($existingTranslations) . " traduções existentes\n\n";
} else {
    echo "❌ Arquivo pt_BR.json não encontrado!\n";
    exit(1);
}

// Padrões para encontrar chaves de tradução
$patterns = [
    // __('key')
    "/__\(['\"]([^'\"]+)['\"]\)/",
    // @lang('key')
    "/@lang\(['\"]([^'\"]+)['\"]\)/",
    // trans('key')
    "/trans\(['\"]([^'\"]+)['\"]\)/",
    // {{ __('key') }}
    "/\{\{\s*__\(['\"]([^'\"]+)['\"]\)\s*\}\}/",
    // {{ trans('key') }}
    "/\{\{\s*trans\(['\"]([^'\"]+)['\"]\)\s*\}\}/",
];

// Diretórios para escanear
$directories = [
    $projectRoot . '/app',
    $projectRoot . '/resources/views',
    $projectRoot . '/routes',
];

$foundKeys = [];
$fileCount = 0;

function scanDirectory($dir, $patterns, &$foundKeys, &$fileCount) {
    if (!is_dir($dir)) {
        return;
    }
    
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($files as $file) {
        if (!$file->isFile()) {
            continue;
        }
        
        $ext = $file->getExtension();
        if (!in_array($ext, ['php', 'blade.php'])) {
            continue;
        }
        
        $fileCount++;
        $content = file_get_contents($file->getPathname());
        
        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $content, $matches)) {
                foreach ($matches[1] as $key) {
                    if (!isset($foundKeys[$key])) {
                        $foundKeys[$key] = [];
                    }
                    $foundKeys[$key][] = str_replace(dirname($dir) . '/', '', $file->getPathname());
                }
            }
        }
    }
}

// Escanear diretórios
foreach ($directories as $dir) {
    echo "📁 Escaneando: $dir\n";
    scanDirectory($dir, $patterns, $foundKeys, $fileCount);
}

echo "\n✅ Escaneados $fileCount arquivos\n";
echo "🔑 Encontradas " . count($foundKeys) . " chaves únicas\n\n";

// Análise: chaves sem tradução
$missingKeys = [];
foreach ($foundKeys as $key => $files) {
    if (!isset($existingTranslations[$key])) {
        $missingKeys[$key] = $files;
    }
}

// Análise: traduções não utilizadas
$unusedTranslations = [];
foreach ($existingTranslations as $key => $value) {
    if (!isset($foundKeys[$key])) {
        $unusedTranslations[$key] = $value;
    }
}

// Relatório
echo "=" . str_repeat("=", 70) . "\n";
echo "📊 RELATÓRIO DE TRADUÇÕES\n";
echo "=" . str_repeat("=", 70) . "\n\n";

echo "📈 Estatísticas:\n";
echo "  - Chaves encontradas no código: " . count($foundKeys) . "\n";
echo "  - Traduções existentes: " . count($existingTranslations) . "\n";
echo "  - Chaves SEM tradução: " . count($missingKeys) . "\n";
echo "  - Traduções NÃO utilizadas: " . count($unusedTranslations) . "\n\n";

// Mostrar chaves sem tradução
if (!empty($missingKeys)) {
    echo "⚠️  CHAVES SEM TRADUÇÃO (" . count($missingKeys) . "):\n";
    echo str_repeat("-", 70) . "\n";
    
    $count = 0;
    foreach ($missingKeys as $key => $files) {
        $count++;
        if ($count > 50) {
            echo "... e mais " . (count($missingKeys) - 50) . " chaves\n";
            break;
        }
        echo "  $count. \"$key\"\n";
        echo "     Usado em: " . implode(", ", array_slice($files, 0, 3)) . "\n";
        if (count($files) > 3) {
            echo "     ... e mais " . (count($files) - 3) . " arquivo(s)\n";
        }
        echo "\n";
    }
}

// Salvar relatório em arquivo
$reportFile = $projectRoot . '/storage/logs/translation-report.txt';
$reportContent = "RELATÓRIO DE TRADUÇÕES - " . date('Y-m-d H:i:s') . "\n\n";
$reportContent .= "Estatísticas:\n";
$reportContent .= "- Chaves encontradas: " . count($foundKeys) . "\n";
$reportContent .= "- Traduções existentes: " . count($existingTranslations) . "\n";
$reportContent .= "- Chaves sem tradução: " . count($missingKeys) . "\n";
$reportContent .= "- Traduções não utilizadas: " . count($unusedTranslations) . "\n\n";

$reportContent .= "CHAVES SEM TRADUÇÃO:\n";
$reportContent .= str_repeat("-", 70) . "\n";
foreach ($missingKeys as $key => $files) {
    $reportContent .= "\"$key\"\n";
    $reportContent .= "  Usado em: " . implode(", ", $files) . "\n\n";
}

$reportContent .= "\n\nTRADUÇÕES NÃO UTILIZADAS:\n";
$reportContent .= str_repeat("-", 70) . "\n";
foreach ($unusedTranslations as $key => $value) {
    $reportContent .= "\"$key\" => \"$value\"\n";
}

file_put_contents($reportFile, $reportContent);
echo "\n📝 Relatório completo salvo em: $reportFile\n";

// Gerar JSON com chaves faltantes
if (!empty($missingKeys)) {
    $missingKeysFile = $projectRoot . '/storage/logs/missing-keys.json';
    $missingKeysJson = [];
    foreach (array_keys($missingKeys) as $key) {
        $missingKeysJson[$key] = $key; // Usar a chave em inglês como valor padrão
    }
    file_put_contents($missingKeysFile, json_encode($missingKeysJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "📝 Chaves faltantes salvas em JSON: $missingKeysFile\n";
}

echo "\n✅ Análise concluída!\n";
