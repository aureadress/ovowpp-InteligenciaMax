# 🚂 Guia Completo de Deploy no Railway

## 📋 Pré-requisitos

- ✅ Conta no Railway: https://railway.app
- ✅ Banco de dados MySQL já configurado no Railway
- ✅ Repositório GitHub: aureadress/ovowpp-InteligenciaMax
- ✅ PR #1 merged ✅

---

## 🚀 Passo a Passo - Deploy no Railway

### 1️⃣ Criar Novo Projeto

1. Acesse: https://railway.app/dashboard
2. Clique em **"New Project"**
3. Selecione **"Deploy from GitHub repo"**
4. Escolha o repositório: **`aureadress/ovowpp-InteligenciaMax`**
5. Selecione a branch: **`main`**

### 2️⃣ Configurar Variáveis de Ambiente

No painel do Railway, clique na aba **"Variables"** e adicione TODAS as variáveis abaixo:

#### 🔧 Configurações da Aplicação

```bash
APP_NAME=Inteligência MAX
APP_ENV=production
APP_KEY=base64:BJf8oHdfMnzKfuyixlz/OkI/gjb4Lzf+S1xboonYNsE=
APP_DEBUG=false
APP_URL=https://seu-projeto.railway.app
```

**⚠️ IMPORTANTE:** Depois de configurar o domínio customizado, atualize `APP_URL` para `https://inteligenciamax.com.br`

#### 🗄️ Banco de Dados (Railway MySQL)

```bash
DB_CONNECTION=mysql
DB_HOST=metro.proxy.rlwy.net
DB_PORT=37078
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=ScZRjMeixWGFsfnbORMNCUxTCERaVbIq
```

#### 📝 Logs e Sistema

```bash
LOG_CHANNEL=stack
LOG_LEVEL=error
```

#### 📦 Cache, Session e Queue

```bash
BROADCAST_DRIVER=pusher
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

#### 📧 Configuração de Email

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=noreply@inteligenciamax.com.br
MAIL_FROM_NAME=Inteligência MAX
```

**Nota:** Configure um serviço de email real posteriormente (SendGrid, Mailgun, etc.)

#### 🔴 Pusher (Real-time) - OPCIONAL

```bash
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1
```

**Como obter:**
1. Crie conta em https://pusher.com
2. Crie um novo App
3. Copie as credenciais e cole aqui

#### 💬 WhatsApp Business API (Meta) - CONFIGURAR DEPOIS

```bash
WHATSAPP_ACCESS_TOKEN=
WHATSAPP_PHONE_NUMBER_ID=
WHATSAPP_VERIFY_TOKEN=
META_APP_ID=
META_APP_SECRET=
META_CONFIG_ID=
```

**Como obter:**
1. Acesse: https://developers.facebook.com/apps/
2. Crie/selecione seu app
3. Configure WhatsApp Business API
4. Copie as credenciais

#### 🤖 OpenAI - CONFIGURAR DEPOIS

```bash
OPENAI_API_KEY=
OPENAI_MODEL=gpt-4o
```

**Como obter:**
1. Acesse: https://platform.openai.com/api-keys
2. Crie uma API Key
3. Cole aqui

#### 🤖 Google Gemini - CONFIGURAR DEPOIS

```bash
GEMINI_API_KEY=
```

**Como obter:**
1. Acesse: https://aistudio.google.com/api-keys
2. Crie uma API Key
3. Cole aqui

#### 🔥 Firebase - CONFIGURAR DEPOIS

```bash
FIREBASE_API_KEY=
FIREBASE_AUTH_DOMAIN=
FIREBASE_PROJECT_ID=
FIREBASE_STORAGE_BUCKET=
FIREBASE_MESSAGING_SENDER_ID=
FIREBASE_APP_ID=
FIREBASE_MEASUREMENT_ID=
```

**Como obter:**
1. Acesse: https://console.firebase.google.com
2. Crie/selecione projeto
3. Vá em Configurações do Projeto
4. Copie as credenciais

---

### 3️⃣ Configurar Build Settings

No Railway, vá em **"Settings"** → **"Build"**:

O Railway detectará automaticamente o `nixpacks.toml` e configurará:

- **Build Command:** `composer install --no-dev --optimize-autoloader`
- **Start Command:** Detectado automaticamente do `nixpacks.toml`

**Não precisa alterar nada!** ✅

---

### 4️⃣ Deploy Inicial

1. Clique em **"Deploy"** ou aguarde o deploy automático
2. Aguarde 5-10 minutos para o build completar
3. Monitore os logs em tempo real clicando em **"View Logs"**

**O que acontece:**
- ✅ Railway clona o repositório
- ✅ Instala PHP 8.3 e extensões
- ✅ Executa `composer install`
- ✅ Faz cache das configurações Laravel
- ✅ Inicia o servidor

---

### 5️⃣ Verificar Deploy

1. No Railway, copie a URL gerada: `https://[seu-projeto].railway.app`
2. Abra em uma nova aba
3. Você deve ver a aplicação funcionando! 🎉

