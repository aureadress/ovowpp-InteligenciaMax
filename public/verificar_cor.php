<?php
/**
 * Verificador de Cor do Banco de Dados
 * Acesse: https://inteligenciamax.com.br/verificar_cor.php
 */

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verificar Cor - Inteligência MAX</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #0D1835;
            color: #fff;
            padding: 40px;
            line-height: 1.8;
        }
        .box {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #29B6F6;
        }
        .success { border-left-color: #4CAF50; }
        .error { border-left-color: #f44336; }
        h1 { color: #29B6F6; }
        code {
            background: rgba(255,255,255,0.1);
            padding: 2px 8px;
            border-radius: 4px;
        }
        .color-box {
            display: inline-block;
            width: 50px;
            height: 50px;
            border-radius: 8px;
            vertical-align: middle;
            margin-left: 10px;
            border: 2px solid #fff;
        }
    </style>
</head>
<body>
    <h1>🔍 Verificador de Cor do Banco de Dados</h1>
    
    <?php
    try {
        $settings = DB::table('general_settings')->where('id', 1)->first();
        
        echo '<div class="box">';
        echo '<h2>📊 Configurações Atuais:</h2>';
        echo '<p><strong>Site:</strong> ' . htmlspecialchars($settings->site_name) . '</p>';
        echo '<p><strong>Cor Base:</strong> <code>#' . $settings->base_color . '</code>';
        echo '<span class="color-box" style="background-color: #' . $settings->base_color . '"></span></p>';
        echo '</div>';
        
        if ($settings->base_color === '25d466') {
            echo '<div class="box success">';
            echo '<h2>✅ CORRETO!</h2>';
            echo '<p>A cor está definida como <code>#25d466</code> (VERDE)</p>';
            echo '<p><strong>Dashboard deve estar VERDE agora.</strong></p>';
            echo '</div>';
        } elseif ($settings->base_color === '29B6F6') {
            echo '<div class="box error">';
            echo '<h2>❌ INCORRETO!</h2>';
            echo '<p>A cor ainda está <code>#29B6F6</code> (AZUL)</p>';
            echo '<p><strong>Execute o script SQL:</strong></p>';
            echo '<pre>UPDATE general_settings SET base_color = \'25d466\' WHERE id = 1;</pre>';
            echo '<p>Ou acesse: <a href="/executar_sql_agora.php" style="color: #29B6F6;">executar_sql_agora.php</a></p>';
            echo '</div>';
        } else {
            echo '<div class="box">';
            echo '<h2>ℹ️ Cor Diferente</h2>';
            echo '<p>Cor atual: <code>#' . $settings->base_color . '</code></p>';
            echo '<p>Para dashboard verde, execute:</p>';
            echo '<pre>UPDATE general_settings SET base_color = \'25d466\' WHERE id = 1;</pre>';
            echo '</div>';
        }
        
        echo '<div class="box">';
        echo '<h2>📋 Próximos Passos:</h2>';
        echo '<ol>';
        echo '<li>Se a cor estiver AZUL, execute o SQL para mudar para VERDE</li>';
        echo '<li>Limpe o cache: <code>Ctrl + Shift + R</code></li>';
        echo '<li>Teste a dashboard em: <a href="/user/dashboard" style="color: #29B6F6;">/user/dashboard</a></li>';
        echo '<li>Remova este arquivo após verificar</li>';
        echo '</ol>';
        echo '</div>';
        
    } catch (Exception $e) {
        echo '<div class="box error">';
        echo '<h2>❌ Erro</h2>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '</div>';
    }
    ?>
    
    <p><a href="/" style="color: #29B6F6;">← Voltar para Home</a></p>
</body>
</html>
