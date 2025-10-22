<?php
/**
 * Script para criar usuário de teste
 * Acesse: https://inteligenciamax.com.br/criar-usuario-teste.php
 * 
 * IMPORTANTE: Delete este arquivo após usar!
 */

// Configurações do banco de dados Railway
$host = 'metro.proxy.rlwy.net';
$port = '37078';
$database = 'railway';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';

// Credenciais do novo usuário
$novo_usuario = [
    'username' => 'cliente',
    'email' => 'cliente@teste.com',
    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // senha: admin
    'firstname' => 'Cliente',
    'lastname' => 'Teste',
    'country_code' => 'BR',
    'mobile' => '11999999999',
    'status' => 1,
    'ev' => 1, // email verified
    'sv' => 1, // sms verified  
    'ts' => 0, // 2fa status
    'tv' => 1  // 2fa verified
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário de Teste - OvoWpp</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #29B6F6;
            margin-bottom: 10px;
            font-size: 28px;
        }
        h2 {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
            font-weight: normal;
        }
        .status {
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .success {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
        }
        .error {
            background: #ffebee;
            border-left: 4px solid #f44336;
            color: #c62828;
        }
        .info {
            background: #e3f2fd;
            border-left: 4px solid #29B6F6;
            color: #0277BD;
        }
        .credentials {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .credentials h3 {
            color: #29B6F6;
            margin-bottom: 15px;
        }
        .credential-item {
            display: flex;
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        .credential-label {
            font-weight: bold;
            color: #666;
            min-width: 120px;
        }
        .credential-value {
            color: #333;
            font-family: 'Courier New', monospace;
        }
        .button {
            background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px 5px;
            transition: all 0.3s;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(41, 182, 246, 0.4);
        }
        .button-secondary {
            background: linear-gradient(135deg, #0277BD 0%, #01579B 100%);
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ff9800;
            color: #856404;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .emoji {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🤖 OvoWpp - Inteligência MAX</h1>
        <h2>Criação de Usuário de Teste</h2>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['criar'])) {
            try {
                // Conectar ao banco
                $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
                $pdo = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);

                // Verificar se usuário já existe
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$novo_usuario['username'], $novo_usuario['email']]);
                
                if ($stmt->fetch()) {
                    echo '<div class="status error">';
                    echo '<span class="emoji">⚠️</span>';
                    echo '<strong>Usuário já existe!</strong><br>';
                    echo 'O usuário "' . htmlspecialchars($novo_usuario['username']) . '" ou email "' . htmlspecialchars($novo_usuario['email']) . '" já está cadastrado.';
                    echo '</div>';
                } else {
                    // Inserir novo usuário
                    $sql = "INSERT INTO users (
                        username, email, password, firstname, lastname,
                        country_code, mobile, status, ev, sv, ts, tv,
                        created_at, updated_at
                    ) VALUES (
                        :username, :email, :password, :firstname, :lastname,
                        :country_code, :mobile, :status, :ev, :sv, :ts, :tv,
                        NOW(), NOW()
                    )";
                    
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($novo_usuario);

                    echo '<div class="status success">';
                    echo '<span class="emoji">✅</span>';
                    echo '<strong>Usuário criado com sucesso!</strong>';
                    echo '</div>';

                    echo '<div class="credentials">';
                    echo '<h3>🔐 Credenciais de Acesso:</h3>';
                    echo '<div class="credential-item">';
                    echo '<span class="credential-label">URL Login:</span>';
                    echo '<span class="credential-value">https://inteligenciamax.com.br/user/login</span>';
                    echo '</div>';
                    echo '<div class="credential-item">';
                    echo '<span class="credential-label">Usuário:</span>';
                    echo '<span class="credential-value">' . htmlspecialchars($novo_usuario['username']) . '</span>';
                    echo '</div>';
                    echo '<div class="credential-item">';
                    echo '<span class="credential-label">Email:</span>';
                    echo '<span class="credential-value">' . htmlspecialchars($novo_usuario['email']) . '</span>';
                    echo '</div>';
                    echo '<div class="credential-item">';
                    echo '<span class="credential-label">Senha:</span>';
                    echo '<span class="credential-value">admin</span>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div style="text-align: center; margin-top: 30px;">';
                    echo '<a href="https://inteligenciamax.com.br/user/login" class="button">Fazer Login Agora</a>';
                    echo '</div>';
                }

            } catch (PDOException $e) {
                echo '<div class="status error">';
                echo '<span class="emoji">❌</span>';
                echo '<strong>Erro ao conectar ao banco de dados!</strong><br>';
                echo 'Detalhes: ' . htmlspecialchars($e->getMessage());
                echo '</div>';
            }
        } else {
            // Formulário inicial
            echo '<div class="status info">';
            echo '<span class="emoji">ℹ️</span>';
            echo '<strong>Este script vai criar um usuário de teste</strong><br>';
            echo 'Um usuário chamado "cliente" será criado no sistema com senha "admin".';
            echo '</div>';

            echo '<div class="credentials">';
            echo '<h3>📋 Dados que serão criados:</h3>';
            echo '<div class="credential-item">';
            echo '<span class="credential-label">Usuário:</span>';
            echo '<span class="credential-value">cliente</span>';
            echo '</div>';
            echo '<div class="credential-item">';
            echo '<span class="credential-label">Email:</span>';
            echo '<span class="credential-value">cliente@teste.com</span>';
            echo '</div>';
            echo '<div class="credential-item">';
            echo '<span class="credential-label">Senha:</span>';
            echo '<span class="credential-value">admin</span>';
            echo '</div>';
            echo '<div class="credential-item">';
            echo '<span class="credential-label">Status:</span>';
            echo '<span class="credential-value">Ativo e Verificado</span>';
            echo '</div>';
            echo '</div>';

            echo '<form method="POST" style="text-align: center; margin-top: 30px;">';
            echo '<button type="submit" name="criar" class="button">Criar Usuário Agora</button>';
            echo '</form>';
        }
        ?>

        <div class="warning">
            <strong>⚠️ AVISO DE SEGURANÇA:</strong><br>
            Por favor, <strong>DELETE ESTE ARQUIVO</strong> após criar o usuário!<br>
            Arquivo: <code>/public/criar-usuario-teste.php</code>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="https://inteligenciamax.com.br/admin" class="button button-secondary">Ir para Painel Admin</a>
        </div>
    </div>
</body>
</html>
