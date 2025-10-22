#!/usr/bin/env php
<?php
/**
 * Script para criar usuário de teste DIRETO
 * Execute: php criar-usuario-direto.php
 */

echo "=================================================\n";
echo "🤖 OvoWpp - Criando Usuário de Teste\n";
echo "=================================================\n\n";

// Credenciais do Railway MySQL
$host = 'metro.proxy.rlwy.net';
$port = '37078';
$database = 'railway';
$db_user = 'root';
$db_pass = 'BCtMtvKSkYjVrKyTVTcTOGjLrgGdWauv'; // Senha do Railway

echo "📡 Conectando ao banco de dados...\n";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "✅ Conectado com sucesso!\n\n";
    
    // Dados do novo usuário
    $username = 'cliente';
    $email = 'cliente@teste.com';
    $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // senha: admin
    $firstname = 'Cliente';
    $lastname = 'Teste';
    
    echo "🔍 Verificando se usuário já existe...\n";
    
    // Verificar se já existe
    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        echo "⚠️  Usuário já existe!\n";
        echo "   ID: " . $existing['id'] . "\n";
        echo "   Username: " . $existing['username'] . "\n";
        echo "   Email: " . $existing['email'] . "\n\n";
        echo "🔄 Atualizando senha do usuário existente...\n";
        
        // Atualizar senha do usuário existente
        $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE username = ? OR email = ?");
        $stmt->execute([$password, $username, $email]);
        
        echo "✅ Senha atualizada com sucesso!\n\n";
    } else {
        echo "➕ Criando novo usuário...\n";
        
        // Criar novo usuário
        $sql = "INSERT INTO users (
            username, email, password, firstname, lastname,
            country_code, mobile, status, ev, sv, ts, tv,
            created_at, updated_at
        ) VALUES (
            ?, ?, ?, ?, ?,
            'BR', '11999999999', 1, 1, 1, 0, 1,
            NOW(), NOW()
        )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $username,
            $email,
            $password,
            $firstname,
            $lastname
        ]);
        
        $user_id = $pdo->lastInsertId();
        
        echo "✅ Usuário criado com sucesso!\n";
        echo "   ID: $user_id\n\n";
    }
    
    // Mostrar credenciais
    echo "=================================================\n";
    echo "🔐 CREDENCIAIS DE ACESSO\n";
    echo "=================================================\n\n";
    echo "URL Login:  https://inteligenciamax.com.br/user/login\n";
    echo "Usuário:    $username\n";
    echo "Email:      $email\n";
    echo "Senha:      admin\n\n";
    echo "=================================================\n";
    echo "✅ PRONTO! Você já pode fazer login!\n";
    echo "=================================================\n\n";
    
    // Verificar o usuário criado
    echo "📊 Verificando dados no banco...\n";
    $stmt = $pdo->prepare("SELECT id, username, email, firstname, lastname, status, ev, sv FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "✅ Usuário confirmado no banco:\n";
        echo "   ID:        " . $user['id'] . "\n";
        echo "   Username:  " . $user['username'] . "\n";
        echo "   Email:     " . $user['email'] . "\n";
        echo "   Nome:      " . $user['firstname'] . " " . $user['lastname'] . "\n";
        echo "   Status:    " . ($user['status'] ? 'Ativo ✅' : 'Inativo ❌') . "\n";
        echo "   Email Ver: " . ($user['ev'] ? 'Sim ✅' : 'Não ❌') . "\n";
        echo "   SMS Ver:   " . ($user['sv'] ? 'Sim ✅' : 'Não ❌') . "\n";
    }
    
    echo "\n⚠️  IMPORTANTE: Delete este arquivo após usar!\n";
    echo "   rm criar-usuario-direto.php\n\n";
    
} catch (PDOException $e) {
    echo "❌ ERRO: " . $e->getMessage() . "\n\n";
    exit(1);
}
