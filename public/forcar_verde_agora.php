<?php
/**
 * FORÇAR COR VERDE - SEM DEPENDER DO LARAVEL
 * Acesse: https://inteligenciamax.com.br/forcar_verde_agora.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão direta com MySQL
$host = getenv('DB_HOST') ?: getenv('MYSQL_HOST') ?: 'localhost';
$database = getenv('DB_DATABASE') ?: getenv('MYSQL_DATABASE') ?: '';
$username = getenv('DB_USERNAME') ?: getenv('MYSQL_USER') ?: '';
$password = getenv('DB_PASSWORD') ?: getenv('MYSQL_PASSWORD') ?: '';
$port = getenv('DB_PORT') ?: getenv('MYSQL_PORT') ?: 3306;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forçar Cor Verde - Inteligência MAX</title>
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
        .success { border-left-color: #4CAF50; background: rgba(76, 175, 80, 0.1); }
        .error { border-left-color: #f44336; background: rgba(244, 67, 54, 0.1); }
        h1 { color: #29B6F6; }
        code {
            background: rgba(0,0,0,0.3);
            padding: 2px 8px;
            border-radius: 4px;
            font-family: monospace;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        th {
            background: rgba(41, 182, 246, 0.2);
        }
    </style>
</head>
<body>
    <h1>🚀 FORÇAR COR VERDE - DIRETO NO BANCO</h1>
    
    <?php
    try {
        // Tentar conexão
        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        echo '<div class="box success">';
        echo '<h2>✅ Conectado ao Banco de Dados</h2>';
        echo '<p>Host: <code>' . htmlspecialchars($host) . ':' . $port . '</code></p>';
        echo '<p>Database: <code>' . htmlspecialchars($database) . '</code></p>';
        echo '</div>';
        
        // 1. VER COR ATUAL
        echo '<div class="box">';
        echo '<h2>🔍 1. Verificando Cor Atual</h2>';
        
        $stmt = $pdo->query("SELECT id, site_name, base_color FROM general_settings WHERE id = 1");
        $antes = $stmt->fetch();
        
        if ($antes) {
            echo '<table>';
            echo '<tr><th>Campo</th><th>Valor</th></tr>';
            echo '<tr><td>ID</td><td>' . $antes['id'] . '</td></tr>';
            echo '<tr><td>Site</td><td>' . htmlspecialchars($antes['site_name']) . '</td></tr>';
            echo '<tr><td><strong>Cor ANTES</strong></td><td><code style="font-size: 16px;">#' . $antes['base_color'] . '</code></td></tr>';
            echo '</table>';
        }
        echo '</div>';
        
        // 2. ATUALIZAR PARA VERDE
        echo '<div class="box">';
        echo '<h2>🔄 2. Atualizando para VERDE #25d466</h2>';
        
        $sql = "UPDATE general_settings SET base_color = '25d466' WHERE id = 1";
        $affected = $pdo->exec($sql);
        
        echo '<p>SQL Executado: <code>' . htmlspecialchars($sql) . '</code></p>';
        echo '<p>Linhas afetadas: <strong>' . $affected . '</strong></p>';
        echo '</div>';
        
        // 3. VERIFICAR ALTERAÇÃO
        echo '<div class="box">';
        echo '<h2>✅ 3. Verificando Nova Cor</h2>';
        
        $stmt = $pdo->query("SELECT id, site_name, base_color FROM general_settings WHERE id = 1");
        $depois = $stmt->fetch();
        
        if ($depois) {
            echo '<table>';
            echo '<tr><th>Campo</th><th>Valor</th></tr>';
            echo '<tr><td>ID</td><td>' . $depois['id'] . '</td></tr>';
            echo '<tr><td>Site</td><td>' . htmlspecialchars($depois['site_name']) . '</td></tr>';
            echo '<tr><td><strong>Cor ANTES</strong></td><td><code>#' . $antes['base_color'] . '</code></td></tr>';
            echo '<tr><td><strong>Cor DEPOIS</strong></td><td><code style="font-size: 16px;">#' . $depois['base_color'] . '</code></td></tr>';
            echo '</table>';
            
            if ($depois['base_color'] === '25d466') {
                echo '<div class="box success">';
                echo '<h2>🎉 SUCESSO TOTAL!</h2>';
                echo '<p style="font-size: 18px;">✅ Cor alterada para <strong>VERDE #25d466</strong></p>';
                echo '<p>Dashboard agora deve estar VERDE!</p>';
                echo '</div>';
            } else {
                echo '<div class="box error">';
                echo '<h2>⚠️ Cor não mudou como esperado</h2>';
                echo '<p>Cor atual: <code>#' . $depois['base_color'] . '</code></p>';
                echo '</div>';
            }
        }
        echo '</div>';
        
        // 4. PRÓXIMOS PASSOS
        echo '<div class="box">';
        echo '<h2>📋 4. Próximos Passos</h2>';
        echo '<ol style="font-size: 16px;">';
        echo '<li><strong>Limpe o cache:</strong> <code>Ctrl + Shift + R</code></li>';
        echo '<li><strong>Aguarde 30 segundos</strong> (cache do servidor)</li>';
        echo '<li><strong>Acesse a dashboard:</strong> <a href="/user/dashboard" style="color: #29B6F6;">/user/dashboard</a></li>';
        echo '<li><strong>Confirme que está VERDE</strong></li>';
        echo '<li><strong>Delete este arquivo por segurança</strong></li>';
        echo '</ol>';
        echo '</div>';
        
    } catch (PDOException $e) {
        echo '<div class="box error">';
        echo '<h2>❌ Erro de Conexão</h2>';
        echo '<p><strong>Erro:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<p>Verifique as variáveis de ambiente do Railway.</p>';
        echo '</div>';
    } catch (Exception $e) {
        echo '<div class="box error">';
        echo '<h2>❌ Erro</h2>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '</div>';
    }
    ?>
    
    <p style="margin-top: 40px;">
        <a href="/" style="color: #29B6F6; text-decoration: none; font-size: 16px;">← Voltar para Home</a> | 
        <a href="/user/dashboard" style="color: #29B6F6; text-decoration: none; font-size: 16px;">📊 Ver Dashboard</a>
    </p>
</body>
</html>
