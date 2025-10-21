# ✅ CONFIGURADO: Usar SEM WWW - inteligenciamax.com.br

## 🎯 Domínio Principal

O site agora está configurado para usar **SEM WWW**:

```
✅ inteligenciamax.com.br           ← Domínio principal
↩️  www.inteligenciamax.com.br      ← Redireciona para inteligenciamax.com.br
```

---

## ✅ O QUE FOI CONFIGURADO

### 1. Middleware Ativado: **RemoveWWW**

**Arquivo:** `bootstrap/app.php`

```php
use App\Http\Middleware\RemoveWWW;

// ...

$middleware->append(RemoveWWW::class);
```

**O que faz:**
- Remove automaticamente o `www.` de qualquer URL
- Redirect 301 (permanente, bom para SEO)
- Exemplo: `www.inteligenciamax.com.br` → `inteligenciamax.com.br`

### 2. APP_URL Configurado

**Arquivo:** `.env`

```env
APP_URL=https://inteligenciamax.com.br
```

---

## 📋 CONFIGURAÇÃO DNS NECESSÁRIA

### No Railway (PRIMEIRO):

1. **Acesse:** https://railway.app
2. **Vá em:** Settings → Domains → + Custom Domain

**Adicione AMBOS os domínios:**

```
1. inteligenciamax.com.br
   → Railway mostrará: Add A record with value: XXX.XXX.XXX.XXX
   → ANOTE ESSE IP!

2. www.inteligenciamax.com.br  
   → Railway mostrará: Add CNAME to: ikz4ue6o.up.railway.app
```

### No Registro.br (DEPOIS):

**Configure dois registros:**

```
┌─────────────────────────────────────────────────────┐
│  TIPO    │  NOME    │  VALOR                        │
├─────────────────────────────────────────────────────┤
│  A       │  @       │  XXX.XXX.XXX.XXX              │ ← IP do Railway
│  CNAME   │  www     │  ikz4ue6o.up.railway.app.     │
└─────────────────────────────────────────────────────┘
```

**⚠️ Importante:**
- Mesmo removendo o www, você PRECISA configurar ambos os registros
- O middleware RemoveWWW vai redirecionar www automaticamente

---

## 🔄 Como Funciona

### Cenário 1: Usuário digita `inteligenciamax.com.br`
```
1. DNS resolve via A record → IP do Railway
2. Railway roteia para aplicação
3. Aplicação carrega normalmente
✅ URL permanece: inteligenciamax.com.br
```

### Cenário 2: Usuário digita `www.inteligenciamax.com.br`
```
1. DNS resolve via CNAME → Railway
2. Railway roteia para aplicação
3. Middleware RemoveWWW detecta "www."
4. Redirect 301 → inteligenciamax.com.br
✅ URL final: inteligenciamax.com.br
```

---

## 🧪 Testes Após Configurar

### Teste 1: Domínio Principal
```bash
# Abrir navegador
https://inteligenciamax.com.br

# Esperado: Site carrega normalmente
# URL permanece: inteligenciamax.com.br
```

### Teste 2: WWW (deve redirecionar)
```bash
# Abrir navegador
https://www.inteligenciamax.com.br

# Esperado: Redirect 301
# URL final: inteligenciamax.com.br
```

### Teste 3: Verificar Redirect
```bash
# Via curl (terminal)
curl -I https://www.inteligenciamax.com.br

# Esperado:
# HTTP/2 301
# Location: https://inteligenciamax.com.br/
```

---

## ⚙️ Variáveis de Ambiente Railway

No Railway Dashboard, configure:

```env
APP_NAME="Inteligência MAX"
APP_ENV=production
APP_KEY=base64:0W7PEDs49N/eRVf4MgHcA+/f0f1ADrwuZZrURE+VD3o=
APP_DEBUG=false
APP_URL=https://inteligenciamax.com.br

DB_CONNECTION=mysql
DB_HOST=metro.proxy.rlwy.net
DB_PORT=37078
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=ScZRjMeixWGFsfnbORMNCUxTCERaVbIq

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1
```

**⚠️ Importante:** Depois de atualizar, faça **Redeploy**!

---

## ✅ Checklist de Configuração

- [x] ✅ Middleware RemoveWWW ativado em `bootstrap/app.php`
- [x] ✅ APP_URL definido como `https://inteligenciamax.com.br`
- [ ] ⏳ Adicionar `inteligenciamax.com.br` no Railway
- [ ] ⏳ Adicionar `www.inteligenciamax.com.br` no Railway
- [ ] ⏳ Anotar IP fornecido pelo Railway
- [ ] ⏳ Configurar registro A no Registro.br
- [ ] ⏳ Configurar registro CNAME no Registro.br
- [ ] ⏳ Atualizar APP_URL no Railway
- [ ] ⏳ Fazer Redeploy no Railway
- [ ] ⏳ Aguardar propagação DNS (2-48h)
- [ ] ⏳ Testar ambos os domínios

---

## 🔄 Voltar para WWW (Se Mudar de Ideia)

Se quiser voltar a usar `www.inteligenciamax.com.br`:

### 1. Editar `bootstrap/app.php`

Trocar:
```php
use App\Http\Middleware\RemoveWWW;
// ...
$middleware->append(RemoveWWW::class);
```

Por:
```php
use App\Http\Middleware\ForceWWW;
// ...
$middleware->append(ForceWWW::class);
```

### 2. Atualizar .env

```env
APP_URL=https://www.inteligenciamax.com.br
```

### 3. Fazer Commit e Deploy

```bash
git add bootstrap/app.php .env
git commit -m "chore: Change to use www subdomain"
git push origin genspark_ai_developer
```

---

## 📊 Comparação: WWW vs Não-WWW

### ✅ SEM WWW (Configuração Atual)

**Vantagens:**
- URL mais curta e limpa
- Mais moderno
- Menos caracteres para digitar
- Visual mais clean

**Desvantagens:**
- Menos flexível para CDN
- Menos separação de serviços

### WWW

**Vantagens:**
- Melhor para CDN e cache
- Mais flexível para subdominios
- Separação clara entre serviços
- Padrão tradicional

**Desvantagens:**
- URL mais longa
- Menos moderno

---

## 🔗 Links Úteis

- **Railway Dashboard:** https://railway.app
- **Registro.br:** https://registro.br
- **DNS Checker:** https://dnschecker.org
- **Pull Request:** https://github.com/aureadress/ovowpp-InteligenciaMax/pull/2

---

## 📝 Próximos Passos

1. **Acesse Railway:** https://railway.app
2. **Adicione os domínios** (ambos @ e www)
3. **Anote o IP** que Railway mostrar
4. **Configure DNS** no Registro.br
5. **Atualize APP_URL** nas variáveis do Railway para `https://inteligenciamax.com.br`
6. **Faça Redeploy**
7. **Aguarde** propagação (2-48h)
8. **Teste** o site!

---

✅ **Código configurado para usar SEM WWW!**  
🚀 **Pronto para deploy após configurar DNS!**  
📋 **Middleware RemoveWWW ativo e funcionando!**

---

**Resultado Final:**

```
www.inteligenciamax.com.br   → [Redirect 301] → inteligenciamax.com.br ✅
inteligenciamax.com.br       → Site principal ✅
```
