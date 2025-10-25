<?php
// Debug script para identificar erro no /admin/users/detail/1
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$userId = 1; // ID do usuário que está causando erro

echo "<h1>Debug User Detail - ID: {$userId}</h1>";
echo "<pre>";

try {
    echo "\n1. Buscando usuário...\n";
    $user = App\Models\User::findOrFail($userId);
    echo "   ✓ Usuário encontrado: {$user->username}\n";
    
    echo "\n2. Buscando logs de login...\n";
    $loginLogs = App\Models\UserLogin::where('user_id', $user->id)->take(6)->get();
    echo "   ✓ Logs de login: " . $loginLogs->count() . " registros\n";
    
    echo "\n3. Calculando total de depósitos...\n";
    $totalDeposit = App\Models\Deposit::where('user_id', $user->id)->successful()->sum('amount');
    echo "   ✓ Total depósitos: " . $totalDeposit . "\n";
    
    echo "\n4. Calculando total de saques...\n";
    $totalWithdraw = App\Models\Withdrawal::where('user_id', $user->id)->approved()->sum('amount');
    echo "   ✓ Total saques: " . $totalWithdraw . "\n";
    
    echo "\n5. Calculando total de transações...\n";
    $totalTransaction = App\Models\Transaction::where('user_id', $user->id)->sum('amount');
    echo "   ✓ Total transações: " . $totalTransaction . "\n";
    
    echo "\n6. Carregando countries JSON...\n";
    $countriesPath = resource_path('views/partials/country.json');
    echo "   Caminho: {$countriesPath}\n";
    echo "   Existe: " . (file_exists($countriesPath) ? 'SIM' : 'NÃO') . "\n";
    
    if (file_exists($countriesPath)) {
        $countriesJson = file_get_contents($countriesPath);
        echo "   Tamanho: " . strlen($countriesJson) . " bytes\n";
        $countries = json_decode($countriesJson);
        echo "   ✓ JSON decodificado com sucesso\n";
        echo "   Países: " . count((array)$countries) . "\n";
    }
    
    echo "\n✅ TODOS OS TESTES PASSARAM!\n";
    echo "\nO erro 500 pode estar na view (blade template).\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERRO ENCONTRADO:\n";
    echo "Tipo: " . get_class($e) . "\n";
    echo "Mensagem: " . $e->getMessage() . "\n";
    echo "Arquivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack Trace:\n";
    echo $e->getTraceAsString();
}

echo "</pre>";
