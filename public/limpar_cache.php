<?php
// Script para limpar todos os caches do Laravel
// Acesse via: https://inteligenciamax.com.br/limpar_cache.php

echo "<h1>Limpando Caches do Laravel...</h1>";

// Limpar cache de configuração
exec('php artisan config:clear', $output1, $return1);
echo "<p>✓ Config cache cleared: " . ($return1 === 0 ? 'OK' : 'ERRO') . "</p>";

// Limpar cache de rotas
exec('php artisan route:clear', $output2, $return2);
echo "<p>✓ Route cache cleared: " . ($return2 === 0 ? 'OK' : 'ERRO') . "</p>";

// Limpar cache de views
exec('php artisan view:clear', $output3, $return3);
echo "<p>✓ View cache cleared: " . ($return3 === 0 ? 'OK' : 'ERRO') . "</p>";

// Limpar cache geral
exec('php artisan cache:clear', $output4, $return4);
echo "<p>✓ Application cache cleared: " . ($return4 === 0 ? 'OK' : 'ERRO') . "</p>";

// Limpar optimize
exec('php artisan optimize:clear', $output5, $return5);
echo "<p>✓ Optimize cleared: " . ($return5 === 0 ? 'OK' : 'ERRO') . "</p>";

echo "<h2 style='color: green;'>✅ Todos os caches foram limpos!</h2>";
echo "<p><strong>Agora pressione CTRL+SHIFT+R no navegador para limpar o cache do navegador.</strong></p>";
echo "<p><a href='/'>← Voltar para a página inicial</a></p>";

// Auto-deletar este arquivo após execução (segurança)
unlink(__FILE__);
echo "<p style='color: red;'>🔒 Este arquivo foi auto-deletado por segurança.</p>";
?>
