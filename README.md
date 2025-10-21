# 📱 OvoWpp - Inteligência MAX

**Plataforma Completa de CRM e Marketing para WhatsApp**

Sistema SaaS cross-platform com Web + Mobile + Painel Admin integrado com Meta WhatsApp Business API.

---

## 🚀 Tecnologias

- **Backend:** Laravel 11 + PHP 8.3
- **Database:** MySQL 8.0+
- **Frontend:** Blade Templates + Assets
- **Mobile:** Flutter (apps nativos)
- **Integrações:** 
  - Meta WhatsApp Business API
  - OpenAI (GPT-4o)
  - Pusher (real-time)
  - Firebase (notificações)

---

## ⚙️ Requisitos

- PHP 8.3+
- MySQL 8.0+ / MariaDB 10.6+
- Composer
- Extensões PHP: BCMath, Ctype, cURL, DOM, Fileinfo, GD, JSON, Mbstring, OpenSSL, PDO, PDO_MySQL, Tokenizer, XML, Zip

---

## 📦 Deploy Railway

### Variáveis de Ambiente Necessárias:

```env
APP_NAME="Inteligência MAX"
APP_ENV=production
APP_KEY=base64:BJf8oHdfMnzKfuyixlz/OkI/gjb4Lzf+S1xboonYNsE=
APP_DEBUG=false
APP_URL=https://inteligenciamax.com.br

DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=sync

# Pusher (Real-time)
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=

# WhatsApp Business API
WHATSAPP_ACCESS_TOKEN=
WHATSAPP_PHONE_NUMBER_ID=

# OpenAI
OPENAI_API_KEY=
```

---

## 🔧 Instalação Local

```bash
# Instalar dependências
composer install

# Copiar .env
cp .env.example .env

# Gerar chave
php artisan key:generate

# Importar banco de dados
mysql -u root -p database_name < install/database.sql

# Rodar migrações (se necessário)
php artisan migrate

# Servir aplicação
php artisan serve
```

---

## 📱 Recursos

✅ CRM completo para WhatsApp  
✅ Automação de mensagens  
✅ Envio em massa  
✅ Assistente IA (OpenAI/Gemini)  
✅ Multi-usuários com assinaturas  
✅ Gateway de pagamento integrado  
✅ Painel administrativo completo  
✅ Apps mobile (iOS/Android)  
✅ WhatsApp Web via QR Code (Baileys)  
✅ API oficial Meta WhatsApp  

---

## 🔐 Acesso Admin Padrão

```
URL: /admin
Usuário: admin
Senha: admin
```

**⚠️ ALTERAR IMEDIATAMENTE após primeiro acesso!**

---

## 📞 Suporte

🌐 **Domínio:** https://inteligenciamax.com.br  
📧 **Email:** suporte@inteligenciamax.com.br  

---

## 📄 Licença

Proprietary - Todos os direitos reservados © 2025 Inteligência MAX
