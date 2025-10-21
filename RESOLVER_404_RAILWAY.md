# 🔧 Resolver Erro 404 "Not Found" - Railway

## 🚨 Problema Identificado

Você está vendo esta tela do Railway:

```
404 Not Found
The train has not arrived at the station.

Please check your network settings to confirm that your domain has provisioned.
```

---

## 🔍 Causas Possíveis

### 1. **Domínio NÃO foi adicionado no Railway** ⚠️ (Mais provável)
- Você configurou o DNS no Registro.br
- MAS esqueceu de adicionar o domínio customizado no Railway

### 2. **Aplicação não está rodando**
- Deploy falhou
- Aplicação teve erro ao iniciar
- Processo está parado

### 3. **DNS ainda não propagou**
- Configurou há menos de 2 horas
- Ainda está esperando propagação global

### 4. **Configuração de DNS incorreta**
- IP ou CNAME errado
- Registro mal configurado

---

## ✅ SOLUÇÃO PASSO A PASSO

### **Passo 1: Adicionar Domínio no Railway** ⚠️ **CRÍTICO**

1. **Acesse Railway Dashboard:**
   - https://railway.app
   - Faça login

2. **Selecione o projeto:**
   - Clique em "OvoWpp - Inteligência MAX"

3. **Vá em Settings → Domains:**
   - Na barra lateral esquerda, clique em **"Settings"**
   - Role até a seção **"Domains"**

4. **Adicionar domínio customizado:**
   
   **Primeiro o domínio raiz:**
   - Clique em **"+ Custom Domain"**
   - Digite: `inteligenciamax.com.br`
   - Clique em **"Add Domain"**
   - ⚠️ Railway vai mostrar: **"Add an A record with value: XXX.XXX.XXX.XXX"**
   - **ANOTE ESSE IP!** Você vai precisar dele no Registro.br

   **Depois o www:**
   - Clique em **"+ Custom Domain"** novamente
   - Digite: `www.inteligenciamax.com.br`
   - Clique em **"Add Domain"**
   - Railway vai mostrar: **"Add a CNAME record to: ikz4ue6o.up.railway.app"**

5. **Aguarde o status mudar:**
   - Domínios devem aparecer com status **"Active"** e ícone de cadeado 🔒 (SSL)
   - Isso pode levar 2-10 minutos após adicionar

---

### **Passo 2: Configurar DNS no Registro.br**

Só faça isso **DEPOIS** de adicionar os domínios no Railway!

1. **Acesse:** https://registro.br
2. **Vá em:** Meus Domínios → inteligenciamax.com.br
3. **Clique em:** Editar Zona DNS

**Adicione dois registros:**

```
┌─────────────────────────────────────────────────────┐
│  TIPO    │  NOME    │  VALOR                        │
├─────────────────────────────────────────────────────┤
│  A       │  @       │  XXX.XXX.XXX.XXX              │ ← IP do Railway
│  CNAME   │  www     │  ikz4ue6o.up.railway.app.     │
└─────────────────────────────────────────────────────┘
```

**⚠️ Importante:**
- Use o IP EXATO que o Railway forneceu no Passo 1
- Não esqueça o ponto final no CNAME: `ikz4ue6o.up.railway.app.`
- TTL: pode deixar o padrão (3600 ou 86400)

4. **Salve as alterações**

---

### **Passo 3: Verificar Deploy da Aplicação**

1. **No Railway Dashboard:**
   - Clique no seu projeto
   - Vá na aba **"Deployments"**

2. **Verifique o último deploy:**
   - Status deve ser: ✅ **"Success"** (verde)
   - Se estiver ❌ **"Failed"** (vermelho), clique para ver os logs

3. **Se o deploy falhou:**
   - Clique em **"View Logs"**
   - Procure por erros (geralmente em vermelho)
   - Erros comuns:
     - `APP_KEY is missing` → Precisa gerar chave
     - `Connection refused` → Problema com banco de dados
     - `Class not found` → Precisa rodar composer install

4. **Fazer Redeploy (se necessário):**
   - Clique nos três pontinhos (...) do deploy
   - Clique em **"Redeploy"**

---

### **Passo 4: Verificar Variáveis de Ambiente**

1. **No Railway, vá em:**
   - Settings → Variables

2. **Verifique se existem:**
   ```
   APP_NAME="Inteligência MAX"
   APP_ENV=production
   APP_KEY=base64:... (deve ter um valor!)
   APP_DEBUG=false
   APP_URL=https://www.inteligenciamax.com.br
   
   DB_CONNECTION=mysql
   DB_HOST=... (deve estar preenchido)
   DB_PORT=...
   DB_DATABASE=...
   DB_USERNAME=...
   DB_PASSWORD=...
   ```

3. **Se APP_KEY estiver vazio:**
   - Gere uma chave: https://generate-random.org/laravel-key-generator
   - Adicione como: `APP_KEY=base64:sua_chave_aqui`
   - Redeploy da aplicação

4. **Se APP_URL estiver errado:**
   - Mude para: `APP_URL=https://www.inteligenciamax.com.br`
   - Redeploy

