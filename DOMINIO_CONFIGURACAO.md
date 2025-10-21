# 🌐 Configuração de Domínio - inteligenciamax.com.br

## 📋 Onde Configurar DNS?

Você precisa configurar o DNS no **provedor onde o domínio foi registrado**.

---

## 🔍 Como Descobrir Onde Seu Domínio Está Registrado?

### Opção 1: Verificar Email
Procure no seu email por:
- "Confirmação de registro de domínio"
- "Domain registration"
- "Renovação de domínio"

Provedores comuns: Registro.br, GoDaddy, HostGator, Locaweb, UOL Host, etc.

### Opção 2: Consultar WHOIS
Acesse: https://registro.br/tecnologia/ferramentas/whois/
Digite: `inteligenciamax.com.br`

Procure por:
- **owner:** (proprietário)
- **provider:** (provedor DNS)
- **responsible:** (responsável)

---

## 🎯 Passo a Passo por Provedor

### 1️⃣ Registro.br (Domínios .br)

Se o domínio foi registrado no Registro.br:

#### A. Acessar Painel
1. Acesse: https://registro.br
2. Faça login com seu CPF/CNPJ
3. Clique em **"Domínios"**
4. Selecione: `inteligenciamax.com.br`

#### B. Configurar DNS no Registro.br

**OPÇÃO 1: Usar DNS do Registro.br (Recomendado)**

1. No menu do domínio, clique em **"Modo de Configuração"**
2. Escolha: **"DNS (Servidores de DNS do Registro.br)"**
3. Clique em **"Editar Zona"**

4. Adicione os seguintes registros:

**Registro CNAME (Railway fornecerá o valor):**
```
Tipo: CNAME
Host: @
Destino: [valor-fornecido-pelo-railway].railway.app
TTL: 3600
```

**Registro CNAME para www:**
```
Tipo: CNAME
Host: www
Destino: inteligenciamax.com.br
TTL: 3600
```

5. Clique em **"Salvar"**

**OPÇÃO 2: Usar DNS Externo (ex: Cloudflare)**

1. No menu do domínio, clique em **"Modo de Configuração"**
2. Escolha: **"Servidores DNS"**
3. Adicione os nameservers:
   - Se usar Cloudflare: `ns1.cloudflare.com`, `ns2.cloudflare.com`
   - Se usar Railway direto: seguir instruções do Railway

---

### 2️⃣ Cloudflare (Se usar como DNS)

Se você usa Cloudflare para gerenciar DNS:

1. Acesse: https://dash.cloudflare.com
2. Selecione o domínio: `inteligenciamax.com.br`
3. Vá em **"DNS"** → **"Records"**

4. Adicione os registros:

**Para domínio principal:**
```
Type: CNAME
Name: @
Content: [seu-projeto].railway.app
Proxy status: Proxied (🟠) ou DNS only (🔴)
TTL: Auto
```

**Para www:**
```
Type: CNAME
Name: www
Content: inteligenciamax.com.br
Proxy status: Proxied (🟠)
TTL: Auto
```

5. Clique em **"Save"**

⚠️ **Importante:** Se usar Cloudflare com proxy (🟠), ative:
- **SSL/TLS** → **Full (strict)**
- **Edge Certificates** → **Always Use HTTPS**

---

### 3️⃣ GoDaddy

Se o domínio está na GoDaddy:

1. Acesse: https://account.godaddy.com
2. Vá em **"Meus Produtos"** → **"Domínios"**
3. Clique em **"DNS"** ao lado do domínio

4. Adicione os registros:

```
Type: CNAME
Host: @
Points to: [seu-projeto].railway.app
TTL: 1 Hour
```

```
Type: CNAME
Host: www
Points to: inteligenciamax.com.br
TTL: 1 Hour
```

5. Clique em **"Save"**

---

### 4️⃣ HostGator

Se o domínio está na HostGator:

1. Acesse: https://financeiro.hostgator.com.br
2. Vá em **"Domínios"** → **"Meus Domínios"**
3. Clique no domínio → **"Gerenciar DNS"**

4. Adicione os registros:

```
Type: CNAME Record
Host Record: @
Points To: [seu-projeto].railway.app
TTL: 14400
```

```
Type: CNAME Record
Host Record: www
Points To: inteligenciamax.com.br
TTL: 14400
```

5. Clique em **"Add Record"**

---

### 5️⃣ Locaweb

Se o domínio está na Locaweb:

1. Acesse: https://painel.locaweb.com.br
2. Vá em **"Domínios"** → **"Gerenciar"**
3. Clique em **"Editar Zona DNS"**

4. Adicione os registros:

```
Tipo: CNAME
Nome: @
Valor: [seu-projeto].railway.app
TTL: 3600
```

