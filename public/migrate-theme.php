<?php
/**
 * Migration Script para Theme Settings
 * 
 * IMPORTANTE: Este script deve ser executado apenas UMA VEZ
 * Acesse via: https://seu-dominio.com/migrate-theme.php
 * 
 * SEGURANÇA: Após executar, DELETE este arquivo!
 */

// Prevenir execução acidental
$EXECUTE_MIGRATION = true; // Mude para true para executar

if (!$EXECUTE_MIGRATION) {
    die("
    <html>
    <head>
        <title>Migration Bloqueada</title>
        <style>
            body { font-family: Arial; margin: 50px; background: #f5f5f5; }
            .container { background: white; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; }
            .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; }
            code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>⚠️ Migration Bloqueada por Segurança</h2>
            <div class='warning'>
                <strong>Para executar a migration:</strong>
                <ol>
                    <li>Edite este arquivo: <code>public/migrate-theme.php</code></li>
                    <li>Mude <code>\$EXECUTE_MIGRATION = false</code> para <code>true</code></li>
                    <li>Recarregue esta página</li>
                    <li><strong>IMPORTANTE:</strong> Delete este arquivo após execução!</li>
                </ol>
            </div>
        </div>
    </body>
    </html>
    ");
}

// Iniciar output buffer para capturar erros
ob_start();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Migration - Theme Settings</title>
    <meta charset='utf-8'>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container { 
            max-width: 800px; 
            margin: 50px auto; 
            background: white; 
            border-radius: 12px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 30px; 
            text-align: center; 
        }
        .header h1 { font-size: 2em; margin-bottom: 10px; }
        .content { padding: 30px; }
        .step { 
            background: #f8f9fa; 
            padding: 20px; 
            margin: 15px 0; 
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .step h3 { color: #667eea; margin-bottom: 10px; }
        .success { 
            background: #d4edda; 
            border-left-color: #28a745; 
            color: #155724;
        }
        .success h3 { color: #28a745; }
        .error { 
            background: #f8d7da; 
            border-left-color: #dc3545;
            color: #721c24;
        }
        .error h3 { color: #dc3545; }
        .warning { 
            background: #fff3cd; 
            border-left-color: #ffc107;
            color: #856404;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .code { 
            background: #2d2d2d; 
            color: #f8f8f2; 
            padding: 15px; 
            border-radius: 6px; 
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }
        .btn {
            display: inline-block;
            background: #dc3545;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: bold;
        }
        .btn:hover { background: #c82333; }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🎨 Theme Settings Migration</h1>
            <p>Instalação do Sistema de Cores Isoladas</p>
        </div>
        <div class='content'>
";

// Carregar o Laravel
try {
    echo "<div class='step'><h3>📦 Passo 1: Carregando Laravel...</h3>";
    
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "<p>✅ Laravel carregado com sucesso!</p></div>";
    
} catch (Exception $e) {
    echo "<div class='step error'><h3>❌ Erro ao Carregar Laravel</h3>";
    echo "<p><strong>Erro:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre></div>";
    echo "</div></div></body></html>";
    exit;
}

// Verificar se a tabela já existe
try {
    echo "<div class='step'><h3>🔍 Passo 2: Verificando tabela...</h3>";
    
    $exists = DB::schema()->hasTable('theme_settings');
    
    if ($exists) {
        echo "<p>⚠️ Tabela <code>theme_settings</code> já existe!</p>";
        echo "<p>Migration não será executada para evitar duplicação.</p></div>";
        
        // Mostrar dados existentes
        echo "<div class='step success'><h3>✅ Configuração Atual</h3>";
        $theme = DB::table('theme_settings')->first();
        if ($theme) {
            echo "<p><strong>Admin Primary:</strong> <span style='background:{$theme->admin_primary_color};padding:5px 10px;color:white;border-radius:3px;'>{$theme->admin_primary_color}</span></p>";
            echo "<p><strong>User Primary:</strong> <span style='background:{$theme->user_primary_color};padding:5px 10px;color:white;border-radius:3px;'>{$theme->user_primary_color}</span></p>";
            echo "<p><strong>Chat Primary:</strong> <span style='background:{$theme->chat_primary_color};padding:5px 10px;color:white;border-radius:3px;'>{$theme->chat_primary_color}</span></p>";
        }
        echo "</div>";
        
    } else {
        echo "<p>✅ Tabela não existe. Prosseguindo com migration...</p></div>";
        
        // Executar migration
        echo "<div class='step'><h3>🚀 Passo 3: Executando Migration...</h3>";
        echo "<div class='loader'></div>";
        
        $exitCode = Artisan::call('migrate', [
            '--path' => 'database/migrations/2025_10_25_000001_create_theme_settings_table.php',
            '--force' => true
        ]);
        
        $output = Artisan::output();
        
        if ($exitCode === 0) {
            echo "<p>✅ Migration executada com sucesso!</p>";
            echo "<div class='code'>" . nl2br(htmlspecialchars($output)) . "</div></div>";
            
            // Verificar se dados foram inseridos
            echo "<div class='step success'><h3>✅ Passo 4: Verificando Dados</h3>";
            $theme = DB::table('theme_settings')->first();
            
            if ($theme) {
                echo "<p><strong>✅ Cores padrão instaladas com sucesso!</strong></p>";
                echo "<ul style='margin-top:15px;'>";
                echo "<li><strong>Admin Primary:</strong> <span style='background:{$theme->admin_primary_color};padding:5px 10px;color:white;border-radius:3px;'>{$theme->admin_primary_color}</span></li>";
                echo "<li><strong>User Primary:</strong> <span style='background:{$theme->user_primary_color};padding:5px 10px;color:white;border-radius:3px;'>{$theme->user_primary_color}</span></li>";
                echo "<li><strong>Chat Primary:</strong> <span style='background:{$theme->chat_primary_color};padding:5px 10px;color:white;border-radius:3px;'>{$theme->chat_primary_color}</span></li>";
                echo "</ul>";
            } else {
                echo "<p>⚠️ Tabela criada mas sem dados. Execute manualmente:</p>";
                echo "<div class='code'>php artisan db:seed --class=ThemeSettingSeeder</div>";
            }
            echo "</div>";
            
        } else {
            throw new Exception("Migration falhou com código de saída: $exitCode\n$output");
        }
    }
    
    // Próximos passos
    echo "<div class='step success'><h3>🎉 Instalação Completa!</h3>";
    echo "<p><strong>Próximos passos:</strong></p>";
    echo "<ol style='margin-top:10px;line-height:1.8;'>";
    echo "<li>Acesse o painel: <a href='/admin/theme/colors' target='_blank'><strong>/admin/theme/colors</strong></a></li>";
    echo "<li>Configure as cores para Admin, User e Chat</li>";
    echo "<li><strong style='color:#dc3545;'>DELETE este arquivo: public/migrate-theme.php</strong></li>";
    echo "</ol></div>";
    
    // Aviso de segurança
    echo "<div class='warning'>";
    echo "<h3 style='color:#856404;margin-bottom:10px;'>⚠️ IMPORTANTE - SEGURANÇA</h3>";
    echo "<p><strong>Este arquivo expõe acesso direto ao banco de dados!</strong></p>";
    echo "<p>Por favor, delete este arquivo imediatamente após uso:</p>";
    echo "<div class='code' style='background:#2d2d2d;color:#f8f8f2;margin-top:10px;'>rm public/migrate-theme.php</div>";
    echo "<p style='margin-top:15px;'><a href='?delete=confirm' class='btn'>🗑️ Deletar Este Arquivo Agora</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='step error'><h3>❌ Erro na Execução</h3>";
    echo "<p><strong>Erro:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre style='margin-top:10px;padding:15px;background:#2d2d2d;color:#f8f8f2;border-radius:6px;overflow-x:auto;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre></div>";
}

echo "
        </div>
    </div>
</body>
</html>
";

// Auto-delete se solicitado
if (isset($_GET['delete']) && $_GET['delete'] === 'confirm') {
    if (unlink(__FILE__)) {
        echo "<script>alert('✅ Arquivo deletado com sucesso!'); window.location.href='/admin';</script>";
    } else {
        echo "<script>alert('❌ Não foi possível deletar o arquivo. Delete manualmente: public/migrate-theme.php');</script>";
    }
}

ob_end_flush();