**URLs Importantes:**
- **Home:** `https://[seu-projeto].railway.app`
- **Admin:** `https://[seu-projeto].railway.app/admin`

---

### 6️⃣ Configurar Domínio Customizado

#### A. Adicionar Domínio no Railway

1. No projeto Railway, vá em **"Settings"** → **"Domains"**
2. Clique em **"Add Domain"**
3. Digite: `inteligenciamax.com.br`
4. Railway fornecerá um CNAME value (exemplo: `abc123.railway.app`)

#### B. Configurar DNS

No seu provedor de domínio (Registro.br, GoDaddy, etc.):

**Opção 1: CNAME (Recomendado)**
```
Tipo: CNAME
Host: @
Valor: abc123.railway.app
TTL: 3600
```

**Opção 2: A Record**
```
Tipo: A
Host: @
Valor: [IP fornecido pelo Railway]
TTL: 3600
```

**Adicionar www também:**
```
Tipo: CNAME
Host: www
Valor: inteligenciamax.com.br
TTL: 3600
```

#### C. Aguardar Propagação DNS

- Tempo: 5 minutos a 48 horas
- Verificar: https://dnschecker.org

#### D. Atualizar APP_URL

No Railway, atualize a variável:
```bash
APP_URL=https://inteligenciamax.com.br
```

E faça um novo deploy.

---

### 7️⃣ Primeiro Acesso - Admin

1. Acesse: `https://inteligenciamax.com.br/admin`
2. **Usuário:** `admin`
3. **Senha:** `admin`

**⚠️ ALTERE A SENHA IMEDIATAMENTE!**

1. Vá em **Perfil** ou **Configurações**
2. Altere email e senha
3. Configure autenticação de dois fatores (se disponível)

---

## 🔧 Configurações Pós-Deploy

### 1. Configurar Cron Job

No Railway, adicione um serviço de cron ou use um serviço externo:

**Opções:**
- **EasyCron:** https://www.easycron.com
- **Cron-Job.org:** https://cron-job.org

**Comando:**
```bash
curl https://inteligenciamax.com.br/cron
```

**Frequência:** A cada 1 minuto

### 2. Configurar Storage Link

Se necessário, execute via Railway CLI ou adicione ao build:

```bash
php artisan storage:link
```

### 3. Configurar Integrações

No painel admin:
1. **WhatsApp API** → Adicionar credenciais Meta
2. **AI Assistant** → Configurar OpenAI ou Gemini
3. **Pusher** → Adicionar credenciais Pusher
4. **Firebase** → Upload de arquivos de configuração

---

## 📊 Monitoramento

### Ver Logs
```
Railway Dashboard → Seu Projeto → "View Logs"
```

### Métricas
```
Railway Dashboard → Seu Projeto → "Metrics"
```

### Alertas
Configure alertas de erro e downtime no Railway.

---

## 🆘 Troubleshooting

### Erro 500
1. Verifique logs no Railway
2. Verifique `APP_KEY` está configurada
3. Execute `php artisan config:clear`

### Erro de Banco de Dados
1. Verifique credenciais `DB_*`
2. Teste conexão via TablePlus
3. Verifique se Railway MySQL está online

### Assets não carregam
1. Verifique `APP_URL` correto
2. Execute `php artisan config:cache`
3. Limpe cache do navegador

### Domínio não funciona
1. Verifique DNS com https://dnschecker.org
2. Aguarde propagação (até 48h)
3. Verifique configuração no Railway

---

## 📝 Checklist Final

- [ ] Deploy completado com sucesso
- [ ] Domínio configurado e funcionando
- [ ] SSL/HTTPS ativo (automático no Railway)
- [ ] Acesso admin funcionando
- [ ] Senha padrão alterada
- [ ] Variáveis de ambiente configuradas
- [ ] Cron job configurado
- [ ] WhatsApp API configurado
- [ ] OpenAI/Gemini configurado
- [ ] Pusher configurado
- [ ] Emails funcionando
- [ ] Testes básicos realizados

---

## 🎯 Próximos Passos

1. ✅ Configurar todas as integrações
2. ✅ Adicionar usuários e permissões
3. ✅ Configurar planos de assinatura
4. ✅ Configurar gateways de pagamento
5. ✅ Testar fluxos completos
6. ✅ Traduzir para português (próxima fase)
7. ✅ Implementar Baileys (próxima fase)

---

## 📞 Suporte

- **Documentação OvoWpp:** https://preview.ovosolution.com/ovowpp/documentation/
- **Railway Docs:** https://docs.railway.app
- **Laravel Docs:** https://laravel.com/docs

---

**✨ Deploy Concluído! Seu sistema está no ar! ✨**

**URL de Produção:** https://inteligenciamax.com.br  
**Admin Panel:** https://inteligenciamax.com.br/admin

---

**Criado por:** GenSpark AI Developer  
**Data:** 2025-10-21
