# ⚡ RESUMO: Configuração WWW - Inteligência MAX

## 🎯 Objetivo
Garantir que ambos os domínios funcionem e que haja redirecionamento automático para a versão preferida.

---

## ✅ O que foi configurado

### 1. Middlewares Criados

✅ **ForceWWW.php** - Redireciona para `www.inteligenciamax.com.br`  
✅ **RemoveWWW.php** - Redireciona para `inteligenciamax.com.br`

**Localização:** `app/Http/Middleware/`

### 2. Middleware Ativado

✅ **ForceWWW** já está registrado em `bootstrap/app.php`  
→ Isso significa que `inteligenciamax.com.br` → `www.inteligenciamax.com.br`

### 3. Documentação Criada

✅ `DNS_COMPLETO_RAILWAY.md` - Guia completo de DNS  
✅ `CONFIGURAR_WWW_REDIRECT.md` - Guia de configuração de redirecionamento  
✅ `RESUMO_CONFIGURACAO_WWW.md` - Este arquivo

---

## 📋 O QUE VOCÊ PRECISA FAZER AGORA

### Passo 1: Configurar DNS no Registro.br ⚠️ OBRIGATÓRIO

Acesse https://registro.br e adicione **DOIS** registros CNAME:

```
TIPO    NOME    VALOR
────────────────────────────────────────────
CNAME   @       ikz4ue6o.up.railway.app.
CNAME   www     ikz4ue6o.up.railway.app.
```

**Importante:**
- `@` = domínio raiz (inteligenciamax.com.br)
- `www` = subdomínio www (www.inteligenciamax.com.br)
- Não esqueça o ponto final no valor: `ikz4ue6o.up.railway.app.`

### Passo 2: Adicionar Domínios no Railway ⚠️ OBRIGATÓRIO

1. Acesse https://railway.app
2. Selecione seu projeto
3. Vá em **Settings** → **Domains**
4. Adicione **ambos** os domínios:
   - `inteligenciamax.com.br`
   - `www.inteligenciamax.com.br`

### Passo 3: Atualizar Variável de Ambiente no Railway

No Railway, vá em **Variables** e configure:

```env
APP_URL=https://www.inteligenciamax.com.br
APP_ENV=production
```

Depois, faça **Redeploy** da aplicação.

---

## 🔍 Como Verificar se Está Funcionando

### Teste 1: Verificar DNS (após 2-24h)
Acesse: https://dnschecker.org

Pesquise:
- `inteligenciamax.com.br` - Deve retornar CNAME para Railway
- `www.inteligenciamax.com.br` - Deve retornar CNAME para Railway

### Teste 2: Testar Redirecionamento

**Abra o navegador em modo anônimo:**

1. Digite: `http://inteligenciamax.com.br`
   - Deve redirecionar para: `https://www.inteligenciamax.com.br`

2. Digite: `https://inteligenciamax.com.br`
   - Deve redirecionar para: `https://www.inteligenciamax.com.br`

3. Digite: `https://www.inteligenciamax.com.br`
   - Deve permanecer em: `https://www.inteligenciamax.com.br` (sem redirecionar)

---

## ⚙️ Como Mudar de WWW para Não-WWW (Se quiser)

Se preferir usar **sem WWW** (inteligenciamax.com.br):

### 1. Editar `bootstrap/app.php`

Procure por:
```php
$middleware->append(ForceWWW::class);
```

Substitua por:
```php
$middleware->append(RemoveWWW::class);
```

### 2. Adicionar o import

No início do arquivo, adicione:
```php
use App\Http\Middleware\RemoveWWW;
```

### 3. Atualizar APP_URL

No Railway, altere:
```env
APP_URL=https://inteligenciamax.com.br
```

### 4. Fazer Commit e Push

```bash
git add bootstrap/app.php
git commit -m "chore: Change redirect to non-www domain"
git push origin genspark_ai_developer
```

---

## 🚨 Problemas Comuns

### DNS não resolve
**Causa:** DNS ainda não propagou  
**Solução:** Aguarde 2-24 horas e verifique em https://dnschecker.org

### "Too Many Redirects"
**Causa:** Ambos middlewares registrados  
**Solução:** Use apenas ForceWWW OU RemoveWWW, nunca os dois

### SSL inválido
**Causa:** Railway ainda não gerou certificado  
**Solução:** Aguarde 10 minutos após adicionar domínio no Railway

### Site não carrega
**Causa:** Domínio não adicionado no Railway  
**Solução:** Adicione AMBOS (com e sem www) no Railway

---

## 📊 Status Atual do Projeto

✅ Middleware ForceWWW criado e ativado  
✅ Middleware RemoveWWW criado (disponível para uso)  
✅ Documentação completa  
⏳ DNS precisa ser configurado no Registro.br  
⏳ Domínios precisam ser adicionados no Railway  

---

## 📞 Links Úteis

- **Registro.br:** https://registro.br
- **Railway Dashboard:** https://railway.app
- **DNS Checker:** https://dnschecker.org
- **Teste de SSL:** https://www.ssllabs.com/ssltest/

---

## ✅ Próximos Passos Recomendados

1. [ ] Configurar DNS no Registro.br (ambos @ e www)
2. [ ] Adicionar ambos domínios no Railway
3. [ ] Atualizar APP_URL no Railway
4. [ ] Aguardar propagação DNS (2-24h)
5. [ ] Testar redirecionamento
6. [ ] Verificar SSL
7. [ ] Fazer commit das alterações no Git

---

**📝 Nota:** Todos os arquivos de middleware já foram criados e o ForceWWW já está ativo no código. Você só precisa configurar o DNS e Railway!
