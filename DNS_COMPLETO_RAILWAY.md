# 🌐 Configuração DNS Completa - Railway + Registro.br

## ⚠️ IMPORTANTE: Domínio Raiz vs WWW

**São registros DNS DIFERENTES!**

- `inteligenciamax.com.br` (domínio raiz/apex) ≠ `www.inteligenciamax.com.br` (subdomínio)
- Se configurar apenas `www`, o domínio sem `www` **NÃO vai funcionar**
- Você precisa configurar **AMBOS** para garantir acesso completo

---

## 📋 Configuração no Registro.br (Obrigatória)

### Passo 1: Acessar o Registro.br

1. Acesse: https://registro.br
2. Faça login com sua conta
3. Vá em **"Meus Domínios"**
4. Clique em `inteligenciamax.com.br`
5. Selecione **"Editar Zona DNS"** ou **"Configuração de DNS"**

### Passo 2: Adicionar Ambos os Registros CNAME

Adicione **DOIS registros CNAME**:

```
┌─────────────────────────────────────────────────────┐
│  TIPO    │  NOME    │  VALOR                        │
├─────────────────────────────────────────────────────┤
│  CNAME   │  www     │  ikz4ue6o.up.railway.app.     │
│  CNAME   │  @       │  ikz4ue6o.up.railway.app.     │
└─────────────────────────────────────────────────────┘
```

**Onde:**
- `@` = domínio raiz (inteligenciamax.com.br)
- `www` = subdomínio www (www.inteligenciamax.com.br)
- `ikz4ue6o.up.railway.app.` = seu domínio Railway (não esquecer o ponto final!)

### ⚠️ Observação Importante

Alguns painéis do Registro.br podem exigir o nome completo ao invés de `@`:

```
CNAME   inteligenciamax.com.br      ikz4ue6o.up.railway.app.
CNAME   www.inteligenciamax.com.br  ikz4ue6o.up.railway.app.
```

---

## 🚀 Configuração no Railway (Obrigatória)

### Passo 1: Adicionar Domínios Personalizados

1. Acesse: https://railway.app
2. Selecione seu projeto **OvoWpp - Inteligência MAX**
3. Vá em **Settings** → **Domains**
4. Clique em **"+ Custom Domain"**

### Passo 2: Adicionar AMBOS os Domínios

Adicione **dois domínios personalizados**:

```
1. inteligenciamax.com.br
2. www.inteligenciamax.com.br
```

⚠️ Railway vai mostrar o CNAME necessário para cada um. Anote esses valores!

---

## 🔄 Redirecionamento WWW ↔ Não-WWW

### Opção 1: Redirecionamento via Laravel (Middleware)

Crie um middleware para redirecionar automaticamente:

**Para sempre usar WWW:**
```php
// app/Http/Middleware/ForceWWW.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceWWW
{
    public function handle(Request $request, Closure $next)
    {
        if (!str_starts_with($request->getHost(), 'www.') && app()->environment('production')) {
            return redirect()->to('https://www.' . $request->getHttpHost() . $request->getRequestUri(), 301);
        }
        
        return $next($request);
    }
}
```

**Para sempre usar SEM WWW:**
```php
// app/Http/Middleware/RemoveWWW.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveWWW
{
    public function handle(Request $request, Closure $next)
    {
        if (str_starts_with($request->getHost(), 'www.') && app()->environment('production')) {
            $host = substr($request->getHost(), 4); // Remove 'www.'
            return redirect()->to('https://' . $host . $request->getRequestUri(), 301);
        }
        
        return $next($request);
    }
}
```

**Registrar no `app/Http/Kernel.php`:**
```php
protected $middleware = [
    // ... outros middlewares
    \App\Http\Middleware\ForceWWW::class, // OU
    \App\Http\Middleware\RemoveWWW::class, // Escolha apenas UM
];
```

### Opção 2: Redirecionamento via .htaccess (se usar Apache)

**Para sempre usar WWW:**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_HOST} !^www\. [NC]
    RewriteRule ^(.*)$ https://www.%{HTTP_HOST}/$1 [R=301,L]
