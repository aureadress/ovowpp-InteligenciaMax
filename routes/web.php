<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/clear', function () {
    
    // Gerar arquivos CSS estáticos a partir do banco de dados
    if (request()->has('generate-theme-css')) {
        ob_start();
        
        echo '<!DOCTYPE html><html><head><title>Gerar CSS</title><meta charset="utf-8"></head><body style="font-family:Arial;padding:40px;background:#f5f5f5;">';
        echo '<div style="max-width:800px;margin:0 auto;background:white;padding:30px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.1);">';
        echo '<h2 style="color:#29B6F6;">🎨 Gerando Arquivos CSS Estáticos</h2>';
        
        try {
            $theme = \App\Models\ThemeSetting::active();
            
            if (!$theme) {
                throw new Exception('Nenhuma configuração de tema encontrada no banco de dados!');
            }
            
            // Chamar o controller para gerar os CSS
            $controller = new \App\Http\Controllers\Admin\ThemeSettingController();
            $reflector = new \ReflectionClass($controller);
            $method = $reflector->getMethod('generateStaticCSS');
            $method->setAccessible(true);
            $method->invoke($controller, $theme);
            
            echo '<p style="color:green;font-weight:bold;">✅ Arquivos CSS gerados com sucesso!</p>';
            echo '<ul>';
            echo '<li><code>public/assets/admin/css/theme-colors.css</code></li>';
            echo '<li><code>public/assets/templates/basic/css/theme-colors.css</code></li>';
            echo '<li><code>public/assets/templates/basic/css/frontend-colors.css</code></li>';
            echo '</ul>';
            echo '<p style="margin-top:20px;">As cores do banco de dados foram convertidas em arquivos CSS estáticos.</p>';
            echo '<a href="/admin/dashboard" style="display:inline-block;margin-top:20px;padding:12px 24px;background:#29B6F6;color:white;text-decoration:none;border-radius:8px;">✨ Ver Dashboard Admin</a>';
            echo ' ';
            echo '<a href="/" style="display:inline-block;margin-top:20px;padding:12px 24px;background:#4CAF50;color:white;text-decoration:none;border-radius:8px;">🌐 Ver Site Público</a>';
            
        } catch (Exception $e) {
            echo '<p style="color:red;">❌ Erro: ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<pre style="background:#f8f8f8;padding:15px;border-radius:8px;overflow:auto;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        }
        
        echo '</div></body></html>';
        
        return ob_get_clean();
    }
    
    // Criar Super Admin
    if (request()->has('create-super-admin')) {
        ob_start();
        
        echo '<!DOCTYPE html><html><head><title>Criar Super Admin</title><meta charset="utf-8"></head><body style="font-family:Arial;padding:40px;background:#f5f5f5;">';
        echo '<div style="max-width:900px;margin:0 auto;background:white;padding:30px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.1);">';
        echo '<h2 style="color:#29B6F6;">👤 Criar Super Admin com Todas as Permissões</h2>';
        
        try {
            // Parâmetros da URL
            $email = request()->input('email', 'superadmin@inteligenciamax.com.br');
            $password = request()->input('password', 'Admin@2025!Strong');
            $name = request()->input('name', 'Super Admin');
            $username = request()->input('username', 'superadmin');
            
            // Verificar se já existe
            $existingAdmin = \App\Models\Admin::where('email', $email)->first();
            if ($existingAdmin) {
                echo '<p style="color:orange;font-weight:bold;">⚠️ Admin já existe!</p>';
                echo '<p><strong>Email:</strong> ' . htmlspecialchars($existingAdmin->email) . '</p>';
                echo '<p><strong>Nome:</strong> ' . htmlspecialchars($existingAdmin->name) . '</p>';
                echo '<p style="margin-top:20px;">Se quiser redefinir a senha, delete o admin existente primeiro.</p>';
            } else {
                // Criar novo admin
                $admin = new \App\Models\Admin();
                $admin->name = $name;
                $admin->email = $email;
                $admin->username = $username;
                $admin->password = \Hash::make($password);
                $admin->status = 1; // Ativo
                $admin->save();
                
                echo '<p style="color:green;font-weight:bold;">✅ Super Admin criado com sucesso!</p>';
                echo '<div style="background:#f0f8ff;padding:20px;border-radius:8px;margin:20px 0;border-left:4px solid #29B6F6;">';
                echo '<h3 style="margin-top:0;color:#29B6F6;">📋 Credenciais de Acesso</h3>';
                echo '<p><strong>Email:</strong> <code style="background:#e8e8e8;padding:4px 8px;border-radius:4px;">' . htmlspecialchars($email) . '</code></p>';
                echo '<p><strong>Senha:</strong> <code style="background:#e8e8e8;padding:4px 8px;border-radius:4px;">' . htmlspecialchars($password) . '</code></p>';
                echo '<p><strong>Nome:</strong> ' . htmlspecialchars($name) . '</p>';
                echo '<p><strong>Username:</strong> ' . htmlspecialchars($username) . '</p>';
                echo '</div>';
                
                // Buscar todas as roles
                $roles = \Spatie\Permission\Models\Role::where('guard_name', 'admin')->get();
                
                if ($roles->count() > 0) {
                    echo '<h3>🎭 Atribuindo Todas as Roles/Permissões...</h3>';
                    echo '<ul>';
                    foreach ($roles as $role) {
                        $admin->assignRole($role->name);
                        echo '<li>✅ Role: <strong>' . htmlspecialchars($role->name) . '</strong></li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p style="color:orange;">⚠️ Nenhuma role encontrada no sistema.</p>';
                }
                
                // Buscar todas as permissões
                $permissions = \Spatie\Permission\Models\Permission::where('guard_name', 'admin')->get();
                
                if ($permissions->count() > 0) {
                    echo '<h3>🔑 Atribuindo Todas as Permissões...</h3>';
                    echo '<div style="max-height:300px;overflow-y:auto;background:#f8f8f8;padding:15px;border-radius:8px;">';
                    echo '<ul style="columns:2;column-gap:20px;">';
                    foreach ($permissions as $permission) {
                        $admin->givePermissionTo($permission->name);
                        echo '<li style="font-size:0.9em;">✅ ' . htmlspecialchars($permission->name) . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    echo '<p style="margin-top:15px;"><strong>Total:</strong> ' . $permissions->count() . ' permissões atribuídas</p>';
                } else {
                    echo '<p style="color:orange;">⚠️ Nenhuma permissão encontrada no sistema.</p>';
                }
            }
            
            echo '<div style="margin-top:30px;padding:20px;background:#e8f5e9;border-radius:8px;border-left:4px solid #4CAF50;">';
            echo '<h3 style="margin-top:0;color:#2e7d32;">✅ Próximos Passos</h3>';
            echo '<ol>';
            echo '<li>Faça login no painel admin com as credenciais acima</li>';
            echo '<li>O admin tem acesso total a todas as funcionalidades</li>';
            echo '<li>Pode criar outros admins, roles e permissões</li>';
            echo '<li><strong>IMPORTANTE:</strong> Mude a senha após o primeiro login!</li>';
            echo '</ol>';
            echo '</div>';
            
            echo '<div style="margin-top:20px;text-align:center;">';
            echo '<a href="/admin" style="display:inline-block;padding:15px 30px;background:#29B6F6;color:white;text-decoration:none;border-radius:8px;font-weight:bold;margin:10px;">🔐 Fazer Login</a>';
            echo '<a href="/admin/dashboard" style="display:inline-block;padding:15px 30px;background:#4CAF50;color:white;text-decoration:none;border-radius:8px;font-weight:bold;margin:10px;">📊 Ver Dashboard</a>';
            echo '</div>';
            
        } catch (Exception $e) {
            echo '<p style="color:red;font-weight:bold;">❌ Erro ao criar admin!</p>';
            echo '<p><strong>Mensagem:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<details style="margin-top:20px;">';
            echo '<summary style="cursor:pointer;color:#666;">Ver detalhes técnicos</summary>';
            echo '<pre style="background:#f8f8f8;padding:15px;border-radius:8px;overflow:auto;margin-top:10px;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
            echo '</details>';
        }
        
        echo '<div style="margin-top:30px;padding:15px;background:#fff3cd;border-radius:8px;border-left:4px solid #ffc107;">';
        echo '<h4 style="margin-top:0;color:#856404;">⚙️ Personalizar Credenciais</h4>';
        echo '<p>Você pode personalizar as credenciais adicionando parâmetros na URL:</p>';
        echo '<code style="display:block;background:#f8f8f8;padding:10px;border-radius:4px;font-size:0.85em;overflow-x:auto;">';
        echo '/clear?create-super-admin&email=seu@email.com&password=SuaSenha123&name=Seu Nome&username=seuusername';
        echo '</code>';
        echo '</div>';
        
        echo '</div></body></html>';
        
        return ob_get_clean();
    }
    
    // Criar Super User (Usuário comum com acesso total)
    if (request()->has('create-super-user')) {
        ob_start();
        
        echo '<!DOCTYPE html><html><head><title>Criar Super User</title><meta charset="utf-8"></head><body style="font-family:Arial;padding:40px;background:#f5f5f5;">';
        echo '<div style="max-width:900px;margin:0 auto;background:white;padding:30px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.1);">';
        echo '<h2 style="color:#00BCD4;">👤 Criar Super User com Acesso Total</h2>';
        
        try {
            // Parâmetros da URL
            $email = request()->input('email', 'superuser@inteligenciamax.com.br');
            $password = request()->input('password', 'User@2025!Strong');
            $firstname = request()->input('firstname', 'Super');
            $lastname = request()->input('lastname', 'User');
            $username = request()->input('username', 'superuser');
            $mobile = request()->input('mobile', '+5511999999999');
            
            // Verificar se já existe
            $existingUser = \App\Models\User::where('email', $email)->orWhere('username', $username)->first();
            if ($existingUser) {
                echo '<p style="color:orange;font-weight:bold;">⚠️ Usuário já existe!</p>';
                echo '<p><strong>Email:</strong> ' . htmlspecialchars($existingUser->email) . '</p>';
                echo '<p><strong>Username:</strong> ' . htmlspecialchars($existingUser->username) . '</p>';
                echo '<p><strong>Nome:</strong> ' . htmlspecialchars($existingUser->firstname . ' ' . $existingUser->lastname) . '</p>';
                echo '<p style="margin-top:20px;">Se quiser redefinir, delete o usuário existente primeiro.</p>';
            } else {
                // Buscar o melhor plano disponível
                $bestPlan = \App\Models\PricingPlan::where('status', 1)->orderBy('monthly_price', 'desc')->first();
                
                // Criar novo usuário
                $user = new \App\Models\User();
                $user->firstname = $firstname;
                $user->lastname = $lastname;
                $user->username = $username;
                $user->email = $email;
                $user->mobile = $mobile;
                $user->country_code = 'BR';
                $user->password = \Hash::make($password);
                $user->country_name = 'Brazil';
                $user->dial_code = '+55';
                
                // Configurações de acesso total
                $user->status = 1; // Ativo
                $user->ev = 1; // Email verificado
                $user->sv = 1; // SMS verificado
                $user->ts = 0; // 2FA desabilitado
                $user->tv = 1; // 2FA verificado
                $user->kv = 1; // KYC verificado
                
                // Configurações de saldo e plano
                $user->balance = 999999; // Saldo alto para testes
                
                if ($bestPlan) {
                    $user->plan_id = $bestPlan->id;
                    $user->plan_validity = now()->addYears(10); // Válido por 10 anos
                } else {
                    $user->plan_id = null;
                    $user->plan_validity = null;
                }
                
                $user->save();
                
                echo '<p style="color:green;font-weight:bold;">✅ Super User criado com sucesso!</p>';
                echo '<div style="background:#e0f7fa;padding:20px;border-radius:8px;margin:20px 0;border-left:4px solid #00BCD4;">';
                echo '<h3 style="margin-top:0;color:#00838F;">📋 Credenciais de Acesso</h3>';
                echo '<p><strong>Email:</strong> <code style="background:#e8e8e8;padding:4px 8px;border-radius:4px;">' . htmlspecialchars($email) . '</code></p>';
                echo '<p><strong>Username:</strong> <code style="background:#e8e8e8;padding:4px 8px;border-radius:4px;">' . htmlspecialchars($username) . '</code></p>';
                echo '<p><strong>Senha:</strong> <code style="background:#e8e8e8;padding:4px 8px;border-radius:4px;">' . htmlspecialchars($password) . '</code></p>';
                echo '<p><strong>Nome:</strong> ' . htmlspecialchars($firstname . ' ' . $lastname) . '</p>';
                echo '<p><strong>Celular:</strong> ' . htmlspecialchars($mobile) . '</p>';
                echo '</div>';
                
                echo '<h3>✅ Configurações Aplicadas:</h3>';
                echo '<div style="background:#f0f8ff;padding:15px;border-radius:8px;">';
                echo '<ul>';
                echo '<li>✅ <strong>Status:</strong> Ativo</li>';
                echo '<li>✅ <strong>Email Verificado:</strong> Sim</li>';
                echo '<li>✅ <strong>SMS Verificado:</strong> Sim</li>';
                echo '<li>✅ <strong>KYC Verificado:</strong> Sim</li>';
                echo '<li>✅ <strong>2FA:</strong> Desabilitado (para facilitar login)</li>';
                echo '<li>💰 <strong>Saldo:</strong> R$ 999.999,00</li>';
                if ($bestPlan) {
                    echo '<li>🎯 <strong>Plano:</strong> ' . htmlspecialchars($bestPlan->name) . ' (válido por 10 anos)</li>';
                } else {
                    echo '<li>⚠️ <strong>Plano:</strong> Nenhum plano encontrado no sistema</li>';
                }
                echo '</ul>';
                echo '</div>';
                
                // Criar configurações de AI se necessário
                try {
                    $aiSetting = new \App\Models\AiUserSetting();
                    $aiSetting->user_id = $user->id;
                    $aiSetting->save();
                    echo '<p style="color:green;margin-top:10px;">✅ Configurações de IA criadas</p>';
                } catch (\Exception $e) {
                    echo '<p style="color:orange;margin-top:10px;">⚠️ Configurações de IA não criadas (pode não existir na estrutura)</p>';
                }
            }
            
            echo '<div style="margin-top:30px;padding:20px;background:#e8f5e9;border-radius:8px;border-left:4px solid #4CAF50;">';
            echo '<h3 style="margin-top:0;color:#2e7d32;">✅ Próximos Passos</h3>';
            echo '<ol>';
            echo '<li>Acesse a área de login do usuário</li>';
            echo '<li>Faça login com email/username e senha</li>';
            echo '<li>Usuário tem acesso total ao dashboard</li>';
            echo '<li>Saldo de R$ 999.999,00 para testes</li>';
            echo '<li>Plano premium ativo por 10 anos</li>';
            echo '<li><strong>IMPORTANTE:</strong> Mude a senha após o primeiro login!</li>';
            echo '</ol>';
            echo '</div>';
            
            echo '<div style="margin-top:20px;text-align:center;">';
            echo '<a href="/user/login" style="display:inline-block;padding:15px 30px;background:#00BCD4;color:white;text-decoration:none;border-radius:8px;font-weight:bold;margin:10px;">🔐 Fazer Login</a>';
            echo '<a href="/user/dashboard" style="display:inline-block;padding:15px 30px;background:#4CAF50;color:white;text-decoration:none;border-radius:8px;font-weight:bold;margin:10px;">📊 Ver Dashboard</a>';
            echo '</div>';
            
        } catch (Exception $e) {
            echo '<p style="color:red;font-weight:bold;">❌ Erro ao criar usuário!</p>';
            echo '<p><strong>Mensagem:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<details style="margin-top:20px;">';
            echo '<summary style="cursor:pointer;color:#666;">Ver detalhes técnicos</summary>';
            echo '<pre style="background:#f8f8f8;padding:15px;border-radius:8px;overflow:auto;margin-top:10px;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
            echo '</details>';
        }
        
        echo '<div style="margin-top:30px;padding:15px;background:#fff3cd;border-radius:8px;border-left:4px solid #ffc107;">';
        echo '<h4 style="margin-top:0;color:#856404;">⚙️ Personalizar Credenciais</h4>';
        echo '<p>Você pode personalizar as credenciais adicionando parâmetros na URL:</p>';
        echo '<code style="display:block;background:#f8f8f8;padding:10px;border-radius:4px;font-size:0.8em;overflow-x:auto;word-wrap:break-word;">';
        echo '/clear?create-super-user&email=seu@email.com&password=SuaSenha123&firstname=Nome&lastname=Sobrenome&username=seuusername&mobile=+5511999999999';
        echo '</code>';
        echo '</div>';
        
        echo '</div></body></html>';
        
        return ob_get_clean();
    }
    
    // Forçar instalação do Frontend
    if (request()->has('force-frontend')) {
        ob_start();
        
        echo '<!DOCTYPE html><html><head><title>Instalar Frontend</title><meta charset="utf-8"></head><body style="font-family:Arial;padding:40px;background:#f5f5f5;">';
        echo '<div style="max-width:800px;margin:0 auto;background:white;padding:30px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.1);">';
        echo '<h2 style="color:#29B6F6;">🎨 Instalando Cores do Frontend</h2>';
        
        try {
            echo '<p>Executando migration...</p>';
            
            $exitCode = Artisan::call("migrate", [
                "--path" => "database/migrations/2025_10_25_000002_add_frontend_colors_to_theme_settings.php",
                "--force" => true
            ]);
            
            if ($exitCode === 0) {
                echo '<p style="color:green;font-weight:bold;">✅ Migration executada com sucesso!</p>';
                echo '<p>37 campos de cores do Frontend foram adicionados.</p>';
                echo '<a href="/admin/theme/colors" style="display:inline-block;margin-top:20px;padding:12px 24px;background:#29B6F6;color:white;text-decoration:none;border-radius:8px;">🎨 Ir para Painel de Cores</a>';
            } else {
                echo '<p style="color:red;">❌ Erro ao executar migration.</p>';
            }
        } catch (Exception $e) {
            echo '<p style="color:red;">❌ Erro: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        
        echo '</div></body></html>';
        
        return ob_get_clean();
    }
    
    // Verificar se precisa instalar tema
    if (request()->has('install-theme')) {
        
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        
        ob_start();
        
        echo '<!DOCTYPE html>
<html>
<head>
    <title>🎨 Instalação de Cores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container { 
            max-width: 900px; 
            margin: 30px auto; 
            background: white; 
            border-radius: 16px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 40px; 
            text-align: center; 
        }
        .header h1 { font-size: 2.5em; margin-bottom: 10px; }
        .content { padding: 40px; }
        .step { 
            background: #f8f9fa; 
            padding: 25px; 
            margin: 20px 0; 
            border-radius: 12px;
            border-left: 5px solid #667eea;
        }
        .step h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3em; }
        .success { background: #d4edda; border-left-color: #28a745; }
        .success h3 { color: #28a745; }
        .error { background: #f8d7da; border-left-color: #dc3545; }
        .error h3 { color: #dc3545; }
        .color-box {
            display: inline-block;
            padding: 10px 20px;
            margin: 8px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px 5px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn:hover { transform: translateY(-2px); }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎨 Instalação de Cores</h1>
            <p>Sistema de Cores Isoladas</p>
        </div>
        <div class="content">';
        
        try {
            echo '<div class="step"><h3>🔍 Verificando sistema...</h3>';
            
            $tableExists = Schema::hasTable("theme_settings");
            
            if ($tableExists) {
                // Verificar se precisa adicionar campos do Frontend
                $needsFrontend = !Schema::hasColumn('theme_settings', 'frontend_btn_primary');
                
                if ($needsFrontend) {
                    echo '<p>⚠️ Sistema instalado, adicionando cores do Frontend...</p></div>';
                    
                    echo '<div class="step"><h3>🚀 Adicionando 37 cores do Frontend...</h3>';
                    
                    $exitCode = Artisan::call("migrate", [
                        "--path" => "database/migrations/2025_10_25_000002_add_frontend_colors_to_theme_settings.php",
                        "--force" => true
                    ]);
                    
                    if ($exitCode === 0) {
                        echo '<p>✅ Cores do Frontend adicionadas!</p></div>';
                    } else {
                        throw new Exception("Erro ao adicionar cores do Frontend");
                    }
                } else {
                    echo '<p>⚠️ Sistema completamente instalado!</p></div>';
                }
                
                echo '<div class="step success"><h3>✅ Configuração Atual</h3>';
                $theme = DB::table("theme_settings")->first();
                
                if ($theme) {
                    echo '<div class="grid">';
                    echo '<div><strong>Admin:</strong><br><span class="color-box" style="background:' . $theme->admin_primary_color . '">' . $theme->admin_primary_color . '</span></div>';
                    echo '<div><strong>User:</strong><br><span class="color-box" style="background:' . $theme->user_primary_color . '">' . $theme->user_primary_color . '</span></div>';
                    echo '<div><strong>Chat:</strong><br><span class="color-box" style="background:' . $theme->chat_primary_color . '">' . $theme->chat_primary_color . '</span></div>';
                    echo '</div>';
                }
                echo '</div>';
                
            } else {
                echo '<p>✅ Instalando...</p></div>';
                
                echo '<div class="step"><h3>🚀 Instalando sistema de cores...</h3>';
                
                // Executar ambas as migrations
                $exitCode1 = Artisan::call("migrate", [
                    "--path" => "database/migrations/2025_10_25_000001_create_theme_settings_table.php",
                    "--force" => true
                ]);
                
                $exitCode2 = Artisan::call("migrate", [
                    "--path" => "database/migrations/2025_10_25_000002_add_frontend_colors_to_theme_settings.php",
                    "--force" => true
                ]);
                
                $exitCode = ($exitCode1 === 0 && $exitCode2 === 0) ? 0 : 1;
                
                if ($exitCode === 0) {
                    echo '<p>✅ Instalado com sucesso!</p></div>';
                    
                    echo '<div class="step success"><h3>✅ Cores Instaladas</h3>';
                    $theme = DB::table("theme_settings")->first();
                    
                    if ($theme) {
                        echo '<div class="grid">';
                        echo '<div><strong>🔵 Admin:</strong><br><span class="color-box" style="background:' . $theme->admin_primary_color . '">' . $theme->admin_primary_color . '</span></div>';
                        echo '<div><strong>🟢 User:</strong><br><span class="color-box" style="background:' . $theme->user_primary_color . '">' . $theme->user_primary_color . '</span></div>';
                        echo '<div><strong>💬 Chat:</strong><br><span class="color-box" style="background:' . $theme->chat_primary_color . '">' . $theme->chat_primary_color . '</span></div>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    throw new Exception("Erro na instalação");
                }
            }
            
            echo '<div class="step success"><h3>🎉 Concluído!</h3>';
            echo '<p><strong>Próximo passo:</strong></p>';
            echo '<a href="/admin/theme/colors" class="btn">🎨 Abrir Painel de Cores</a>';
            echo '</div>';
            
        } catch (Exception $e) {
            echo '<div class="step error"><h3>❌ Erro</h3>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p></div>';
        }
        
        echo '</div></div></body></html>';
        
        return ob_get_clean();
    }
    
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return "Cache cleared successfully!";
});

// Rota para instalar sistema de cores
Route::get('/instalar-cores', function () {
    ob_start();
    
    echo '<!DOCTYPE html>
<html>
<head>
    <title>🎨 Instalação de Cores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container { 
            max-width: 900px; 
            margin: 30px auto; 
            background: white; 
            border-radius: 16px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 40px; 
            text-align: center; 
        }
        .header h1 { font-size: 2.5em; margin-bottom: 10px; }
        .header p { opacity: 0.9; font-size: 1.1em; }
        .content { padding: 40px; }
        .step { 
            background: #f8f9fa; 
            padding: 25px; 
            margin: 20px 0; 
            border-radius: 12px;
            border-left: 5px solid #667eea;
        }
        .step h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3em; }
        .step p { line-height: 1.6; color: #495057; }
        .success { 
            background: #d4edda; 
            border-left-color: #28a745; 
        }
        .success h3 { color: #28a745; }
        .error { 
            background: #f8d7da; 
            border-left-color: #dc3545;
        }
        .error h3 { color: #dc3545; }
        .warning { 
            background: #fff3cd; 
            border-left-color: #ffc107;
            padding: 25px;
            margin: 25px 0;
            border-radius: 12px;
        }
        .warning h3 { color: #856404; margin-bottom: 15px; }
        .color-box {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }
        .btn:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }
        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
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
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎨 Instalação de Cores</h1>
            <p>Sistema de Cores Isoladas para Admin / User / Chat</p>
        </div>
        <div class="content">';
    
    try {
        // Passo 1: Verificar tabela
        echo '<div class="step"><h3>🔍 Passo 1: Verificando sistema...</h3>';
        
        $tableExists = Schema::hasTable("theme_settings");
        
        if ($tableExists) {
            echo '<p>⚠️ Tabela <strong>theme_settings</strong> já existe!</p>';
            echo '</div>';
            
            // Mostrar configuração atual
            echo '<div class="step success"><h3>✅ Configuração Atual</h3>';
            $theme = DB::table("theme_settings")->first();
            
            if ($theme) {
                echo '<div class="grid">';
                echo '<div><strong>Admin Primary:</strong><br><span class="color-box" style="background:' . $theme->admin_primary_color . '">' . $theme->admin_primary_color . '</span></div>';
                echo '<div><strong>User Primary:</strong><br><span class="color-box" style="background:' . $theme->user_primary_color . '">' . $theme->user_primary_color . '</span></div>';
                echo '<div><strong>Chat Primary:</strong><br><span class="color-box" style="background:' . $theme->chat_primary_color . '">' . $theme->chat_primary_color . '</span></div>';
                echo '</div>';
            }
            echo '</div>';
            
        } else {
            echo '<p>✅ Sistema pronto para instalação.</p></div>';
            
            // Passo 2: Executar migration
            echo '<div class="step"><h3>🚀 Passo 2: Instalando sistema de cores...</h3>';
            echo '<div class="loader"></div>';
            
            $exitCode = Artisan::call("migrate", [
                "--path" => "database/migrations/2025_10_25_000001_create_theme_settings_table.php",
                "--force" => true
            ]);
            
            if ($exitCode === 0) {
                echo '<p>✅ Instalação concluída com sucesso!</p></div>';
                
                // Verificar dados
                echo '<div class="step success"><h3>✅ Passo 3: Cores Instaladas</h3>';
                $theme = DB::table("theme_settings")->first();
                
                if ($theme) {
                    echo '<p><strong>Sistema instalado com as seguintes cores padrão:</strong></p>';
                    echo '<div class="grid">';
                    echo '<div><strong>🔵 Admin Primary:</strong><br><span class="color-box" style="background:' . $theme->admin_primary_color . '">' . $theme->admin_primary_color . '</span></div>';
                    echo '<div><strong>🔵 Admin Secondary:</strong><br><span class="color-box" style="background:' . $theme->admin_secondary_color . '">' . $theme->admin_secondary_color . '</span></div>';
                    echo '<div><strong>🟢 User Primary:</strong><br><span class="color-box" style="background:' . $theme->user_primary_color . '">' . $theme->user_primary_color . '</span></div>';
                    echo '<div><strong>🟢 User Secondary:</strong><br><span class="color-box" style="background:' . $theme->user_secondary_color . '">' . $theme->user_secondary_color . '</span></div>';
                    echo '<div><strong>💬 Chat Primary:</strong><br><span class="color-box" style="background:' . $theme->chat_primary_color . '">' . $theme->chat_primary_color . '</span></div>';
                    echo '<div><strong>💬 Chat Sent:</strong><br><span class="color-box" style="background:' . $theme->chat_bubble_sent . ';color:#000">' . $theme->chat_bubble_sent . '</span></div>';
                    echo '</div>';
                }
                echo '</div>';
                
            } else {
                throw new Exception("Falha na instalação");
            }
        }
        
        // Próximos passos
        echo '<div class="step success"><h3>🎉 Instalação Completa!</h3>';
        echo '<p><strong>Próximos passos:</strong></p>';
        echo '<ol style="margin: 15px 0; padding-left: 25px; line-height: 2;">';
        echo '<li>Acesse o painel de cores: <a href="/admin/theme/colors" style="color:#667eea;font-weight:bold;">/admin/theme/colors</a></li>';
        echo '<li>Configure as cores para cada área (Admin, User, Chat)</li>';
        echo '<li>Salve as alterações</li>';
        echo '</ol>';
        echo '<a href="/admin/theme/colors" class="btn">🎨 Ir para Painel de Cores</a>';
        echo '</div>';
        
        // Aviso
        echo '<div class="warning">';
        echo '<h3>📌 Informação Importante</h3>';
        echo '<p>Esta rota (<strong>/instalar-cores</strong>) pode ser removida após a instalação por questões de segurança.</p>';
        echo '<p style="margin-top:10px;">Para remover, comente a rota no arquivo <code>routes/web.php</code>.</p>';
        echo '</div>';
        
    } catch (Exception $e) {
        echo '<div class="step error"><h3>❌ Erro na Instalação</h3>';
        echo '<p><strong>Erro:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<pre style="background:#2d2d2d;color:#fff;padding:15px;border-radius:8px;overflow-x:auto;margin-top:15px;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        echo '</div>';
    }
    
    echo '
        </div>
    </div>
</body>
</html>';
    
    return ob_get_clean();
})->name('install.theme.colors');

Route::get('/criar-usuario-teste', function () {
    try {
        // RESETAR SENHA DO USUÁRIO ID 1 (Ana Teste)
        $password = \Illuminate\Support\Facades\Hash::make('admin');
        
        \Illuminate\Support\Facades\DB::table('users')
            ->where('id', 1)
            ->update([
                'password' => $password,
                'status' => 1,
                'ev' => 1,
                'sv' => 1,
                'ts' => 0,
                'tv' => 1,
                'updated_at' => now()
            ]);
        
        // Pegar dados atualizados
        $user = \Illuminate\Support\Facades\DB::table('users')->where('id', 1)->first();
        $msg = 'Senha resetada com sucesso!';
        
        return '<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>✅ Sucesso!</title>
<style>
body{font-family:Arial,sans-serif;background:linear-gradient(135deg,#29B6F6 0%,#039BE5 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0;padding:20px}
.box{background:#fff;padding:40px;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.3);max-width:600px;text-align:center}
h1{color:#29B6F6;font-size:48px;margin:20px 0}
.msg{background:#e8f5e9;color:#2e7d32;padding:20px;border-radius:10px;margin:20px 0;border-left:5px solid #4caf50}
.cred{background:#f5f5f5;padding:20px;border-radius:10px;margin:20px 0;text-align:left}
.cred div{margin:10px 0;padding:10px;background:#fff;border-radius:5px}
.btn{display:inline-block;background:linear-gradient(135deg,#29B6F6 0%,#039BE5 100%);color:#fff;padding:15px 30px;text-decoration:none;border-radius:10px;font-weight:bold;margin:10px;transition:all 0.3s}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(41,182,246,0.5)}
code{background:#2c3e50;color:#fff;padding:2px 8px;border-radius:4px;font-family:monospace}
</style></head><body>
<div class="box">
<h1>✅</h1>
<div class="msg"><strong>' . $msg . '</strong></div>
<div class="cred">
<h3 style="color:#29B6F6;margin-bottom:15px">🔐 Credenciais de Acesso:</h3>
<div><strong>URL:</strong> <code>https://inteligenciamax.com.br/user/login</code></div>
<div><strong>Usuário:</strong> <code>cliente</code></div>
<div><strong>Email:</strong> <code>cliente@teste.com</code></div>
<div><strong>Senha:</strong> <code>admin</code></div>
</div>
<a href="/user/login" class="btn">🚀 Fazer Login Agora!</a>
</div></body></html>';
        
    } catch (\Exception $e) {
        return '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>❌ Erro</title>
<style>body{font-family:Arial;background:#f44336;color:#fff;padding:40px;text-align:center}
.box{background:#fff;color:#c62828;padding:40px;border-radius:20px;max-width:600px;margin:0 auto}</style>
</head><body><div class="box"><h1>❌ Erro!</h1><p>' . htmlspecialchars($e->getMessage()) . '</p></div></body></html>';
    }
});

Route::get('cron', 'CronController@cron')->name('cron');
Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::controller('WebhookController')->group(function () {
    Route::get('/webhook', 'webhookConnect')->name('webhook');
    Route::post('/webhook', 'webhookResponse');
});

Route::controller('SiteController')->group(function () {

    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blogs', 'blogs')->name('blogs');
    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');

    Route::get('/pricing', 'pricing')->name('pricing');

    Route::get('/features', 'features')->name('features');

    Route::get('wl/{code}', 'redirectShortLink')->name('short.link.redirect');

    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');

    Route::post('subscribe', 'subscribe')->name('subscribe');
});

Route::controller('PusherController')->group(function () {
    Route::post('pusher/auth', 'authenticationApp');
    Route::post('pusher/auth/{socketId}/{channelName}', 'authentication');
});
