# 📁 Scripts de Configuração de Domínio - OvoWpp Railway

Este diretório contém todos os recursos necessários para configurar o domínio **inteligenciamax.com.br** no Railway.

---

## 📄 Arquivos Disponíveis

### 1. 📖 Documentação

#### **CONFIGURACAO_DOMINIO_PASSO_A_PASSO.md** (8.6 KB)
Guia completo e detalhado com todos os passos necessários para configurar o domínio.

**Conteúdo:**
- ✅ Como obter IP e URL do Railway
- ✅ Configuração passo a passo no Railway
- ✅ Configuração detalhada no Registro.br (registros A e CNAME)
- ✅ Atualização de variáveis de ambiente
- ✅ Verificação de propagação DNS
- ✅ Troubleshooting completo
- ✅ Checklist final

**Recomendado para:** Primeira configuração ou quando precisar de instruções detalhadas.

---

#### **COMANDOS_RAPIDOS.md** (5.2 KB)
Lista de comandos prontos para uso rápido.

**Conteúdo:**
- ⚡ Comandos para obter IP do Railway
- ⚡ Comandos de verificação DNS
- ⚡ Testes de conectividade HTTP/HTTPS
- ⚡ Verificação de SSL/certificado
- ⚡ Troubleshooting rápido
- ⚡ Checklist de verificação

**Recomendado para:** Consulta rápida de comandos específicos.

---

### 2. 🔧 Scripts Executáveis

#### **obter-ip-railway.sh** (4.3 KB)
Script automatizado para obter o IP do Railway.

**Como usar:**
```bash
./scripts/domain-setup/obter-ip-railway.sh ovowpp-production-xxxx.up.railway.app
```

**O que faz:**
- 🔍 Obtém IP usando múltiplos métodos (nslookup, dig, host, ping)
- 💾 Salva o IP em `railway-ip.txt`
- 🧪 Testa conectividade com o IP
- 📋 Mostra exatamente como configurar no Registro.br
- 🎨 Output colorido e organizado

**Quando usar:** Antes de configurar o DNS no Registro.br.

---

#### **verificar-dns.sh** (5.8 KB)
Script completo de verificação de configuração DNS.

**Como usar:**
```bash
./scripts/domain-setup/verificar-dns.sh
```

**O que faz:**
- ✅ Verifica registro A (domínio principal)
- ✅ Verifica registro CNAME (subdomínio www)
- ✅ Testa conectividade HTTP/HTTPS
- ✅ Verifica certificado SSL
- ✅ Mostra informações detalhadas (dig)
- ✅ Fornece links para ferramentas online
- ✅ Checklist do que está OK e do que falta
- 🎨 Output colorido e organizado

**Quando usar:** Após configurar DNS, para verificar se tudo está correto.

---

### 3. 📊 Arquivos de Configuração

#### **railway-variaveis.json** (2.4 KB)
Arquivo JSON com todas as variáveis de ambiente necessárias no Railway.

**Conteúdo organizado por categoria:**
- 🔧 Configuração da aplicação (APP_NAME, APP_ENV, APP_KEY, etc.)
- 🗄️ Banco de dados MySQL (credenciais do Railway)
- 💾 Cache e sessão
- 🔒 Segurança (domínios confiáveis)
- 📱 WhatsApp Meta API
- 🔔 Pusher (broadcasting)
- 🤖 Serviços de IA (OpenAI, Gemini)
- 📧 Configuração de email

**Como usar:**
1. Abra o arquivo
2. Substitua valores que contêm "SEU_" com suas credenciais reais
3. Copie e cole as variáveis no Railway Dashboard

---

## 🚀 Fluxo de Trabalho Recomendado

### Etapa 1: Obter Informações do Railway (5 minutos)

```bash
# 1. Obter IP do Railway
./scripts/domain-setup/obter-ip-railway.sh ovowpp-production-xxxx.up.railway.app

# 2. Anotar:
#    - IP: [será mostrado e salvo em railway-ip.txt]
#    - URL: ovowpp-production-xxxx.up.railway.app
```

---

### Etapa 2: Configurar DNS no Registro.br (10 minutos)

Siga o guia detalhado:
```bash
# Abra o arquivo no seu editor preferido
cat scripts/domain-setup/CONFIGURACAO_DOMINIO_PASSO_A_PASSO.md
```

**Configurações necessárias:**

**Registro A:**
```
Tipo: A
Nome: @
Valor: [IP obtido na Etapa 1]
TTL: 3600
```

**Registro CNAME:**
```
Tipo: CNAME
Nome: www
Valor: ovowpp-production-xxxx.up.railway.app
TTL: 3600
```

---

### Etapa 3: Configurar Railway (5 minutos)

1. **Adicionar domínio customizado:**
   - Dashboard Railway > Settings > Domains
   - Adicione: `inteligenciamax.com.br`
   - Adicione: `www.inteligenciamax.com.br`

2. **Atualizar variáveis de ambiente:**
   - Abra: `railway-variaveis.json`
   - Copie as variáveis necessárias
   - Cole no Railway Dashboard > Variables
   - **Importante:** Atualize `APP_URL=https://inteligenciamax.com.br`

---

### Etapa 4: Aguardar Propagação DNS (15-30 minutos)

```bash
# Execute o script de verificação periodicamente
./scripts/domain-setup/verificar-dns.sh

# Quando o DNS propagar, você verá:
# ✅ Registro A encontrado: [IP]
# ✅ Registro CNAME encontrado: [URL Railway]
```

---

### Etapa 5: Verificação Final (5 minutos)

**Teste os URLs:**
1. ✅ https://inteligenciamax.com.br
2. ✅ https://www.inteligenciamax.com.br
3. ✅ https://inteligenciamax.com.br/admin (login: admin / senha: admin)

