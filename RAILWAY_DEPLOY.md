# 🚂 Deploy Railway - Inteligência MAX

## 📋 Guia Completo de Deploy

Este documento contém todas as informações necessárias para fazer o deploy da aplicação no Railway.

---

## 🔧 Configurações do Banco de Dados

### Credenciais Railway MySQL

```env
DB_CONNECTION=mysql
DB_HOST=metro.proxy.rlwy.net
DB_PORT=37078
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=ScZRjMeixWGFsfnbORMNCUxTCERaVbIq
```

**URL de Conexão Pública:**
```
mysql://root:ScZRjMeixWGFsfnbORMNCUxTCERaVbIq@metro.proxy.rlwy.net:37078/railway
```

---

## 🚀 Variáveis de Ambiente no Railway

Configure as seguintes variáveis no painel do Railway:

### Essenciais
```env
APP_NAME="Inteligência MAX"
APP_ENV=production
APP_KEY=base64:BJf8oHdfMnzKfuyixlz/OkI/gjb4Lzf+S1xboonYNsE=
APP_DEBUG=false
APP_URL=https://seu-dominio.railway.app

# Banco de Dados (Railway)
DB_CONNECTION=mysql
DB_HOST=metro.proxy.rlwy.net
DB_PORT=37078
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=ScZRjMeixWGFsfnbORMNCUxTCERaVbIq

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Queue & Broadcasting
QUEUE_CONNECTION=sync
BROADCAST_DRIVER=pusher

# Filesystem
FILESYSTEM_DISK=local
```

### Integrações (Configurar depois)
```env
# Pusher (Real-time)
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

# WhatsApp Business API
WHATSAPP_ACCESS_TOKEN=
WHATSAPP_PHONE_NUMBER_ID=

# OpenAI
OPENAI_API_KEY=

# Email (Configurar conforme provedor)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS="noreply@inteligenciamax.com.br"
MAIL_FROM_NAME="Inteligência MAX"
```

---

## 📦 Arquivos de Configuração

### nixpacks.toml
✅ **Já configurado** - Instala PHP 8.3 e extensões necessárias

### Procfile
✅ **Já configurado** - Para compatibilidade com Heroku

---

## 🎯 Passos para Deploy

### 1. No GitHub
```bash
# Branch já criada: genspark_ai_developer
git push origin genspark_ai_developer
```

### 2. No Railway Dashboard

1. **Criar Novo Projeto** (se não existe)
   - Acesse: https://railway.app
   - Clique em "New Project"
   - Selecione "Deploy from GitHub repo"
   - Escolha: `aureadress/ovowpp-InteligenciaMax`

2. **Configurar Variáveis de Ambiente**
   - Vá em "Variables"
   - Cole todas as variáveis da seção acima
   - Salve as alterações

3. **Conectar ao Banco MySQL**
   - O banco já está criado e configurado
   - Certifique-se que as variáveis DB_* estão corretas

4. **Configurar Domínio** (Opcional)
   - Vá em "Settings" → "Domains"
   - Adicione: `inteligenciamax.com.br`
   - Configure DNS conforme instruções

5. **Deploy**
   - O Railway fará deploy automaticamente
   - Aguarde conclusão (5-10 minutos)

---

## ✅ Pós-Deploy

### 1. Verificar Aplicação
```bash
# A aplicação estará disponível em:
https://[seu-projeto].railway.app
```

### 2. Acesso Admin
```
URL: https://[seu-dominio]/admin
Email: admin@site.com
Usuário: admin
Senha: admin
```
**⚠️ ALTERAR SENHA IMEDIATAMENTE!**

### 3. Comandos Úteis (via Railway CLI)
```bash
# Logs em tempo real
railway logs

# Rodar comandos
railway run php artisan migrate
railway run php artisan cache:clear
railway run php artisan config:clear
```

---

## 🔍 Troubleshooting

### Erro de Conexão ao Banco
- Verifique se todas as variáveis DB_* estão configuradas
- Teste conexão via TablePlus com as mesmas credenciais

### Erro 500
- Verifique logs: `railway logs`
- Certifique-se que APP_KEY está configurada
- Execute: `railway run php artisan config:clear`

### Assets não carregam
- Verifique se APP_URL está correto
- Execute: `railway run php artisan storage:link`

---

## 📞 Suporte

- **Repositório:** https://github.com/aureadress/ovowpp-InteligenciaMax
- **Railway:** https://railway.app
- **Documentação Laravel:** https://laravel.com/docs

---

## 📝 Notas

- ✅ Banco de dados já importado com dados iniciais
- ✅ Configurações básicas prontas
- ⚠️ Configure integrações (WhatsApp, OpenAI, Pusher) após deploy
- ⚠️ Altere credenciais padrão imediatamente

---

**Última atualização:** 2025-10-21
