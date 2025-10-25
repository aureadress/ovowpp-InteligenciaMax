<?php
/**
 * Script de Diagnóstico - Inteligência MAX
 * URL: https://inteligenciamax.com.br/diagnostico.php
 * 
 * Verifica configurações e conectividade para identificar erros 500
 */

// Desabilitar exibição de erros (modo seguro para produção)
ini_set('display_errors', 0);
error_reporting(0);

// Buffer de saída para capturar erros
ob_start();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico - Inteligência MAX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 { font-size: 32px; margin-bottom: 10px; }
        .header p { opacity: 0.9; }
        .content { padding: 30px; }
        .section {
            margin-bottom: 30px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
        }
        .section-header {
            background: #f5f5f5;
            padding: 15px 20px;
            font-weight: bold;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .section-body { padding: 20px; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .status-warning { color: #ffc107; font-weight: bold; }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }
        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #29B6F6;
        }
        .info-item strong { display: block; margin-bottom: 5px; color: #333; }
        .info-item span { color: #666; }
        .code-block {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin-top: 10px;
        }
        .timestamp {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔧 Diagnóstico do Sistema</h1>
            <p>Inteligência MAX - Verificação de Configurações e Conectividade</p>
        </div>

        <div class="content">
            <!-- PHP Info -->
            <div class="section">
                <div class="section-header">
                    <span>🐘 Informações do PHP</span>
                    <span class="badge badge-success">PHP <?php echo PHP_VERSION; ?></span>
                </div>
                <div class="section-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>Versão PHP</strong>
                            <span><?php echo PHP_VERSION; ?></span>
                        </div>
                        <div class="info-item">
                            <strong>SAPI</strong>
                            <span><?php echo php_sapi_name(); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Memory Limit</strong>
                            <span><?php echo ini_get('memory_limit'); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Max Execution Time</strong>
                            <span><?php echo ini_get('max_execution_time'); ?>s</span>
                        </div>
                        <div class="info-item">
                            <strong>Upload Max Filesize</strong>
                            <span><?php echo ini_get('upload_max_filesize'); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Post Max Size</strong>
                            <span><?php echo ini_get('post_max_size'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Extensões PHP -->
            <div class="section">
                <div class="section-header">
                    <span>📦 Extensões PHP Requeridas</span>
                    <?php
                    $required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'json', 'curl', 'gd', 'zip', 'xml'];
                    $loaded = array_filter($required, 'extension_loaded');
                    $missing = array_diff($required, $loaded);
                    ?>
                    <span class="badge <?php echo empty($missing) ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo count($loaded); ?>/<?php echo count($required); ?> carregadas
                    </span>
                </div>
                <div class="section-body">
                    <div class="info-grid">
                        <?php foreach ($required as $ext): ?>
                        <div class="info-item">
                            <strong><?php echo strtoupper($ext); ?></strong>
                            <span class="<?php echo extension_loaded($ext) ? 'status-ok' : 'status-error'; ?>">
                                <?php echo extension_loaded($ext) ? '✓ Instalada' : '✗ Faltando'; ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Laravel Detection -->
            <?php
            $laravelPath = dirname(__DIR__);
            $vendorPath = $laravelPath . '/vendor/autoload.php';
            $envPath = $laravelPath . '/.env';
            $laravelDetected = file_exists($vendorPath);
            ?>
            <div class="section">
                <div class="section-header">
                    <span>🔷 Laravel Framework</span>
                    <span class="badge <?php echo $laravelDetected ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $laravelDetected ? 'Detectado' : 'Não Encontrado'; ?>
                    </span>
                </div>
                <div class="section-body">
                    <?php if ($laravelDetected): ?>
                        <?php
                        require $vendorPath;
                        $app = require_once $laravelPath . '/bootstrap/app.php';
                        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
                        $laravelVersion = $app->version();
                        ?>
                        <div class="info-grid">
                            <div class="info-item">
                                <strong>Versão Laravel</strong>
                                <span><?php echo $laravelVersion; ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Ambiente</strong>
                                <span><?php echo $app['env']; ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Debug Mode</strong>
                                <span class="<?php echo $app['config']['app.debug'] ? 'status-warning' : 'status-ok'; ?>">
                                    <?php echo $app['config']['app.debug'] ? '⚠️ Ativado' : '✓ Desativado'; ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <strong>Arquivo .env</strong>
                                <span class="<?php echo file_exists($envPath) ? 'status-ok' : 'status-error'; ?>">
                                    <?php echo file_exists($envPath) ? '✓ Existe' : '✗ Não Encontrado'; ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <strong>APP_KEY</strong>
                                <span class="<?php echo !empty($app['config']['app.key']) ? 'status-ok' : 'status-error'; ?>">
                                    <?php echo !empty($app['config']['app.key']) ? '✓ Configurada' : '✗ Não Configurada'; ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <strong>APP_URL</strong>
                                <span><?php echo $app['config']['app.url'] ?? 'Não definida'; ?></span>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="status-error">Laravel não detectado. Verifique se o Composer foi executado.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Database Connection -->
            <?php if ($laravelDetected): ?>
            <div class="section">
                <div class="section-header">
                    <span>🗄️ Conexão com Banco de Dados</span>
                    <?php
                    $dbConnected = false;
                    $dbError = '';
                    try {
                        \Illuminate\Support\Facades\DB::connection()->getPdo();
                        $dbConnected = true;
                    } catch (\Exception $e) {
                        $dbError = $e->getMessage();
                    }
                    ?>
                    <span class="badge <?php echo $dbConnected ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $dbConnected ? 'Conectado' : 'Erro'; ?>
                    </span>
                </div>
                <div class="section-body">
                    <?php if ($dbConnected): ?>
                        <?php
                        $dbConfig = $app['config']['database.connections.mysql'];
                        $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
                        ?>
                        <div class="info-grid">
                            <div class="info-item">
                                <strong>Driver</strong>
                                <span><?php echo $dbConfig['driver']; ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Host</strong>
                                <span><?php echo $dbConfig['host']; ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Port</strong>
                                <span><?php echo $dbConfig['port']; ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Database</strong>
                                <span><?php echo $dbConfig['database']; ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Tabelas</strong>
                                <span><?php echo count($tables); ?> encontradas</span>
                            </div>
                            <div class="info-item">
                                <strong>Charset</strong>
                                <span><?php echo $dbConfig['charset']; ?></span>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="status-error">Erro ao conectar: <?php echo htmlspecialchars($dbError); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- File Permissions -->
            <div class="section">
                <div class="section-header">
                    <span>📁 Permissões de Diretórios</span>
                </div>
                <div class="section-body">
                    <?php
                    $dirs = [
                        'storage' => $laravelPath . '/storage',
                        'storage/logs' => $laravelPath . '/storage/logs',
                        'storage/framework' => $laravelPath . '/storage/framework',
                        'storage/app' => $laravelPath . '/storage/app',
                        'bootstrap/cache' => $laravelPath . '/bootstrap/cache',
                    ];
                    ?>
                    <div class="info-grid">
                        <?php foreach ($dirs as $name => $path): ?>
                        <div class="info-item">
                            <strong><?php echo $name; ?></strong>
                            <?php if (file_exists($path)): ?>
                                <?php
                                $perms = substr(sprintf('%o', fileperms($path)), -4);
                                $writable = is_writable($path);
                                ?>
                                <span class="<?php echo $writable ? 'status-ok' : 'status-error'; ?>">
                                    <?php echo $writable ? "✓ $perms (Gravável)" : "✗ $perms (Não gravável)"; ?>
                                </span>
                            <?php else: ?>
                                <span class="status-error">✗ Não existe</span>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Server Info -->
            <div class="section">
                <div class="section-header">
                    <span>🖥️ Informações do Servidor</span>
                </div>
                <div class="section-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>Sistema Operacional</strong>
                            <span><?php echo PHP_OS; ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Servidor Web</strong>
                            <span><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido'; ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Document Root</strong>
                            <span><?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'N/A'; ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Script Filename</strong>
                            <span><?php echo __FILE__; ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Request Time</strong>
                            <span><?php echo date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Remote Address</strong>
                            <span><?php echo $_SERVER['REMOTE_ADDR'] ?? 'N/A'; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommendations -->
            <div class="section">
                <div class="section-header">
                    <span>💡 Recomendações</span>
                </div>
                <div class="section-body">
                    <ul style="line-height: 2;">
                        <?php if (!$laravelDetected): ?>
                        <li class="status-error">Execute <code>composer install</code> para instalar as dependências do Laravel</li>
                        <?php endif; ?>
                        
                        <?php if ($laravelDetected && !file_exists($envPath)): ?>
                        <li class="status-error">Crie o arquivo <code>.env</code> copiando de <code>.env.example</code></li>
                        <?php endif; ?>
                        
                        <?php if ($laravelDetected && empty($app['config']['app.key'])): ?>
                        <li class="status-error">Execute <code>php artisan key:generate</code> para gerar APP_KEY</li>
                        <?php endif; ?>
                        
                        <?php if ($laravelDetected && isset($app['config']['app.debug']) && $app['config']['app.debug']): ?>
                        <li class="status-warning">Desative o debug mode em produção (<code>APP_DEBUG=false</code>)</li>
                        <?php endif; ?>
                        
                        <?php if ($laravelDetected && !$dbConnected): ?>
                        <li class="status-error">Verifique as credenciais do banco de dados no arquivo <code>.env</code></li>
                        <?php endif; ?>
                        
                        <?php if (!empty($missing)): ?>
                        <li class="status-error">Instale as extensões PHP faltantes: <?php echo implode(', ', $missing); ?></li>
                        <?php endif; ?>
                        
                        <?php
                        $hasPermissionIssues = false;
                        foreach ($dirs as $path) {
                            if (file_exists($path) && !is_writable($path)) {
                                $hasPermissionIssues = true;
                                break;
                            }
                        }
                        if ($hasPermissionIssues):
                        ?>
                        <li class="status-error">Corrija permissões: <code>chmod -R 775 storage bootstrap/cache</code></li>
                        <?php endif; ?>
                        
                        <?php if ($laravelDetected && $dbConnected): ?>
                        <li class="status-ok">✓ Sistema está funcionando corretamente!</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="timestamp">
            Gerado em <?php echo date('d/m/Y H:i:s'); ?> UTC
        </div>
    </div>
</body>
</html>
<?php
ob_end_flush();
?>
