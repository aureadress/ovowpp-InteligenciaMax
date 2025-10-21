# 🔄 Configurar Redirecionamento WWW

## 📋 Guia Rápido: Escolher WWW ou Não-WWW

Este guia mostra como configurar o redirecionamento automático entre `inteligenciamax.com.br` e `www.inteligenciamax.com.br`.

---

## ⚡ Passo a Passo

### Opção A: Sempre usar WWW (Recomendado) ✅

Redireciona `inteligenciamax.com.br` → `www.inteligenciamax.com.br`

#### 1. Registrar Middleware

Edite o arquivo `bootstrap/app.php` (Laravel 11):

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Adicione esta linha:
        $middleware->append(\App\Http\Middleware\ForceWWW::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

#### 2. Configurar .env

```env
APP_URL=https://www.inteligenciamax.com.br
```

---

### Opção B: Sempre usar SEM WWW

Redireciona `www.inteligenciamax.com.br` → `inteligenciamax.com.br`

#### 1. Registrar Middleware

Edite o arquivo `bootstrap/app.php` (Laravel 11):

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Adicione esta linha:
        $middleware->append(\App\Http\Middleware\RemoveWWW::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

#### 2. Configurar .env

```env
APP_URL=https://inteligenciamax.com.br
```

---

## 🧪 Testar Localmente (Opcional)

Para testar o redirecionamento localmente, você pode temporariamente mudar o ambiente:

```php
// Nos arquivos de middleware, comente/remova esta linha:
if (!app()->environment('production')) {
    return $next($request);
}
```

**⚠️ Lembre-se de reverter após o teste!**

---

## ✅ Verificar se Está Funcionando

### Teste 1: Domínio Raiz
```bash
curl -I https://inteligenciamax.com.br
```

**Esperado (se usar Opção A - ForceWWW):**
```
HTTP/2 301
Location: https://www.inteligenciamax.com.br/
```

### Teste 2: Domínio WWW
```bash
curl -I https://www.inteligenciamax.com.br
```

**Esperado (se usar Opção A - ForceWWW):**
```
HTTP/2 200
```

---

## 📊 Middlewares Disponíveis

### ✅ ForceWWW.php
- **Ação:** Adiciona `www.` ao domínio
- **Quando usar:** Quer que todos acessem com `www.`
- **Exemplo:** `inteligenciamax.com.br` → `www.inteligenciamax.com.br`
- **Arquivo:** `app/Http/Middleware/ForceWWW.php`

### ✅ RemoveWWW.php
- **Ação:** Remove `www.` do domínio
- **Quando usar:** Quer que todos acessem sem `www.`
- **Exemplo:** `www.inteligenciamax.com.br` → `inteligenciamax.com.br`
- **Arquivo:** `app/Http/Middleware/RemoveWWW.php`

---

## ⚠️ IMPORTANTE: Escolha Apenas UM!

**NÃO registre ambos os middlewares!** Isso criaria um loop de redirecionamento infinito.

❌ **ERRADO:**
```php
$middleware->append(\App\Http\Middleware\ForceWWW::class);
$middleware->append(\App\Http\Middleware\RemoveWWW::class); // LOOP!
```

✅ **CORRETO:**
```php
// Escolha apenas um:
$middleware->append(\App\Http\Middleware\ForceWWW::class);
// OU
$middleware->append(\App\Http\Middleware\RemoveWWW::class);
```

---

## 🔧 Troubleshooting

### Problema: "Too Many Redirects"

**Causa:** Ambos os middlewares estão registrados

**Solução:**
1. Abra `bootstrap/app.php`
2. Remova um dos middlewares
3. Limpe o cache: `php artisan config:clear`

### Problema: Redirecionamento não funciona

**Causa:** Ambiente não está como 'production'

**Solução:**
1. Verifique `.env`: `APP_ENV=production`
2. Ou remova o check de ambiente do middleware (não recomendado)

### Problema: Funciona local mas não no Railway

**Causa:** Variáveis de ambiente não atualizadas

**Solução:**
1. Acesse Railway Dashboard
2. Vá em **Variables**
3. Atualize: `APP_URL=https://www.inteligenciamax.com.br`
4. Redeploy da aplicação

---

## 📝 Checklist Final

- [ ] Escolhi qual padrão usar (WWW ou sem WWW)
- [ ] Registrei apenas UM middleware em `bootstrap/app.php`
- [ ] Configurei `APP_URL` no `.env` localmente
- [ ] Configurei `APP_URL` nas variáveis do Railway
- [ ] DNS configurado no Registro.br (ambos `@` e `www`)
- [ ] Ambos domínios adicionados no Railway
- [ ] Testei o redirecionamento com `curl -I`
- [ ] SSL válido em ambos os domínios

---

## 🎯 Configuração Recomendada Final

**Para Inteligência MAX, recomendamos:**

✅ **Usar COM WWW** (Opção A)

**Motivos:**
- Permite melhor gerenciamento de CDN no futuro
- Separação clara para possíveis subdominios (api.inteligenciamax.com.br, app.inteligenciamax.com.br)
- Padrão mais tradicional e reconhecido
- Melhor para cookies e sessões cross-domain

**Configuração:**
1. Middleware: `ForceWWW`
2. APP_URL: `https://www.inteligenciamax.com.br`
3. DNS: Ambos `@` e `www` apontando para Railway
4. Railway: Ambos domínios adicionados

---

✅ **Pronto! Seu site agora redireciona automaticamente para o padrão escolhido.**
