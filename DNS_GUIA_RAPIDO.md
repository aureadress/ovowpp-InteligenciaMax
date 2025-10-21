# ⚡ Guia Rápido - Configuração DNS

## 🎯 Resumo em 3 Passos

### PASSO 1: No Railway 🚂
1. Acesse: https://railway.app/dashboard
2. Abra seu projeto
3. **Settings** → **Domains** → **Add Domain**
4. Digite: `inteligenciamax.com.br`
5. Railway mostrará algo como:
   ```
   CNAME: abc123.railway.app
   ```
6. **📋 COPIE ESSE VALOR!**

---

### PASSO 2: No Provedor do Domínio 🌐

**Onde está seu domínio?** Escolha abaixo:

#### 🇧🇷 Registro.br
```
🔗 https://registro.br
Login → Domínios → inteligenciamax.com.br
Editar Zona → Adicionar:

Tipo: CNAME
Host: @
Destino: [valor copiado do Railway]
```

#### ☁️ Cloudflare
```
🔗 https://dash.cloudflare.com
DNS → Add Record:

Type: CNAME
Name: @
Content: [valor copiado do Railway]
Proxy: 🟠 ON
```

#### 🌎 GoDaddy
```
🔗 https://account.godaddy.com
Domínios → DNS → Add:

Type: CNAME
Host: @
Points to: [valor copiado do Railway]
```

#### 🐅 HostGator
```
🔗 https://financeiro.hostgator.com.br
Domínios → Gerenciar DNS → Add:

Type: CNAME
Host: @
Points To: [valor copiado do Railway]
```

#### 📍 Locaweb
```
🔗 https://painel.locaweb.com.br
Domínios → Editar Zona DNS:

Tipo: CNAME
Nome: @
Valor: [valor copiado do Railway]
```

#### 📬 UOL Host
```
🔗 https://painel.uolhost.com.br
Domínios → Zona DNS:

Tipo: CNAME
Host: @
Destino: [valor copiado do Railway]
```

---

### PASSO 3: Aguardar e Verificar ⏱️

1. **Aguarde:** 15-30 minutos (pode levar até 48h)

2. **Verifique:** https://dnschecker.org
   - Digite: `inteligenciamax.com.br`
   - Tipo: `CNAME`
   - Veja se aparece o valor do Railway em vários países

3. **Teste:** Abra no navegador
   ```
   https://inteligenciamax.com.br
   ```

4. **No Railway:** Atualize variável
   ```
   APP_URL=https://inteligenciamax.com.br
   ```

---

## ❓ Não Sabe Onde Está Seu Domínio?

### Opção 1: Procure no Email 📧
Busque por:
- "confirmação"
- "registro"
- "domain"
- "renovação"

### Opção 2: Verifique Cobranças 💳
Veja no cartão/banco quem cobrou pelo domínio

### Opção 3: WHOIS 🔍
https://registro.br/tecnologia/ferramentas/whois/

---

## 🆘 Problemas?

### DNS não propagou ainda
⏳ **Aguarde mais tempo** (pode levar 48h)
🔄 **Limpe cache:** 
- Windows: `ipconfig /flushdns`
- Mac: `sudo dscacheutil -flushcache`

### Erro SSL
⏱️ **Aguarde 5-10 minutos** após DNS propagar
🔒 Railway gera SSL automaticamente

### Site não abre
✅ Teste primeiro: `https://seu-projeto.railway.app`
📋 Verifique logs no Railway
🔧 Verifique APP_URL está correto

---

## ✅ Checklist Rápido

- [ ] Descobri onde domínio está registrado
- [ ] Copiei valor CNAME do Railway
- [ ] Adicionei CNAME no DNS
- [ ] Salvei alterações
- [ ] Aguardei propagação
- [ ] Site funciona! 🎉

---

**🚀 Depois que funcionar, atualize APP_URL e está pronto!**

**Documentação completa:** `DOMINIO_CONFIGURACAO.md`
