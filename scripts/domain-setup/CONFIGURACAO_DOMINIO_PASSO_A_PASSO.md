# 🌐 Configuração Completa do Domínio inteligenciamax.com.br

## 📋 PRÉ-REQUISITOS

Antes de começar, você precisa ter em mãos:

- ✅ Aplicação OvoWpp rodando no Railway (deploy concluído com sucesso)
- ✅ Acesso ao painel Registro.br (login e senha)
- ✅ URL do Railway (formato: `xxxxxxxx.up.railway.app`)
- ✅ IP do Railway (você vai obter isso no passo 2)

---

## 🎯 PARTE 1: CONFIGURAÇÃO NO RAILWAY

### Passo 1: Obter URL e IP do Railway

1. **Acesse o Dashboard Railway:**
   - Vá para: https://railway.app/
   - Entre no projeto OvoWpp
   - Clique no serviço "ovowpp"

2. **Copie a URL do Railway:**
   ```
   Exemplo: ovowpp-production-xxxx.up.railway.app
   ```
   ⚠️ **IMPORTANTE:** Anote essa URL exata!

3. **Obter o IP do Railway:**
   
   Abra o terminal e execute:
   ```bash
   nslookup ovowpp-production-xxxx.up.railway.app
   ```
   
   Ou use:
   ```bash
   dig ovowpp-production-xxxx.up.railway.app +short
   ```
   
   Você vai ver algo como:
   ```
   52.45.123.456
   ```
   ⚠️ **ANOTE ESSE IP!**

### Passo 2: Adicionar Domínio Customizado no Railway

1. **No Dashboard Railway:**
   - Clique em "Settings" do serviço
   - Vá em "Domains"
   - Clique em "Custom Domain"

2. **Adicione o domínio:**
   ```
   inteligenciamax.com.br
   ```

3. **Adicione também o subdomínio www:**
   ```
   www.inteligenciamax.com.br
   ```

4. O Railway vai mostrar que os domínios estão pendentes de verificação DNS

---

## 🎯 PARTE 2: CONFIGURAÇÃO NO REGISTRO.BR

### Passo 1: Acessar o Painel Registro.br

1. Acesse: https://registro.br/
2. Faça login com suas credenciais
3. Vá em "Meus Domínios"
4. Clique em "inteligenciamax.com.br"

### Passo 2: Configurar DNS - Modo Avançado

1. **Clique em "DNS" ou "Alterar Servidores DNS"**

2. **Escolha "Usar servidores do Registro.br"** (se ainda não estiver selecionado)

3. **Clique em "Editar Zona"** ou "Gerenciar DNS"

### Passo 3: Adicionar Registro A (Principal)

```
Tipo: A
Nome/Host: @
Destino/Valor: [IP DO RAILWAY OBTIDO NO PASSO 1.3]
TTL: 3600 (ou deixe o padrão)
```

**Exemplo prático:**
```
Tipo: A
Nome: @
Valor: 52.45.123.456
TTL: 3600
```

⚠️ **O símbolo @ representa o domínio raiz (inteligenciamax.com.br)**

### Passo 4: Adicionar Registro CNAME (WWW)

```
Tipo: CNAME
Nome/Host: www
Destino/Valor: [SUA-URL-RAILWAY].up.railway.app
TTL: 3600 (ou deixe o padrão)
```

**Exemplo prático:**
```
Tipo: CNAME
Nome: www
Valor: ovowpp-production-xxxx.up.railway.app
TTL: 3600
```

⚠️ **NÃO coloque ponto final no final da URL do Railway**

### Passo 5: Salvar Configurações

1. Clique em "Adicionar" ou "Salvar" após cada registro
2. Revise se ambos os registros estão corretos:
   - ✅ Registro A: @ → IP do Railway
   - ✅ Registro CNAME: www → URL do Railway

3. Clique em "Salvar Zona" ou "Aplicar Alterações"

### Passo 6: Confirmar Configuração

Você deve ver algo assim na lista de registros DNS:

```
Tipo    Nome    Valor
----    ----    -----
A       @       52.45.123.456
CNAME   www     ovowpp-production-xxxx.up.railway.app
```

---

## 🎯 PARTE 3: ATUALIZAR VARIÁVEIS DE AMBIENTE NO RAILWAY

### Passo 1: Acessar Variáveis de Ambiente

1. No Dashboard Railway
2. Clique no serviço "ovowpp"
3. Vá em "Variables"

### Passo 2: Atualizar APP_URL

Localize a variável `APP_URL` e altere para:

```
APP_URL=https://inteligenciamax.com.br
```

⚠️ **Use HTTPS (não HTTP)**

### Passo 3: Adicionar Domínios Confiáveis (Opcional mas Recomendado)

Adicione uma nova variável:

```
TRUSTED_DOMAINS=inteligenciamax.com.br,www.inteligenciamax.com.br
```

### Passo 4: Salvar e Redesployar

1. Clique em "Save"
2. O Railway vai automaticamente fazer redeploy da aplicação
3. Aguarde o deploy completar (1-2 minutos)

---

## ⏰ PROPAGAÇÃO DNS

### Tempo de Espera

- **Registro.br:** 30 minutos a 2 horas (geralmente)
- **Propagação Global:** Até 24-48 horas (casos raros)
- **Na prática:** Geralmente funciona em 15-30 minutos

### Como Verificar a Propagação

Execute estes comandos no terminal:

```bash
# Verificar registro A
nslookup inteligenciamax.com.br

# Verificar CNAME
nslookup www.inteligenciamax.com.br

# Verificar com dig (mais detalhado)
dig inteligenciamax.com.br
dig www.inteligenciamax.com.br
```

**Resultado esperado:**

```bash
# Para o domínio principal
inteligenciamax.com.br → 52.45.123.456

# Para o www
www.inteligenciamax.com.br → ovowpp-production-xxxx.up.railway.app → 52.45.123.456
```

---

## 🧪 TESTAR CONFIGURAÇÃO

### Teste 1: Verificar DNS Online

Use ferramentas online:
- https://dnschecker.org/
- Digite: `inteligenciamax.com.br`
- Tipo: `A`
- Verifique se aparece o IP do Railway em várias localizações

Repita para:
- `www.inteligenciamax.com.br` (tipo CNAME)

### Teste 2: Acessar no Navegador

1. **Abra o navegador em modo anônimo/privado**

2. **Teste os URLs:**
   ```
   https://inteligenciamax.com.br
   https://www.inteligenciamax.com.br
   ```

3. **O que você deve ver:**
   - ✅ Página de login do OvoWpp
   - ✅ Certificado SSL válido (cadeado verde)
   - ✅ Sem erros de segurança

### Teste 3: Verificar HTTPS/SSL

1. O Railway gera certificados SSL automaticamente
2. Pode levar 5-15 minutos após DNS propagar
3. Verifique o cadeado verde no navegador

---

## 🔧 TROUBLESHOOTING

### Problema 1: "Site não encontrado" ou erro DNS

**Possíveis causas:**
- DNS ainda não propagou
- Registro mal configurado

**Solução:**
```bash
# Verificar se DNS está configurado
nslookup inteligenciamax.com.br

# Se não retornar IP, volte ao Registro.br e verifique:
# 1. Registro A está com o IP correto?
# 2. Você salvou as alterações?
# 3. Aguarde mais 15 minutos
```

### Problema 2: "Certificado SSL inválido"

**Possíveis causas:**
- Certificado ainda sendo gerado
- Railway não detectou o domínio

**Solução:**
1. Aguarde 15 minutos
2. No Railway, vá em Settings > Domains
3. Clique em "Refresh" ou "Regenerate Certificate"
4. Aguarde mais 5 minutos

### Problema 3: Site abre mas mostra erro 500

**Possíveis causas:**
- APP_URL não foi atualizado
- Aplicação precisa de cache clear

**Solução:**
1. Verifique variável APP_URL no Railway
2. No Railway, vá em serviço > Settings
3. Clique em "Restart" para forçar novo deploy

### Problema 4: www funciona mas domínio raiz não (ou vice-versa)

**Possíveis causas:**
- Falta registro A ou CNAME

**Solução:**
1. Verifique ambos registros no Registro.br
2. Certifique-se de que ambos domínios foram adicionados no Railway

### Problema 5: DNS propagou mas Railway não aceita

**Possíveis causas:**
- Railway não verificou ainda
- TTL muito alto

**Solução:**
1. No Railway, Settings > Domains
2. Remova e adicione o domínio novamente
3. Aguarde 5 minutos
4. Refresh da página

---

## ✅ CHECKLIST FINAL

Antes de considerar concluído, verifique:

### Registro.br:
- [ ] Registro A configurado (@ → IP Railway)
- [ ] Registro CNAME configurado (www → URL Railway)
- [ ] Alterações salvas

### Railway:
- [ ] Domínio customizado adicionado (inteligenciamax.com.br)
- [ ] Subdomínio www adicionado (www.inteligenciamax.com.br)
- [ ] Variável APP_URL atualizada
- [ ] Deploy concluído com sucesso

### Testes:
- [ ] nslookup retorna IP correto
- [ ] Site abre em https://inteligenciamax.com.br
- [ ] Site abre em https://www.inteligenciamax.com.br
- [ ] SSL/HTTPS funcionando (cadeado verde)
- [ ] Login admin funciona (/admin)

---

## 📞 SUPORTE

### Comandos Úteis para Debug:

```bash
# Verificar DNS
nslookup inteligenciamax.com.br
nslookup www.inteligenciamax.com.br

# Verificar com dig (mais detalhes)
dig inteligenciamax.com.br +short
dig www.inteligenciamax.com.br +short

# Verificar SSL
curl -I https://inteligenciamax.com.br

# Testar conexão HTTP
curl -v https://inteligenciamax.com.br
```

### Logs do Railway:

1. Dashboard Railway > Serviço ovowpp
2. Clique em "Deployments"
3. Clique no último deployment
4. Visualize os logs em tempo real

### Contatos de Suporte:

- **Railway:** https://railway.app/help
- **Registro.br:** suporte@registro.br ou (11) 5509-3511

---

## 🎉 PRONTO!

Após seguir todos os passos:

1. ✅ Seu domínio inteligenciamax.com.br estará apontando para o Railway
2. ✅ SSL/HTTPS configurado automaticamente
3. ✅ Aplicação OvoWpp acessível pelo domínio customizado
4. ✅ Redirecionamento www funcionando

**Próximas fases:**
- 🌍 Tradução para Português (pt_BR)
- 📱 Implementar Baileys QR Code
- 💬 WhatsApp Web Direct

---

**Data de criação:** 2025-10-21
**Versão:** 1.0
**Projeto:** OvoWpp - InteligenciaMax