---

### **Passo 5: Aguardar Propagação DNS**

Depois de configurar tudo:

1. **Tempo de espera:**
   - Mínimo: 2 horas
   - Normal: 6-12 horas  
   - Máximo: 48 horas

2. **Verificar propagação:**
   - Acesse: https://dnschecker.org
   - Digite: `inteligenciamax.com.br`
   - Deve aparecer o IP do Railway
   - Digite: `www.inteligenciamax.com.br`
   - Deve aparecer CNAME para Railway

3. **Enquanto espera:**
   - Teste o domínio original do Railway: `https://ikz4ue6o.up.railway.app`
   - Se esse funcionar, é só questão de DNS propagar

---

## 🧪 Testes de Diagnóstico

### Teste 1: Domínio Railway Original
```bash
# Acessar domínio padrão do Railway
https://ikz4ue6o.up.railway.app
```
**Se funcionar:** ✅ Aplicação está rodando, é problema de DNS  
**Se não funcionar:** ❌ Aplicação não está rodando

### Teste 2: DNS Configurado
```bash
# Via terminal (se tiver acesso)
nslookup inteligenciamax.com.br
nslookup www.inteligenciamax.com.br

# Ou use: https://dnschecker.org
```
**Esperado:**
- `inteligenciamax.com.br` → IP do Railway
- `www.inteligenciamax.com.br` → CNAME ikz4ue6o.up.railway.app

### Teste 3: SSL Ativo
No Railway Dashboard, na seção Domains:
- ✅ Deve ter um cadeado 🔒 ao lado de cada domínio
- Status: **"Active"**

---

## 📊 Checklist Completo

- [ ] ✅ **Domínio `inteligenciamax.com.br` adicionado no Railway**
- [ ] ✅ **Domínio `www.inteligenciamax.com.br` adicionado no Railway**
- [ ] 📝 **Anotei o IP fornecido pelo Railway para o domínio raiz**
- [ ] ✅ **Registro A configurado no Registro.br com @**
- [ ] ✅ **Registro CNAME configurado no Registro.br com www**
- [ ] ✅ **APP_KEY está definida nas variáveis do Railway**
- [ ] ✅ **APP_URL=https://www.inteligenciamax.com.br no Railway**
- [ ] ✅ **Último deploy tem status "Success"**
- [ ] ✅ **Domínios mostram "Active" no Railway**
- [ ] ✅ **SSL está ativo (cadeado 🔒)**
- [ ] ⏳ **Aguardei pelo menos 2 horas após configurar DNS**
- [ ] 🔍 **Verifiquei propagação DNS no dnschecker.org**

---

## 🚀 Atalho Rápido

Se você ainda não adicionou os domínios no Railway:

1. **Vá para:** https://railway.app
2. **Clique em:** Seu projeto
3. **Settings** → **Domains** → **+ Custom Domain**
4. **Adicione:** `inteligenciamax.com.br` (anote o IP!)
5. **Adicione:** `www.inteligenciamax.com.br`
6. **Aguarde** status "Active" aparecer
7. **Configure DNS** no Registro.br com os valores mostrados
8. **Aguarde** 2-24h para propagação

---

## ❓ Perguntas Frequentes

### P: Quanto tempo leva para funcionar?
**R:** Após adicionar os domínios no Railway: 2-10 minutos para SSL  
Após configurar DNS: 2-48 horas para propagação

### P: O domínio Railway original ainda funciona?
**R:** Sim! `ikz4ue6o.up.railway.app` sempre funcionará

### P: Posso usar apenas www?
**R:** Sim, mas recomendamos configurar ambos. O middleware ForceWWW vai redirecionar automaticamente

### P: O que significa "network settings"?
**R:** Railway está dizendo que o domínio não foi provisionado = não foi adicionado no dashboard deles

---

## 🆘 Se Nada Funcionar

1. **Verifique os logs do Railway:**
   - Deployments → View Logs
   - Procure por erros

2. **Teste o domínio padrão:**
   - https://ikz4ue6o.up.railway.app
   - Se funcionar, é problema de DNS

3. **Limpe cache DNS local:**
   ```bash
   # Windows
   ipconfig /flushdns
   
   # Mac
   sudo dscacheutil -flushcache
   
   # Linux
   sudo systemd-resolve --flush-caches
   ```

4. **Tente em navegador anônimo/privado**
   - Remove cache do navegador

5. **Aguarde mais tempo**
   - DNS pode levar até 48h

---

## 🔗 Links Úteis

- **Railway Dashboard:** https://railway.app
- **Railway Docs - Custom Domains:** https://docs.railway.app/deploy/custom-domains
- **Registro.br:** https://registro.br
- **DNS Checker:** https://dnschecker.org
- **SSL Test:** https://www.ssllabs.com/ssltest/

---

✅ **Na maioria dos casos, o erro 404 significa que você esqueceu de adicionar o domínio no Railway Dashboard!**

🎯 **Comece pelo Passo 1: Adicionar domínios no Railway primeiro!**