</IfModule>
```

**Para sempre usar SEM WWW:**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
    RewriteRule ^(.*)$ https://%1/$1 [R=301,L]
</IfModule>
```

---

## ✅ Checklist de Verificação

Após configurar, verifique:

### 1. DNS Propagado (use: https://dnschecker.org)

```bash
# Verificar domínio raiz
CNAME: inteligenciamax.com.br → ikz4ue6o.up.railway.app

# Verificar www
CNAME: www.inteligenciamax.com.br → ikz4ue6o.up.railway.app
```

### 2. Railway Configurado

- [ ] Domínio `inteligenciamax.com.br` adicionado
- [ ] Domínio `www.inteligenciamax.com.br` adicionado
- [ ] Certificado SSL gerado automaticamente
- [ ] Status "Active" em ambos

### 3. Teste de Acesso

```bash
# Testar domínio raiz
curl -I https://inteligenciamax.com.br

# Testar www
curl -I https://www.inteligenciamax.com.br

# Ambos devem retornar HTTP 200 ou 301/302 (se houver redirect)
```

### 4. Variáveis de Ambiente Railway

Atualize no Railway:

```env
APP_URL=https://www.inteligenciamax.com.br
# OU (se preferir sem www)
APP_URL=https://inteligenciamax.com.br
```

---

## 🔧 Troubleshooting

### Problema: "DNS_PROBE_FINISHED_NXDOMAIN"

**Causa:** DNS ainda não propagado ou mal configurado

**Solução:**
1. Aguarde 24-48h para propagação completa
2. Verifique se os registros CNAME estão corretos no Registro.br
3. Use https://dnschecker.org para verificar propagação global

### Problema: "Certificate Error / SSL Invalid"

**Causa:** Railway ainda não gerou o certificado SSL

**Solução:**
1. Aguarde até 10 minutos após adicionar domínio no Railway
2. Verifique status em Railway → Settings → Domains
3. Se persistir, remova e adicione o domínio novamente

### Problema: Um domínio funciona, outro não

**Causa:** Configurou apenas um dos registros CNAME

**Solução:**
- Adicione **AMBOS** os registros no Registro.br:
  - `@` ou `inteligenciamax.com.br`
  - `www` ou `www.inteligenciamax.com.br`
- Adicione **AMBOS** os domínios no Railway

---

## 📊 Recomendação: WWW ou Não-WWW?

### ✅ Recomendado: **COM WWW** (`www.inteligenciamax.com.br`)

**Vantagens:**
- ✅ Melhor para CDN e cache
- ✅ Flexibilidade para subdominios
- ✅ Separação clara entre diferentes serviços
- ✅ Padrão mais tradicional e reconhecido

### ⚠️ Alternativa: **SEM WWW** (`inteligenciamax.com.br`)

**Vantagens:**
- ✅ URL mais curta e limpa
- ✅ Mais moderno
- ✅ Economia de caracteres

**Escolha um e redirecione o outro com 301!**

---

## 🎯 Configuração Final Recomendada

1. **Registro.br:**
   - CNAME `@` → `ikz4ue6o.up.railway.app.`
   - CNAME `www` → `ikz4ue6o.up.railway.app.`

2. **Railway:**
   - Adicionar `inteligenciamax.com.br`
   - Adicionar `www.inteligenciamax.com.br`

3. **Laravel:**
   - Instalar middleware de redirecionamento
   - Escolher: sempre WWW ou sempre sem WWW
   - Configurar `APP_URL` no `.env`

4. **Resultado:**
   - `inteligenciamax.com.br` → redireciona para `www.inteligenciamax.com.br` (301)
   - `www.inteligenciamax.com.br` → site principal (200)

---

## 📞 Suporte

**Registro.br:** https://registro.br/suporte  
**Railway Docs:** https://docs.railway.app/deploy/custom-domains  
**DNS Checker:** https://dnschecker.org

---

✅ **Após seguir este guia, ambos os domínios funcionarão corretamente!**
