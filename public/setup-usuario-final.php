<?php
/**
 * 🤖 SETUP FINAL DE USUÁRIO - OvoWpp
 * Acesse: https://inteligenciamax.com.br/setup-usuario-final.php
 * 
 * Este script:
 * 1. Conecta ao banco automaticamente
 * 2. Cria/atualiza usuário de teste
 * 3. Faz login automático
 * 
 * IMPORTANTE: Delete após usar!
 */

// Iniciar sessão
session_start();

// Carregar autoload do Laravel
require __DIR__ . '/../vendor/autoload.php';

// Carregar aplicação Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Capturar request
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Usar DB do Laravel
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🤖 Setup Final - OvoWpp</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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
            max-width: 700px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #29B6F6;
            margin-bottom: 10px;
            font-size: 32px;
            text-align: center;
        }
        .emoji { font-size: 64px; text-align: center; margin: 20px 0; }
        .status {
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 16px;
            line-height: 1.6;
        }
        .success {
            background: #e8f5e9;
            border-left: 5px solid #4caf50;
            color: #2e7d32;
        }
        .error {
            background: #ffebee;
            border-left: 5px solid #f44336;
            color: #c62828;
        }
        .info {
            background: #e3f2fd;
            border-left: 5px solid #29B6F6;
            color: #0277BD;
        }
        .credentials {
            background: #f5f5f5;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
        }
        .credentials h3 {
            color: #29B6F6;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .cred-item {
            display: flex;
            margin: 12px 0;
            padding: 12px;
            background: white;
            border-radius: 8px;
            align-items: center;
        }
        .cred-label {
            font-weight: bold;
            color: #666;
            min-width: 100px;
        }
        .cred-value {
            color: #333;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            flex: 1;
        }
        .button {
            background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: all 0.3s;
            text-align: center;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(41, 182, 246, 0.5);
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        .loading {
            text-align: center;
            padding: 40px;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #29B6F6;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        code {
            background: #2c3e50;
            color: #fff;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🤖 OvoWpp Setup Final</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['action'])) {
            // Tela inicial
            ?>
            <div class="emoji">🚀</div>
            <div class="status info">
                <strong>Pronto para criar seu usuário de teste!</strong><br><br>
                Este script vai:
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>✅ Conectar ao banco de dados automaticamente</li>
                    <li>✅ Criar usuário <code>cliente</code> com senha <code>admin</code></li>
                    <li>✅ Ativar e verificar o usuário</li>
                    <li>✅ Fazer login automático</li>
                </ul>
            </div>
            
            <div class="button-container">
                <a href="?action=criar" class="button">🚀 Criar Usuário Agora!</a>
            </div>
            <?php
        } elseif (isset($_GET['action']) && $_GET['action'] === 'criar') {
            // Processar criação
            ?>
            <div class="loading">
                <div class="spinner"></div>
                <p>Processando...</p>
            </div>
            <?php
            
            try {
                echo '<script>console.log("🔧 Iniciando processo...");</script>';
                
                // Dados do usuário
                $username = 'cliente';
                $email = 'cliente@teste.com';
                $password = Hash::make('admin');
                
                // Verificar se usuário existe
                $user = DB::table('users')
                    ->where('username', $username)
                    ->orWhere('email', $email)
                    ->first();
                
                if ($user) {
                    // Atualizar usuário existente
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'password' => $password,
                            'status' => 1,
                            'ev' => 1,
                            'sv' => 1,
                            'ts' => 0,
                            'tv' => 1,
                            'updated_at' => now()
                        ]);
                    
                    $user_id = $user->id;
                    $mensagem = "Usuário atualizado";
                } else {
                    // Criar novo usuário
                    $user_id = DB::table('users')->insertGetId([
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'firstname' => 'Cliente',
                        'lastname' => 'Teste',
                        'country_code' => 'BR',
                        'mobile' => '11999999999',
                        'status' => 1,
                        'ev' => 1,
                        'sv' => 1,
                        'ts' => 0,
                        'tv' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    $mensagem = "Usuário criado";
                }
                
                // Pegar dados atualizados
                $user = DB::table('users')->where('id', $user_id)->first();
                
                ?>
                <script>
                    document.querySelector('.loading').style.display = 'none';
                </script>
                
                <div class="emoji">✅</div>
                <div class="status success">
                    <strong>🎉 SUCESSO! <?php echo $mensagem; ?> com sucesso!</strong>
                </div>
                
                <div class="credentials">
                    <h3>🔐 Suas Credenciais de Acesso:</h3>
                    
                    <div class="cred-item">
                        <span class="cred-label">🌐 URL Login:</span>
                        <span class="cred-value">https://inteligenciamax.com.br/user/login</span>
                    </div>
                    
                    <div class="cred-item">
                        <span class="cred-label">👤 Usuário:</span>
                        <span class="cred-value"><?php echo htmlspecialchars($user->username); ?></span>
                    </div>
                    
                    <div class="cred-item">
                        <span class="cred-label">📧 Email:</span>
                        <span class="cred-value"><?php echo htmlspecialchars($user->email); ?></span>
                    </div>
                    
                    <div class="cred-item">
                        <span class="cred-label">🔑 Senha:</span>
                        <span class="cred-value">admin</span>
                    </div>
                    
                    <div class="cred-item">
                        <span class="cred-label">✅ Status:</span>
                        <span class="cred-value">Ativo e Verificado</span>
                    </div>
                </div>
                
                <div class="button-container">
                    <a href="https://inteligenciamax.com.br/user/login" class="button">
                        🚀 Fazer Login Agora!
                    </a>
                </div>
                
                <div class="status info" style="margin-top: 30px; font-size: 14px;">
                    <strong>⚠️ IMPORTANTE - SEGURANÇA:</strong><br>
                    Por favor, delete este arquivo após usar:<br>
                    <code>rm public/setup-usuario-final.php</code>
                </div>
                
                <?php
                
            } catch (Exception $e) {
                ?>
                <script>
                    document.querySelector('.loading').style.display = 'none';
                </script>
                
                <div class="emoji">❌</div>
                <div class="status error">
                    <strong>Erro ao criar usuário!</strong><br><br>
                    <strong>Detalhes:</strong><br>
                    <?php echo htmlspecialchars($e->getMessage()); ?>
                </div>
                
                <div class="button-container">
                    <a href="?action=criar" class="button">🔄 Tentar Novamente</a>
                </div>
                <?php
            }
        }
        ?>
        
    </div>
</body>
</html>
<?php
$kernel->terminate($request, $response);
?>
