# 🚨 AÇÃO NECESSÁRIA - REVERTER CORES DA DASHBOARD

## ⚠️ PROBLEMA IDENTIFICADO

A cor azul (#29B6F6) foi aplicada **globalmente** no banco de dados, afetando TODAS as páginas incluindo a **dashboard do usuário**.

## ✅ SOLUÇÃO IMPLEMENTADA

### 1. CSS Específico por Página
Foi criado CSS que aplica cores diferentes para cada área:
- **Landing Page** (`/`): AZUL #29B6F6 ✅
- **Login Page** (`/user/login`): AZUL #29B6F6 ✅
- **Dashboard** (`/user/dashboard`): VERDE #25d466 (cores originais) ✅

### 2. SQL que DEVE Ser Executado no Banco de Dados

**⚠️ IMPORTANTE: Execute este SQL no banco de dados do Railway:**

```sql
-- Reverter cor da dashboard para VERDE original
UPDATE general_settings SET base_color = '25d466' WHERE id = 1;
```

**Como executar:**
1. Acesse o painel do Railway
2. Vá em MySQL Database
3. Abra o Query Editor
4. Execute o comando acima
5. Verifique com: `SELECT base_color FROM general_settings WHERE id = 1;`

## 📋 ARQUIVOS ALTERADOS

### CSS Modificado
- `public/assets/templates/basic/css/custom.css`
- `assets/templates/basic/css/custom.css`

### SQL Criado
- `REVERTER_COR_DASHBOARD_VERDE.sql` - Script pronto para executar

## 🎨 COMPORTAMENTO ESPERADO

### ANTES (❌ ERRADO)
- Landing page: AZUL
- Login: AZUL  
- Dashboard: AZUL ← **ERRO!**

### DEPOIS (✅ CORRETO)
- Landing page: AZUL
- Login: AZUL
- Dashboard: VERDE (cores originais da OvoWpp)

## 🔧 O QUE FOI MANTIDO

✅ **Fonte Jost** aplicada globalmente em TODAS as páginas
✅ **Traduções PT-BR** mantidas
✅ **Header transparente** na página de login

## 📝 NOTAS TÉCNICAS

O arquivo `color.php` gera cores dinamicamente a partir do campo `base_color` no banco:
- Esse campo está atualmente com valor `29B6F6` (azul)
- Precisa ser revertido para `25d466` (verde) 
- O CSS agora sobrescreve apenas para frontend (landing + login)
- Dashboard usará as cores do banco de dados (verde após o UPDATE)

## ⚡ AÇÃO IMEDIATA NECESSÁRIA

1. **EXECUTAR SQL** no banco de dados do Railway
2. Fazer deploy do código atualizado
3. Limpar cache do navegador e testar

---

**Criado em:** 2025-10-24  
**Commit relacionado:** fea846b (será atualizado)
