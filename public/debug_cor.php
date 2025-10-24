<?php
// Debug simples - sem Laravel
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug - Cor do Banco</h1>";

// Tentar conectar diretamente
$host = getenv('DB_HOST') ?: 'localhost';
$database = getenv('DB_DATABASE') ?: '';
$username = getenv('DB_USERNAME') ?: '';
$password = getenv('DB_PASSWORD') ?: '';

echo "<p>Host: " . htmlspecialchars($host) . "</p>";
echo "<p>Database: " . htmlspecialchars($database) . "</p>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Conectado ao banco!</p>";
    
    $stmt = $pdo->query("SELECT id, site_name, base_color FROM general_settings WHERE id = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        echo "<h2>Resultado:</h2>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Campo</th><th>Valor</th></tr>";
        echo "<tr><td>ID</td><td>" . $row['id'] . "</td></tr>";
        echo "<tr><td>Site</td><td>" . htmlspecialchars($row['site_name']) . "</td></tr>";
        echo "<tr><td>Cor Base</td><td><strong>#" . $row['base_color'] . "</strong></td></tr>";
        echo "</table>";
        
        if ($row['base_color'] === '25d466') {
            echo "<p style='color: green; font-size: 20px;'>✅ COR CORRETA: VERDE #25d466</p>";
        } elseif ($row['base_color'] === '29B6F6') {
            echo "<p style='color: red; font-size: 20px;'>❌ COR ERRADA: AZUL #29B6F6</p>";
            echo "<p><a href='/executar_sql_agora.php'>Clique aqui para corrigir</a></p>";
        } else {
            echo "<p style='color: orange; font-size: 20px;'>⚠️ COR DIFERENTE: #" . $row['base_color'] . "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>ERRO: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
