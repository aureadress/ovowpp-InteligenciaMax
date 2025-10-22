<?php
/**
 * 🔧 SCRIPT DE CONFIGURAÇÃO AUTOMÁTICA
 * Acesse: https://inteligenciamax.com.br/setup-admin.php
 * 
 * Este script irá:
 * 1. Resetar senha do admin para: admin
 * 2. Ativar Português Brasil
 * 3. Aplicar cores do robô azul
 */

// Carregar Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Usar banco de dados
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Setup Admin - Inteligência MAX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #29B6F6;
            text-align: center;
        }
        .step {
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #29B6F6;
            background: #f9f9f9;
        }
        .success {
            color: #27ae60;
            font-weight: bold;
        }
        .error {
            color: #e74c3c;
            font-weight: bold;
        }
        .info {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .credential {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: #29B6F6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        .btn:hover {
            background: #039BE5;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🤖 Setup Automático - Inteligência MAX</h1>";

try {
    // PASSO 1: Resetar senha do admin
    echo "<div class='step'>";
    echo "<h3>🔐 Passo 1: Resetando senha do admin...</h3>";
    
    $passwordHash = Hash::make('admin');
    
    DB::table('admins')
        ->where('id', 1)
        ->update([
            'password' => $passwordHash,
            'updated_at' => now()
        ]);
    
    $admin = DB::table('admins')->where('id', 1)->first();
    
    echo "<p class='success'>✅ Senha do admin resetada com sucesso!</p>";
    echo "<p><strong>Usuário:</strong> " . $admin->username . "</p>";
    echo "<p><strong>Email:</strong> " . $admin->email . "</p>";
    echo "</div>";
    
    // PASSO 2: Ativar Português Brasil
    echo "<div class='step'>";
    echo "<h3>🌍 Passo 2: Ativando Português Brasil...</h3>";
    
    DB::table('languages')->update(['is_default' => 0]);
    
    $ptExists = DB::table('languages')->where('code', 'pt')->exists();
    
    if (!$ptExists) {
        DB::table('languages')->insert([
            'name' => 'Português Brasil',
            'code' => 'pt',
            'info' => 'Idioma oficial do Brasil',
            'image' => 'pt.png',
            'is_default' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "<p class='success'>✅ Idioma Português Brasil criado e ativado!</p>";
    } else {
        DB::table('languages')
            ->where('code', 'pt')
            ->update([
                'is_default' => 1,
                'updated_at' => now()
            ]);
        echo "<p class='success'>✅ Idioma Português Brasil ativado!</p>";
    }
    
    $languages = DB::table('languages')
        ->orderBy('is_default', 'desc')
        ->limit(5)
        ->get();
    
    echo "<ul>";
    foreach ($languages as $lang) {
        $status = $lang->is_default ? '✅ ATIVO' : '⚪ Inativo';
        echo "<li>{$lang->name} ({$lang->code}) - {$status}</li>";
    }
    echo "</ul>";
    echo "</div>";
    
    // PASSO 3: Aplicar cor do robô
    echo "<div class='step'>";
    echo "<h3>🎨 Passo 3: Aplicando cores do robô azul...</h3>";
    
    DB::table('general_settings')
        ->where('id', 1)
        ->update([
            'base_color' => '29B6F6',
            'updated_at' => now()
        ]);
    
    $settings = DB::table('general_settings')->where('id', 1)->first();
    
    echo "<p class='success'>✅ Cor do robô aplicada: #{$settings->base_color}</p>";
    echo "<p><strong>Site:</strong> " . $settings->site_name . "</p>";
    echo "</div>";
    
    // PASSO 4: Limpar cache
    echo "<div class='step'>";
    echo "<h3>🔄 Passo 4: Limpando cache...</h3>";
    
    try {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        echo "<p class='success'>✅ Cache limpo com sucesso!</p>";
    } catch (Exception $e) {
        echo "<p class='error'>⚠️ Não foi possível limpar cache automaticamente</p>";
        echo "<p>Execute manualmente: <code>php artisan cache:clear</code></p>";
    }
    echo "</div>";
    
    // Resultado final
    echo "<div class='info'>";
    echo "<h2>✅ CONFIGURAÇÃO CONCLUÍDA COM SUCESSO!</h2>";
    echo "<p class='credential'>🔐 Credenciais de Acesso:</p>";
    echo "<ul>";
    echo "<li><strong>URL:</strong> <a href='https://inteligenciamax.com.br/admin'>https://inteligenciamax.com.br/admin</a></li>";
    echo "<li><strong>Usuário:</strong> <span class='credential'>admin</span></li>";
    echo "<li><strong>Senha:</strong> <span class='credential'>admin</span></li>";
    echo "</ul>";
    
    echo "<p><strong>⚠️ IMPORTANTE:</strong></p>";
    echo "<ol>";
    echo "<li>Feche todas as abas do site</li>";
    echo "<li>Limpe o cache do navegador (Ctrl+Shift+Del)</li>";
    echo "<li>Abra uma aba anônima</li>";
    echo "<li>Acesse o admin e faça login</li>";
    echo "<li>Mude a senha imediatamente no perfil!</li>";
    echo "<li><strong>DELETE este arquivo:</strong> setup-admin.php</li>";
    echo "</ol>";
    
    echo "<div style='text-align: center;'>";
    echo "<a href='https://inteligenciamax.com.br/admin' class='btn'>🚀 ACESSAR ADMIN</a>";
    echo "</div>";
    
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='step'>";
    echo "<p class='error'>❌ ERRO: " . $e->getMessage() . "</p>";
    echo "<p>Linha: " . $e->getLine() . "</p>";
    echo "<p>Arquivo: " . $e->getFile() . "</p>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h3>💡 Solução Alternativa:</h3>";
    echo "<p>Execute estes comandos SQL no Railway:</p>";
    echo "<pre style='background: #f0f0f0; padding: 15px; overflow: auto;'>";
    echo "UPDATE admins SET password = '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE id = 1;\n";
    echo "UPDATE languages SET is_default = 0;\n";
    echo "UPDATE languages SET is_default = 1 WHERE code = 'pt';\n";
    echo "UPDATE general_settings SET base_color = '29B6F6' WHERE id = 1;";
    echo "</pre>";
    echo "</div>";
}

echo "
    </div>
</body>
</html>";
?>