```
Tipo: CNAME
Nome: www
Valor: inteligenciamax.com.br
TTL: 3600
```

5. Clique em **"Salvar"**

---

### 6️⃣ UOL Host

Se o domínio está no UOL Host:

1. Acesse: https://painel.uolhost.com.br
2. Vá em **"Domínios"**
3. Selecione o domínio → **"Zona DNS"**

4. Adicione os registros:

```
Tipo: CNAME
Host: @
Destino: [seu-projeto].railway.app
TTL: 3600
```

```
Tipo: CNAME
Host: www
Destino: inteligenciamax.com.br
TTL: 3600
```

5. Clique em **"Salvar Alterações"**

---

### 7️⃣ Namecheap

Se o domínio está na Namecheap:

1. Acesse: https://www.namecheap.com
2. Vá em **"Domain List"** → Clique em **"Manage"**
3. Vá em **"Advanced DNS"**

4. Adicione os registros:

```
Type: CNAME Record
Host: @
Value: [seu-projeto].railway.app
TTL: Automatic
```

```
Type: CNAME Record
Host: www
Value: inteligenciamax.com.br
TTL: Automatic
```

5. Clique em **"Save All Changes"**

---

## 🚂 Obter o Valor do Railway

Antes de configurar o DNS, você precisa do valor CNAME do Railway:

1. Acesse: https://railway.app/dashboard
2. Abra seu projeto OvoWpp
3. Vá em **"Settings"** → **"Domains"**
4. Clique em **"Add Domain"**
5. Digite: `inteligenciamax.com.br`
6. Railway fornecerá algo como:
   ```
   CNAME: abc123xyz456.railway.app
   ```
   OU
   ```
   A Record: 123.45.67.89
   ```

7. **Copie esse valor** e use na configuração DNS acima

---

## ✅ Verificar Configuração

### 1. Aguardar Propagação
- **Tempo:** 5 minutos a 48 horas
- **Geralmente:** 15-30 minutos

### 2. Verificar Status

**Online:**
- https://dnschecker.org
- Digite: `inteligenciamax.com.br`
- Tipo: `CNAME` ou `A`

**Terminal:**
```bash
nslookup inteligenciamax.com.br
```

ou

```bash
dig inteligenciamax.com.br
```

### 3. Testar Acesso
```
https://inteligenciamax.com.br
https://www.inteligenciamax.com.br
```

---

## 🔧 Configuração Final no Railway

Depois que o DNS propagar:

1. No Railway, verifique se o domínio está **"Active"**
2. SSL será configurado automaticamente (Let's Encrypt)
3. Atualize a variável de ambiente:
   ```
   APP_URL=https://inteligenciamax.com.br
   ```
4. Faça um novo deploy

---

## ⚠️ Problemas Comuns

### DNS não propaga
- Aguarde mais tempo (até 48h)
- Verifique se os registros estão corretos
- Limpe cache DNS local: `ipconfig /flushdns` (Windows) ou `sudo dscacheutil -flushcache` (Mac)

### Erro SSL/HTTPS
- Aguarde alguns minutos após DNS propagar
- Railway gera certificado SSL automaticamente
- Se usar Cloudflare, configure SSL/TLS para "Full (strict)"

### Site não carrega
- Verifique logs no Railway
- Verifique APP_URL no Railway
- Teste com URL temporária Railway primeiro

---

## 📝 Checklist Final

- [ ] Descobrir onde domínio está registrado
- [ ] Acessar painel do provedor DNS
- [ ] Obter valor CNAME do Railway
- [ ] Adicionar registro CNAME para @ (raiz)
- [ ] Adicionar registro CNAME para www
- [ ] Salvar alterações
- [ ] Aguardar propagação (verificar dnschecker.org)
- [ ] Testar acesso ao site
- [ ] Atualizar APP_URL no Railway
- [ ] Verificar SSL/HTTPS funcionando

---

## 🆘 Precisa de Ajuda?

Se não conseguir descobrir onde está registrado ou tiver dificuldades:

1. **Procure emails** com "registro", "domain", "renovação"
2. **Verifique sua conta bancária/cartão** - busque cobranças de:
   - Registro.br
   - GoDaddy
   - HostGator
   - Locaweb
   - Outros
3. **Entre em contato** com o provedor de hospedagem que você usa

---

## 💡 Dica Extra: Redirecionamento www

Para redirecionar www automaticamente:

No Railway, após adicionar o domínio principal:
1. Adicione também: `www.inteligenciamax.com.br`
2. Railway redirecionará automaticamente www → raiz

---

**Última atualização:** 2025-10-21  
**Criado por:** GenSpark AI Developer
