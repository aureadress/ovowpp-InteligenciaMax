<?php
/**
 * INSERIR ÍCONES SVG NO BANCO DE DADOS
 * Acesse: https://inteligenciamax.com.br/inserir_icones.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão direta MySQL
$host = getenv('DB_HOST') ?: getenv('MYSQL_HOST');
$database = getenv('DB_DATABASE') ?: getenv('MYSQL_DATABASE');
$username = getenv('DB_USERNAME') ?: getenv('MYSQL_USER');
$password = getenv('DB_PASSWORD') ?: getenv('MYSQL_PASSWORD');
$port = getenv('DB_PORT') ?: 3306;

// Ícones SVG para features
$icones_features = [
    // Ícone 1 - Plataforma Unificada
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
    
    // Ícone 2 - Analytics
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
    
    // Ícone 3 - Integração
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
    
    // Ícone 4 - Automação
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6m5.2-14.2l-4.2 4.2m0 6l4.2 4.2M23 12h-6m-6 0H1m14.2 5.2l-4.2-4.2m0-6l-4.2-4.2"/></svg>',
];

// Ícones para How It Works
$icones_steps = [
    // Step 1 - Registrar
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>',
    
    // Step 2 - Configurar
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6"/><path d="M17 7l-3 3m-4 4l-3 3m10-10l-3 3m-4 4l-3 3"/></svg>',
    
    // Step 3 - Conectar
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
    
    // Step 4 - Enviar
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>',
];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inserir Ícones - Inteligência MAX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0D1835 0%, #1a2838 100%);
            color: #fff;
            padding: 40px;
            line-height: 1.8;
        }
        .box {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #29B6F6;
        }
        .success { border-left-color: #4CAF50; }
        .error { border-left-color: #f44336; }
        h1 { color: #29B6F6; }
        .icon-preview {
            display: inline-block;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%);
            border-radius: 8px;
            padding: 12px;
            margin: 5px;
        }
        .icon-preview svg {
            width: 100%;
            height: 100%;
            stroke: white;
        }
    </style>
</head>
<body>
    <h1>🎨 Inserir Ícones SVG no Banco de Dados</h1>
    
    <?php
    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        echo '<div class="box success">';
        echo '<h2>✅ Conectado ao Banco</h2>';
        echo '</div>';
        
        // Verificar se tabela frontends existe
        echo '<div class="box">';
        echo '<h2>🔍 Verificando Estrutura</h2>';
        
        $tables = $pdo->query("SHOW TABLES LIKE 'frontends'")->fetchAll();
        
        if (empty($tables)) {
            echo '<p style="color: #f44336;">❌ Tabela "frontends" não encontrada!</p>';
            echo '<p>Os ícones são gerenciados pelo admin panel.</p>';
        } else {
            echo '<p style="color: #4CAF50;">✅ Tabela "frontends" encontrada!</p>';
            
            // Buscar features atuais
            $stmt = $pdo->query("
                SELECT id, data_keys, data_values 
                FROM frontends 
                WHERE data_keys = 'feature.element' 
                ORDER BY id 
                LIMIT 4
            ");
            $features = $stmt->fetchAll();
            
            if (!empty($features)) {
                echo '<h3>Ícones de Features Atuais:</h3>';
                $count = 0;
                foreach ($features as $feature) {
                    $data = json_decode($feature['data_values'], true);
                    echo '<div style="margin: 10px 0; padding: 10px; background: rgba(0,0,0,0.3); border-radius: 5px;">';
                    echo '<strong>Feature ' . ($count + 1) . ':</strong> ' . htmlspecialchars($data['title'] ?? 'Sem título');
                    if (!empty($data['feature_icon'])) {
                        echo '<div class="icon-preview">' . $data['feature_icon'] . '</div>';
                        echo '<p style="font-size: 12px; color: #4CAF50;">✅ Ícone presente</p>';
                    } else {
                        echo '<p style="font-size: 12px; color: #f44336;">❌ Ícone faltando</p>';
                    }
                    echo '</div>';
                    $count++;
                }
            }
            
            // Buscar steps
            $stmt = $pdo->query("
                SELECT id, data_keys, data_values 
                FROM frontends 
                WHERE data_keys = 'how_it_work.element' 
                ORDER BY id 
                LIMIT 4
            ");
            $steps = $stmt->fetchAll();
            
            if (!empty($steps)) {
                echo '<h3>Ícones de Steps Atuais:</h3>';
                $count = 0;
                foreach ($steps as $step) {
                    $data = json_decode($step['data_values'], true);
                    echo '<div style="margin: 10px 0; padding: 10px; background: rgba(0,0,0,0.3); border-radius: 5px;">';
                    echo '<strong>Step ' . ($count + 1) . ':</strong> ' . htmlspecialchars($data['title'] ?? 'Sem título');
                    if (!empty($data['step_icon'])) {
                        echo '<div class="icon-preview">' . $data['step_icon'] . '</div>';
                        echo '<p style="font-size: 12px; color: #4CAF50;">✅ Ícone presente</p>';
                    } else {
                        echo '<p style="font-size: 12px; color: #f44336;">❌ Ícone faltando</p>';
                    }
                    echo '</div>';
                    $count++;
                }
            }
        }
        
        echo '</div>';
        
        echo '<div class="box">';
        echo '<h2>📋 Informação Importante</h2>';
        echo '<p>Os ícones são gerenciados através do <strong>Admin Panel</strong>:</p>';
        echo '<ol>';
        echo '<li>Acesse: <a href="/admin/frontend/sections/feature" style="color: #29B6F6;">/admin/frontend/sections/feature</a></li>';
        echo '<li>Edite cada card de feature</li>';
        echo '<li>Cole o código SVG no campo "Feature Icon"</li>';
        echo '<li>Salve as alterações</li>';
        echo '</ol>';
        echo '</div>';
        
    } catch (Exception $e) {
        echo '<div class="box error">';
        echo '<h2>❌ Erro</h2>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '</div>';
    }
    ?>
    
    <p><a href="/" style="color: #29B6F6;">← Voltar</a></p>
</body>
</html>