**Checklist:**
- [ ] Site carrega corretamente
- [ ] SSL funcionando (cadeado verde)
- [ ] Ambos domínios (com e sem www) funcionam
- [ ] Login admin funciona
- [ ] Sem erros no console do navegador

---

## 📖 Guia de Uso dos Scripts

### Script: obter-ip-railway.sh

**Permissão de execução:**
```bash
chmod +x scripts/domain-setup/obter-ip-railway.sh
```

**Uso básico:**
```bash
./scripts/domain-setup/obter-ip-railway.sh [URL-DO-RAILWAY]
```

**Exemplo prático:**
```bash
./scripts/domain-setup/obter-ip-railway.sh ovowpp-production-a1b2.up.railway.app
```

**Output esperado:**
```
========================================
   Obter IP do Railway
========================================

📍 Obtendo IP para: ovowpp-production-a1b2.up.railway.app

Método 1: nslookup
✅ IP encontrado: 52.45.123.456

Método 2: dig
✅ IP encontrado: 52.45.123.456

========================================
   Resumo dos IPs Encontrados
========================================

✅ IP DO RAILWAY: 52.45.123.456

📍 Use este IP no Registro.br:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Tipo: A
Nome: @
Valor: 52.45.123.456
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

✅ IP salvo em: railway-ip.txt
```

---

### Script: verificar-dns.sh

**Permissão de execução:**
```bash
chmod +x scripts/domain-setup/verificar-dns.sh
```

**Uso básico:**
```bash
./scripts/domain-setup/verificar-dns.sh
```

**Output esperado (quando configurado):**
```
========================================
   Verificador DNS - OvoWpp Railway
========================================

📍 Verificando registro A para inteligenciamax.com.br...
✅ Registro A encontrado: 52.45.123.456

📍 Verificando registro CNAME para www.inteligenciamax.com.br...
✅ Registro CNAME encontrado: ovowpp-production-xxxx.up.railway.app

📍 Testando conectividade HTTP...
✅ Site acessível via HTTPS (HTTP 200)

📍 Verificando certificado SSL...
✅ Certificado SSL válido

========================================
   Resumo e Próximos Passos
========================================

✅ Configuração DNS parece estar correta!
✅ Aguarde a propagação global (15-30 minutos)

Próximos passos:
  1. Verifique se o site abre em: https://inteligenciamax.com.br
  2. Verifique se o site abre em: https://www.inteligenciamax.com.br
  3. Teste o login admin em: https://inteligenciamax.com.br/admin
  4. Verifique o SSL (cadeado verde no navegador)
```

---

## 🛠️ Troubleshooting

### Erro: "Permission denied" ao executar scripts

**Solução:**
```bash
chmod +x scripts/domain-setup/*.sh
```

---

### Erro: "Command not found: nslookup"

**Solução no Ubuntu/Debian:**
```bash
sudo apt-get update
sudo apt-get install dnsutils
```

**Solução no Alpine:**
```bash
apk add bind-tools
```

---

### DNS não propaga

**Verificações:**
1. Certifique-se de que salvou as alterações no Registro.br
2. Aguarde pelo menos 15-30 minutos
3. Limpe cache DNS local:
   ```bash
   # Windows
   ipconfig /flushdns
   
   # macOS
   sudo dscacheutil -flushcache
   
   # Linux
   sudo systemd-resolve --flush-caches
   ```

---

### Site mostra erro 500

**Verificações:**
1. Verifique logs do Railway:
   - Dashboard > Deployments > [último deploy] > View Logs
2. Verifique variável `APP_URL` está correta
3. Tente fazer restart do serviço no Railway

---

## 📊 Estrutura do Diretório

```
scripts/domain-setup/
├── README.md                                (este arquivo)
├── CONFIGURACAO_DOMINIO_PASSO_A_PASSO.md   (guia completo)
├── COMANDOS_RAPIDOS.md                      (comandos úteis)
├── railway-variaveis.json                   (variáveis de ambiente)
├── obter-ip-railway.sh                      (script para obter IP)
└── verificar-dns.sh                         (script de verificação)
```

---

## 🔗 Links Úteis

- **Railway Dashboard:** https://railway.app/
- **Registro.br:** https://registro.br/
- **DNS Checker:** https://dnschecker.org/
- **WhatsMyDNS:** https://www.whatsmydns.net/
- **SSL Labs:** https://www.ssllabs.com/ssltest/

---

## 📞 Suporte

Se encontrar problemas:

1. **Consulte o guia completo:** `CONFIGURACAO_DOMINIO_PASSO_A_PASSO.md`
2. **Use os comandos rápidos:** `COMANDOS_RAPIDOS.md`
3. **Execute os scripts de verificação**
4. **Verifique logs do Railway**
5. **Contate suporte:**
   - Railway: https://railway.app/help
   - Registro.br: suporte@registro.br ou (11) 5509-3511

---

## ✅ Checklist Rápido

Antes de começar, certifique-se de ter:

- [ ] Deploy do OvoWpp concluído no Railway
- [ ] URL do Railway anotada
- [ ] Acesso ao painel Registro.br
- [ ] Scripts com permissão de execução (`chmod +x`)

Durante a configuração:

- [ ] IP do Railway obtido
- [ ] Registro A configurado
- [ ] Registro CNAME configurado
- [ ] Domínios adicionados no Railway
- [ ] APP_URL atualizada
- [ ] DNS propagado e verificado

Após configuração:

- [ ] Site abre corretamente
- [ ] SSL funcionando
- [ ] Login admin funciona
- [ ] Sem erros no console

---

**Criado em:** 2025-10-21  
**Projeto:** OvoWpp - InteligenciaMax  
**Deploy:** Railway + MySQL + Domínio Customizado  
**Versão:** 1.0
