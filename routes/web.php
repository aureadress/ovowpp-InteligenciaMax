<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('/criar-usuario-teste', function () {
    try {
        $username = 'cliente';
        $email = 'cliente@teste.com';
        $password = \Illuminate\Support\Facades\Hash::make('admin');
        
        // Verificar se usuário existe
        $user = \Illuminate\Support\Facades\DB::table('users')
            ->where('username', $username)
            ->orWhere('email', $email)
            ->first();
        
        if ($user) {
            // Atualizar existente
            \Illuminate\Support\Facades\DB::table('users')
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
            $msg = 'Usuário ATUALIZADO com sucesso!';
        } else {
            // Criar novo
            \Illuminate\Support\Facades\DB::table('users')->insert([
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
            $msg = 'Usuário CRIADO com sucesso!';
        }
        
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
