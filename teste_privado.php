<?php
$url = getenv("DATABASE_URL");

if (!$url) {
    die("❌ Variável DATABASE_URL não encontrada!");
}

$db = parse_url($url);

$host = $db["host"];
$port = $db["port"];
$user = $db["user"];
$pass = $db["pass"];
$dbname = ltrim($db["path"], '/');

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("❌ Erro ao conectar: " . $conn->connect_error);
} else {
    echo "✅ Conectado com sucesso via rede privada (Railway)!";
}
?>
