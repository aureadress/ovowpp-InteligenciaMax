# ⚡ Comandos Rápidos - Configuração de Domínio

## 📋 Lista de Comandos Essenciais

### 1. Obter IP do Railway

```bash
# Substitua pela sua URL real do Railway
nslookup ovowpp-production-xxxx.up.railway.app
```

Ou use o script automatizado:

```bash
./scripts/domain-setup/obter-ip-railway.sh ovowpp-production-xxxx.up.railway.app
```

---

### 2. Verificar Configuração DNS

```bash
# Verificar registro A
nslookup inteligenciamax.com.br

# Verificar registro CNAME
nslookup www.inteligenciamax.com.br

# Verificação completa com dig
dig inteligenciamax.com.br
dig www.inteligenciamax.com.br
```

Ou use o script automatizado:

```bash
./scripts/domain-setup/verificar-dns.sh
```

---

### 3. Testar Conectividade HTTP/HTTPS

```bash
# Teste básico
curl -I https://inteligenciamax.com.br

# Teste detalhado
curl -v https://inteligenciamax.com.br

# Verificar código HTTP
curl -s -o /dev/null -w "%{http_code}" https://inteligenciamax.com.br
```

---

### 4. Verificar SSL/Certificado

```bash
# Verificar certificado SSL
echo | openssl s_client -servername inteligenciamax.com.br -connect inteligenciamax.com.br:443 2>/dev/null | grep "Verify return code"

# Informações detalhadas do certificado
echo | openssl s_client -servername inteligenciamax.com.br -connect inteligenciamax.com.br:443 2>/dev/null | openssl x509 -noout -dates
```

---

### 5. Verificar Propagação DNS em Múltiplos Servidores

```bash
# Google DNS
nslookup inteligenciamax.com.br 8.8.8.8

# Cloudflare DNS
nslookup inteligenciamax.com.br 1.1.1.1

# OpenDNS
nslookup inteligenciamax.com.br 208.67.222.222
```

---

### 6. Testar Tempo de Resposta

```bash
# Ping
ping -c 4 inteligenciamax.com.br

# Tempo de resposta HTTP
time curl -s -o /dev/null https://inteligenciamax.com.br
```

---

### 7. Verificar Headers HTTP

```bash
# Ver todos os headers
curl -I https://inteligenciamax.com.br

# Ver apenas status code e redirecionamentos
curl -sI https://inteligenciamax.com.br | grep -E "HTTP|Location"
```

---

### 8. Testar Redirecionamento www

```bash
# Deve redirecionar para versão sem www ou vice-versa
curl -I https://www.inteligenciamax.com.br
curl -I https://inteligenciamax.com.br
```

---

## 🔧 Scripts Disponíveis

### Script 1: Obter IP do Railway

**Localização:** `scripts/domain-setup/obter-ip-railway.sh`

**Uso:**
```bash
./scripts/domain-setup/obter-ip-railway.sh [sua-url-railway].up.railway.app
```

**O que faz:**
- Obtém o IP do Railway usando múltiplos métodos (nslookup, dig, host, ping)
- Salva o IP em arquivo `railway-ip.txt`
- Testa conectividade com o IP
- Mostra exatamente como configurar no Registro.br

---

### Script 2: Verificar DNS

**Localização:** `scripts/domain-setup/verificar-dns.sh`

**Uso:**
```bash
./scripts/domain-setup/verificar-dns.sh
```

**O que faz:**
- Verifica registro A do domínio principal
- Verifica registro CNAME do subdomínio www
- Testa conectividade HTTP/HTTPS
- Verifica certificado SSL
- Mostra informações detalhadas com dig
- Fornece checklist do que está configurado e do que falta

---

## 📦 Configuração no Registro.br

### Registro A (Domínio Principal)

```
Tipo: A
Nome: @
Valor: [IP_DO_RAILWAY]
TTL: 3600
```

### Registro CNAME (Subdomínio WWW)

```
Tipo: CNAME
Nome: www
Valor: [sua-url].up.railway.app
TTL: 3600
```

---

## 🌐 URLs para Testar Após Configuração

1. ✅ https://inteligenciamax.com.br
2. ✅ https://www.inteligenciamax.com.br
3. ✅ https://inteligenciamax.com.br/admin (login: admin / senha: admin)

---

## 🛠️ Troubleshooting Rápido

### Problema: "Site não encontrado"

```bash
# Verificar se DNS está propagado
nslookup inteligenciamax.com.br

# Se não retornar IP, aguarde 15-30 minutos
```

### Problema: "Certificado SSL inválido"

```bash
# Aguarde 15 minutos após DNS propagar
# O Railway gera certificados automaticamente

# Forçar regeneração no Railway:
# Dashboard > Settings > Domains > Regenerate Certificate
```

### Problema: "Erro 500 no site"

```bash
# Verificar logs do Railway:
# Dashboard > Deployments > [último deploy] > View Logs

# Pode ser necessário:
# 1. Verificar APP_URL no Railway
# 2. Restart do serviço
```

---

## 📊 Checklist de Verificação

- [ ] IP do Railway obtido
- [ ] Registro A configurado no Registro.br
- [ ] Registro CNAME configurado no Registro.br
- [ ] DNS propagado (nslookup retorna IP)
- [ ] Site abre em https://inteligenciamax.com.br
- [ ] Site abre em https://www.inteligenciamax.com.br
- [ ] SSL funcionando (cadeado verde)
- [ ] Login admin funciona (/admin)
- [ ] APP_URL atualizado no Railway
- [ ] Variáveis de ambiente configuradas

---

## 🔗 Links Úteis

- **Railway Dashboard:** https://railway.app/
- **Registro.br:** https://registro.br/
- **DNS Checker:** https://dnschecker.org/
- **SSL Labs:** https://www.ssllabs.com/ssltest/
- **WhatsMyDNS:** https://www.whatsmydns.net/

---

## 💡 Dicas

1. **Use modo anônimo** no navegador para testar (evita cache)
2. **Aguarde 15-30 minutos** para propagação DNS
3. **Verifique ambos** domínios (com e sem www)
4. **SSL leva 5-15 minutos** após DNS propagar
5. **Limpe cache** do navegador se necessário (Ctrl+Shift+Del)

---

**Criado em:** 2025-10-21  
**Projeto:** OvoWpp - InteligenciaMax  
**Deploy:** Railway + MySQL
