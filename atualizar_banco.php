<?php
/**
 * Script de Atualização do Nome do Site
 * Executar UMA ÚNICA VEZ para atualizar o banco de dados
 * 
 * Como usar:
 * 1. Fazer upload deste arquivo na raiz do projeto Railway
 * 2. Acessar: https://seu-dominio.com/atualizar_banco.php
 * 3. Deletar este arquivo após executar
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
    <title>Atualização do Banco de Dados</title>
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
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .step-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
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
        .icon {
            font-size: 20px;
            margin-right: 10px;
        }
        .result-box {
            background: #e7f3ff;
            border: 2px solid #667eea;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .result-item {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .result-item:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #667eea;
        }
        .value {
            color: #333;
        }
        .next-steps {
            background: #fff3cd;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .next-steps h3 {
            color: #856404;
            margin-bottom: 15px;
        }
        .next-steps ol {
            margin-left: 20px;
            color: #856404;
        }
        .next-steps li {
            margin-bottom: 8px;
        }
        .delete-warning {
            background: #f8d7da;
            border: 2px solid #dc3545;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
            color: #721c24;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Atualização do Banco de Dados</h1>
        <p class="subtitle">Inteligência MAX - Sistema de Rebranding</p>

<?php
try {
    echo '<div class="step">';
    echo '<div class="step-title"><span class="icon">🔌</span>Conectando ao banco de dados...</div>';
    echo '</div>';

    // Buscar configurações atuais
    $settings = DB::table('general_settings')->where('id', 1)->first();
    
    if (!$settings) {
        throw new Exception('Configurações não encontradas no banco de dados');
    }

    echo '<div class="step success">';
    echo '<div class="step-title"><span class="icon">✅</span>Conexão estabelecida com sucesso!</div>';
    echo '</div>';

    // Mostrar valores antigos
    echo '<div class="result-box">';
    echo '<h3 style="margin-bottom: 15px; color: #667eea;">📋 Valores ANTES da Atualização:</h3>';
    echo '<div class="result-item">';
    echo '<span class="label">Nome do Site:</span> ';
    echo '<span class="value">' . htmlspecialchars($settings->site_name ?? 'N/A') . '</span>';
    echo '</div>';
    echo '<div class="result-item">';
    echo '<span class="label">Nome do Sistema:</span> ';
    echo '<span class="value">' . htmlspecialchars($settings->system_name ?? 'N/A') . '</span>';
    echo '</div>';
    echo '</div>';

    // Verificar quais colunas existem
    echo '<div class="step">';
    echo '<div class="step-title"><span class="icon">🔍</span>Verificando estrutura da tabela...</div>';
    echo '</div>';

    $columns = DB::select("SHOW COLUMNS FROM general_settings");
    $columnNames = array_map(function($col) { return $col->Field; }, $columns);
    
    // Preparar dados para atualizar
    $updateData = ['site_name' => 'Inteligência MAX'];
    
    // Adicionar system_name apenas se a coluna existir
    if (in_array('system_name', $columnNames)) {
        $updateData['system_name'] = 'inteligenciamax';
    }
    
    // Adicionar system_title se existir
    if (in_array('system_title', $columnNames)) {
        $updateData['system_title'] = 'Inteligência MAX - Sistema de WhatsApp Marketing';
    }

    // Atualizar o banco de dados
    echo '<div class="step">';
    echo '<div class="step-title"><span class="icon">🔄</span>Atualizando configurações...</div>';
    echo '</div>';

    $affected = DB::table('general_settings')
        ->where('id', 1)
        ->update($updateData);

    if ($affected > 0) {
        echo '<div class="step success">';
        echo '<div class="step-title"><span class="icon">✅</span>Banco de dados atualizado com sucesso!</div>';
        echo '</div>';
    } else {
        echo '<div class="step warning">';
        echo '<div class="step-title"><span class="icon">⚠️</span>Nenhuma linha foi alterada (valores já estavam corretos)</div>';
        echo '</div>';
    }

    // Buscar novos valores
    $newSettings = DB::table('general_settings')->where('id', 1)->first();

    // Mostrar valores novos
    echo '<div class="result-box">';
    echo '<h3 style="margin-bottom: 15px; color: #28a745;">✅ Valores DEPOIS da Atualização:</h3>';
    echo '<div class="result-item">';
    echo '<span class="label">Nome do Site:</span> ';
    echo '<span class="value">' . htmlspecialchars($newSettings->site_name) . '</span>';
    echo '</div>';
    if (property_exists($newSettings, 'system_name')) {
        echo '<div class="result-item">';
        echo '<span class="label">Nome do Sistema:</span> ';
        echo '<span class="value">' . htmlspecialchars($newSettings->system_name) . '</span>';
        echo '</div>';
    }
    if (property_exists($newSettings, 'system_title')) {
        echo '<div class="result-item">';
        echo '<span class="label">Título do Sistema:</span> ';
        echo '<span class="value">' . htmlspecialchars($newSettings->system_title) . '</span>';
        echo '</div>';
    }
    echo '</div>';

    // Próximos passos
    echo '<div class="next-steps">';
    echo '<h3>📝 Próximos Passos:</h3>';
    echo '<ol>';
    echo '<li><strong>Limpar o cache do Laravel</strong> (via terminal Railway ou SSH)</li>';
    echo '<li>Execute os comandos:<br>';
    echo '<code style="background:#fff;padding:5px;display:block;margin:5px 0;">php artisan config:clear</code>';
    echo '<code style="background:#fff;padding:5px;display:block;margin:5px 0;">php artisan view:clear</code>';
    echo '<code style="background:#fff;padding:5px;display:block;margin:5px 0;">php artisan cache:clear</code>';
    echo '</li>';
    echo '<li><strong>Recarregue seu site</strong> com Ctrl+F5 ou Cmd+Shift+R</li>';
    echo '<li><strong>DELETE ESTE ARQUIVO</strong> por segurança!</li>';
    echo '</ol>';
    echo '</div>';

    echo '<div class="delete-warning">';
    echo '🔥 IMPORTANTE: Delete o arquivo "atualizar_banco.php" agora!';
    echo '</div>';

} catch (Exception $e) {
    echo '<div class="step error">';
    echo '<div class="step-title"><span class="icon">❌</span>Erro ao atualizar banco de dados</div>';
    echo '<div style="margin-top: 10px; color: #721c24;">';
    echo '<strong>Detalhes do erro:</strong><br>';
    echo htmlspecialchars($e->getMessage());
    echo '</div>';
    echo '</div>';
}
?>
    </div>
</body>
</html>
