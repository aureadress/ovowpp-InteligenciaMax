<?php
/**
 * ================================================================================
 * 🚀 SCRIPT DE EXECUÇÃO SQL VIA URL - Inteligência MAX
 * ================================================================================
 * 
 * COMO USAR:
 * 1. Acesse: https://inteligenciamax.com.br/executar_sql_agora.php
 * 2. O script será executado automaticamente
 * 3. Você verá o resultado na tela
 * 
 * O QUE FAZ:
 * - Reverte a cor base para VERDE #25d466 (dashboard)
 * - Mantém azul apenas em landing e login (via CSS)
 * 
 * ⚠️ IMPORTANTE: Remova este arquivo após executar!
 * ================================================================================
 */

// Carregar o Laravel
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Usar o DB do Laravel
use Illuminate\Support\Facades\DB;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Execução SQL - Inteligência MAX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0D1835 0%, #1a2838 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(41, 182, 246, 0.2);
        }
        h1 {
            color: #29B6F6;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #a0a0a0;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .section {
            background: rgba(255, 255, 255, 0.03);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #29B6F6;
        }
        .section h2 {
            color: #29B6F6;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .icon {
            font-size: 24px;
        }
        .result {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }
        .success {
            color: #4CAF50;
            border-left: 4px solid #4CAF50;
        }
        .error {
            color: #f44336;
            border-left: 4px solid #f44336;
        }
        .info {
            color: #2196F3;
            border-left: 4px solid #2196F3;
        }
        .warning {
            background: rgba(255, 152, 0, 0.1);
            color: #FF9800;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #FF9800;
        }
        .btn {
            background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(41, 182, 246, 0.4);
        }
        code {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
        .step {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }
        .step-number {
            background: #29B6F6;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        th {
            background: rgba(41, 182, 246, 0.2);
            color: #29B6F6;
            font-weight: 600;
        }
        tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Execução SQL - Inteligência MAX</h1>
        <p class="subtitle">Revertendo cor da dashboard para VERDE original</p>

        <?php
        try {
            // 1. VERIFICAR COR ATUAL
            echo '<div class="section">';
            echo '<h2><span class="icon">🔍</span> 1. Verificando Cor Atual</h2>';
            
            $corAtual = DB::table('general_settings')
                ->where('id', 1)
                ->first(['id', 'site_name', 'base_color']);
            
            if ($corAtual) {
                echo '<div class="result info">';
                echo '<table>';
                echo '<tr><th>Campo</th><th>Valor</th></tr>';
                echo '<tr><td><strong>ID</strong></td><td>' . $corAtual->id . '</td></tr>';
                echo '<tr><td><strong>Site</strong></td><td>' . htmlspecialchars($corAtual->site_name) . '</td></tr>';
                echo '<tr><td><strong>Cor Antes</strong></td><td><code>#' . $corAtual->base_color . '</code></td></tr>';
                echo '</table>';
                echo '</div>';
                
                $corAntes = $corAtual->base_color;
            } else {
                throw new Exception('Registro não encontrado no banco de dados!');
            }
            echo '</div>';

            // 2. ATUALIZAR PARA VERDE
            echo '<div class="section">';
            echo '<h2><span class="icon">🔄</span> 2. Atualizando Cor para VERDE</h2>';
            
            $updated = DB::table('general_settings')
                ->where('id', 1)
                ->update(['base_color' => '25d466']);
            
            if ($updated) {
                echo '<div class="result success">';
                echo '✅ <strong>Atualização realizada com sucesso!</strong><br>';
                echo 'Linhas afetadas: ' . $updated;
                echo '</div>';
            } else {
                echo '<div class="result info">';
                echo 'ℹ️ A cor já estava definida como 25d466 (nenhuma alteração necessária)';
                echo '</div>';
            }
            echo '</div>';

            // 3. VERIFICAR ALTERAÇÃO
            echo '<div class="section">';
            echo '<h2><span class="icon">✅</span> 3. Verificando Nova Cor</h2>';
            
            $corDepois = DB::table('general_settings')
                ->where('id', 1)
                ->first(['id', 'site_name', 'base_color']);
            
            if ($corDepois) {
                $sucesso = ($corDepois->base_color === '25d466');
                $classe = $sucesso ? 'success' : 'error';
                
                echo '<div class="result ' . $classe . '">';
                echo '<table>';
                echo '<tr><th>Campo</th><th>Valor</th></tr>';
                echo '<tr><td><strong>ID</strong></td><td>' . $corDepois->id . '</td></tr>';
                echo '<tr><td><strong>Site</strong></td><td>' . htmlspecialchars($corDepois->site_name) . '</td></tr>';
                echo '<tr><td><strong>Cor Antes</strong></td><td><code>#' . $corAntes . '</code></td></tr>';
                echo '<tr><td><strong>Cor Depois</strong></td><td><code>#' . $corDepois->base_color . '</code></td></tr>';
                echo '<tr><td><strong>Status</strong></td><td>';
                
                if ($sucesso) {
                    echo '✅ <strong>CORRETO - Dashboard agora está VERDE!</strong>';
                } else {
                    echo '❌ <strong>ERRO - Cor não foi alterada corretamente</strong>';
                }
                
                echo '</td></tr>';
                echo '</table>';
                echo '</div>';
            }
            echo '</div>';

            // 4. PRÓXIMOS PASSOS
            echo '<div class="section">';
            echo '<h2><span class="icon">📋</span> 4. Próximos Passos</h2>';
            echo '<div class="step">';
            echo '<div class="step-number">1</div>';
            echo '<div><strong>Limpe o cache do navegador:</strong><br>';
            echo '<code>Ctrl + Shift + R</code> (Windows) ou <code>Cmd + Shift + R</code> (Mac)</div>';
            echo '</div>';
            
            echo '<div class="step">';
            echo '<div class="step-number">2</div>';
            echo '<div><strong>Teste as páginas:</strong><br>';
            echo '🏠 Landing: <a href="/" style="color: #29B6F6;">inteligenciamax.com.br</a> (deve estar AZUL)<br>';
            echo '🔐 Login: <a href="/user/login" style="color: #29B6F6;">/user/login</a> (deve estar AZUL)<br>';
            echo '📊 Dashboard: <a href="/user/dashboard" style="color: #29B6F6;">/user/dashboard</a> (deve estar VERDE)</div>';
            echo '</div>';
            
            echo '<div class="step">';
            echo '<div class="step-number">3</div>';
            echo '<div><strong>⚠️ REMOVA este arquivo por segurança:</strong><br>';
            echo 'Delete: <code>/public/executar_sql_agora.php</code></div>';
            echo '</div>';
            echo '</div>';

        } catch (Exception $e) {
            echo '<div class="section">';
            echo '<h2><span class="icon">❌</span> Erro</h2>';
            echo '<div class="result error">';
            echo '<strong>Ocorreu um erro:</strong><br>';
            echo htmlspecialchars($e->getMessage());
            echo '</div>';
            echo '</div>';
        }
        ?>

        <div class="warning">
            <strong>⚠️ ATENÇÃO DE SEGURANÇA:</strong><br>
            Este arquivo permite execução direta de SQL no banco de dados. 
            Por favor, <strong>DELETE este arquivo</strong> após a execução usando:<br>
            <code>rm /public/executar_sql_agora.php</code>
        </div>

        <a href="/" class="btn">🏠 Voltar para Home</a>
        <a href="/user/dashboard" class="btn">📊 Ver Dashboard</a>
    </div>
</body>
</html>
