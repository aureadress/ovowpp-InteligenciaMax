# 🚀 INSTRUÇÕES RÁPIDAS: Configurar DNS e WWW

## 📌 Resposta à sua pergunta:

### ❌ NÃO! 
`inteligenciamax.com.br` **NÃO** vai funcionar se você configurar apenas `www.inteligenciamax.com.br`

### ✅ São registros DNS DIFERENTES!

```
inteligenciamax.com.br       ← Domínio RAIZ (precisa de registro @)
www.inteligenciamax.com.br   ← SUBDOMÍNIO (precisa de registro www)
```

---

## 🎯 O QUE FAZER (em ordem):

### 1️⃣ No Railway - Adicionar domínios PRIMEIRO:

```
Settings → Domains → + Custom Domain

1. inteligenciamax.com.br       ← Railway mostrará um IP
2. www.inteligenciamax.com.br   ← Railway mostrará CNAME
```

⚠️ **ANOTE O IP que Railway mostrar para o domínio raiz!**

### 2️⃣ No Registro.br - Adicionar DOIS registros:

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃  TIPO  │  NOME  │  VALOR                    ┃
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃  A     │   @    │ XXX.XXX.XXX.XXX           ┃ ← IP do Railway
┃  CNAME │  www   │ ikz4ue6o.up.railway.app.  ┃ ← CNAME do Railway
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
```

⚠️ **Importante:** 
- Registro.br **NÃO aceita CNAME no @**
- Use registro **A** (tipo Address) para o domínio raiz
- Use **CNAME** apenas para www

### 3️⃣ No Railway - Atualizar variável de ambiente:

```
Variables → Edit

APP_URL=https://www.inteligenciamax.com.br
APP_ENV=production
```

Depois: **Redeploy**

---

## 🔄 O que acontece depois (automático):

✅ **Código já está pronto!**

O middleware `ForceWWW` já foi implementado e ativado:

```
inteligenciamax.com.br 
        ⬇ (redirect 301 - automático)
www.inteligenciamax.com.br ✅
```

Isso significa:
- ✅ Se alguém digitar `inteligenciamax.com.br`, será redirecionado para `www.inteligenciamax.com.br`
- ✅ Se alguém digitar `www.inteligenciamax.com.br`, permanece lá
- ✅ Ambos os domínios funcionam!
- ✅ Google vê apenas uma versão (SEO otimizado)

---

## ⏱️ Tempo de Propagação DNS:

```
Mínimo:  2 horas
Médio:   6 horas
Máximo:  48 horas
```

**Verificar em:** https://dnschecker.org

---

## ✅ Checklist:

- [ ] Adicionei `inteligenciamax.com.br` no Railway (anotei o IP)
- [ ] Adicionei `www.inteligenciamax.com.br` no Railway
- [ ] Adicionei registro **A** com `@` e o IP no Registro.br
- [ ] Adicionei registro **CNAME** com `www` no Registro.br
- [ ] Configurei `APP_URL=https://www.inteligenciamax.com.br` no Railway
- [ ] Fiz Redeploy no Railway
- [ ] Aguardei 2-24h para propagação DNS
- [ ] Testei: http://inteligenciamax.com.br (deve redirecionar)
- [ ] Testei: https://www.inteligenciamax.com.br (deve carregar)

---

## 🎉 Resultado Final:

Ambos os domínios funcionarão:

```
✅ inteligenciamax.com.br       → (redirect) → www.inteligenciamax.com.br
✅ www.inteligenciamax.com.br   → (carrega o site)
```

---

## 📚 Documentação Completa:

- **⚠️ SOLUÇÃO CNAME:** `SOLUCAO_DNS_REGISTRO_BR.md` ← **LEIA ISSO!**
- **Guia DNS Completo:** `DNS_COMPLETO_RAILWAY.md`
- **Configurar Redirecionamento:** `CONFIGURAR_WWW_REDIRECT.md`
- **Resumo Executivo:** `RESUMO_CONFIGURACAO_WWW.md`

---

## 🔗 Links Úteis:

- **Registro.br:** https://registro.br (Configurar DNS aqui)
- **Railway:** https://railway.app (Adicionar domínios aqui)
- **DNS Checker:** https://dnschecker.org (Verificar propagação)
- **Pull Request:** https://github.com/aureadress/ovowpp-InteligenciaMax/pull/2

---

**💡 Dica:** Depois de configurar tudo, pode levar até 24 horas para funcionar completamente. Seja paciente! 😊
