<?php
// Script de limpeza de cache - Alternativo
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Limpeza de Cache</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #29B6F6 0%, #004AAD 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .container {
            background: rgba(255,255,255,0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            max-width: 600px;
            margin: 0 auto;
        }
        h1 { margin-bottom: 20px; }
        .status { 
            background: rgba(255,255,255,0.2);
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success { color: #4CAF50; font-weight: bold; }
        .btn {
            background: white;
            color: #29B6F6;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🧹 Limpeza de Cache Laravel</h1>
";

// Executar comandos de limpeza
$commands = [
    'Config Cache' => 'cd /app && php artisan config:clear 2>&1',
    'Route Cache' => 'cd /app && php artisan route:clear 2>&1',
    'View Cache' => 'cd /app && php artisan view:clear 2>&1',
    'Application Cache' => 'cd /app && php artisan cache:clear 2>&1',
    'Optimize Clear' => 'cd /app && php artisan optimize:clear 2>&1'
];

foreach ($commands as $name => $cmd) {
    echo "<div class='status'>";
    echo "📦 <strong>$name</strong>: ";
    $output = shell_exec($cmd);
    if ($output && strpos($output, 'cleared') !== false) {
        echo "<span class='success'>✓ OK</span>";
    } else if (empty($output)) {
        echo "<span class='success'>✓ OK</span>";
    } else {
        echo "⚠️ " . htmlspecialchars(substr($output, 0, 100));
    }
    echo "</div>";
}

echo "
        <h2 class='success'>✅ Cache Limpo!</h2>
        <p>Agora pressione <strong>CTRL+SHIFT+R</strong> no navegador para atualizar.</p>
        <a href='/' class='btn'>← Voltar para Home</a>
    </div>
</body>
</html>";

// Auto-deletar após 1 minuto (segurança)
// sleep(60);
// unlink(__FILE__);
?>
