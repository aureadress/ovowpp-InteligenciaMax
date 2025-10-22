#!/usr/bin/env php
<?php

/**
 * Script para corrigir locale inválido no banco de dados
 */

echo "🔍 Corrigindo locale inválido no banco de dados...\n\n";

// Carregar autoload
require __DIR__ . '/vendor/autoload.php';

// Carregar aplicação
$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot aplicação
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "✅ Aplicação inicializada\n\n";

// Procurar por locales inválidos na tabela de idiomas
echo "📋 Verificando tabela de idiomas (languages):\n";
echo str_repeat("-", 50) . "\n";

try {
    $languages = DB::table('languages')->get();
    
    echo "Total de idiomas: " . $languages->count() . "\n\n";
    
    foreach ($languages as $lang) {
        echo "ID: {$lang->id} | Code: {$lang->code} | Name: {$lang->name} | Default: {$lang->is_default}\n";
        
        // Verificar se o código contém caracteres inválidos
        if (preg_match('/[^a-zA-Z_-]/', $lang->code)) {
            echo "   ⚠️  CÓDIGO INVÁLIDO DETECTADO!\n";
            
            // Corrigir código se for "português" ou similar
            if (stripos($lang->code, 'portugu') !== false || $lang->code === 'português') {
                $newCode = 'pt_BR';
                echo "   🔧 Corrigindo de '{$lang->code}' para '{$newCode}'\n";
                
                DB::table('languages')
                    ->where('id', $lang->id)
                    ->update(['code' => $newCode]);
                
                echo "   ✅ Corrigido!\n";
            }
        }
        
        echo "\n";
    }
    
    // Verificar idioma padrão
    echo "\n📌 Verificando idioma padrão:\n";
    echo str_repeat("-", 50) . "\n";
    
    $defaultLang = DB::table('languages')->where('is_default', 1)->first();
    
    if ($defaultLang) {
        echo "Idioma padrão: {$defaultLang->name} (código: {$defaultLang->code})\n";
        
        if ($defaultLang->code !== 'pt_BR' && $defaultLang->code !== 'en') {
            echo "⚠️  Código inválido detectado!\n";
            
            if (stripos($defaultLang->name, 'Portugu') !== false) {
                echo "🔧 Atualizando para pt_BR...\n";
                DB::table('languages')
                    ->where('id', $defaultLang->id)
                    ->update(['code' => 'pt_BR']);
                echo "✅ Atualizado!\n";
            }
        } else {
            echo "✅ Código válido!\n";
        }
    } else {
        echo "⚠️  Nenhum idioma padrão definido!\n";
        echo "🔧 Definindo pt_BR como padrão...\n";
        
        $ptBR = DB::table('languages')->where('code', 'pt_BR')->first();
        if ($ptBR) {
            DB::table('languages')->update(['is_default' => 0]);
            DB::table('languages')->where('id', $ptBR->id)->update(['is_default' => 1]);
            echo "✅ pt_BR definido como padrão!\n";
        } else {
            echo "❌ Idioma pt_BR não encontrado na tabela!\n";
        }
    }
    
    echo "\n✅ Correções aplicadas!\n";
    
} catch (\Exception $e) {
    echo "❌ ERRO: " . $e->getMessage() . "\n";
    echo "   Arquivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
