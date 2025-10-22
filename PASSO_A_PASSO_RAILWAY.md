# 🚀 GUIA PASSO A PASSO - Railway MySQL

## ⚠️ O ADMIN DEU ERRO? USE ESTE MÉTODO!

---

## 📋 **MÉTODO GARANTIDO - Executar SQL no Railway**

### **PASSO 1: Acessar o Railway**

1. Acesse: https://railway.app
2. Faça login
3. Selecione o projeto: **OvoWpp / Inteligência MAX**

---

### **PASSO 2: Abrir o MySQL**

1. No Dashboard do Railway, procure o serviço **MySQL**
2. Clique no card do MySQL (ícone de banco de dados)
3. Você verá as abas: Data, Variables, Settings, etc.

---

### **PASSO 3: Abrir a Query**

Existem 2 formas:

#### **Opção A: Aba "Data"**
1. Clique na aba **"Data"**
2. Você verá uma interface para executar queries
3. No campo de texto, cole o script SQL

#### **Opção B: Aba "Query" (se disponível)**
1. Procure pela aba **"Query"**
2. Abrirá um editor SQL
3. Cole o script SQL

---

### **PASSO 4: Copiar o Script SQL**

Copie TODO o conteúdo do arquivo:
```
SOLUCAO_RAPIDA_PORTUGUES.sql
```

**OU copie direto daqui:**

```sql
-- Remover idioma PT antigo
DELETE FROM languages WHERE code = 'pt';

-- Inserir Português Brasil
INSERT INTO languages (name, code, info, image, is_default, created_at, updated_at) 
VALUES ('Português Brasil', 'pt', 'Idioma oficial do Brasil', 'pt.png', 1, NOW(), NOW());

-- Desativar outros idiomas
UPDATE languages SET is_default = 0 WHERE code != 'pt';

-- Verificar resultado
SELECT id, name, code, is_default FROM languages ORDER BY is_default DESC;
```

---

### **PASSO 5: Executar o Script**

1. Cole o script no editor
2. Clique em **"Execute"** ou **"Run Query"** ou **"►"**
3. Aguarde a execução (2-5 segundos)

---

### **PASSO 6: Verificar Resultado**

Você deve ver algo como:

```
+----+-----------------+------+------------+
| id | name            | code | is_default |
+----+-----------------+------+------------+
|  5 | Português Brasil| pt   | 1          | ✅
|  1 | English         | en   | 0          |
|  2 | Español         | es   | 0          |
+----+-----------------+------+------------+
```

**✅ O idioma PT deve ter `is_default = 1`**

---

### **PASSO 7: Limpar Cache**

#### No Navegador:
1. Pressione **Ctrl + Shift + Delete** (Windows/Linux)
2. Ou **Cmd + Shift + Delete** (Mac)
3. Marque: "Cookies e dados de sites" e "Imagens e arquivos em cache"
4. Clique em "Limpar dados"

#### Na Plataforma (se possível):
1. Acesse: `https://inteligenciamax.com.br/admin/system/cache`
2. Clique em "Clear All Cache"

---

### **PASSO 8: Testar**

1. Faça **Logout** do admin
2. Feche o navegador completamente
3. Abra novamente
4. Acesse: `https://inteligenciamax.com.br/admin`
5. Faça login

**🎉 PRONTO! Tudo estará em PORTUGUÊS!**

---

## 🔧 **ALTERNATIVA - MySQL Workbench/phpMyAdmin**

Se você tem acesso via cliente MySQL:

### **Credenciais (do .env.example):**
```
Host: metro.proxy.rlwy.net
Port: 37078
Database: railway
User: root
Password: ScZRjMeixWGFsfnbORMNCUxTCERaVbIq
```

### **Passos:**
1. Abra MySQL Workbench ou phpMyAdmin
2. Crie nova conexão com as credenciais acima
3. Conecte
4. Execute o script SQL
5. Pronto!

---

## 📱 **ALTERNATIVA 2 - Railway CLI**

Se você tem Railway CLI instalado:

```bash
# 1. Fazer login
railway login

# 2. Conectar ao projeto
railway link

# 3. Conectar ao MySQL
railway connect mysql

# 4. Dentro do MySQL, executar:
DELETE FROM languages WHERE code = 'pt';
INSERT INTO languages (name, code, info, image, is_default, created_at, updated_at) 
VALUES ('Português Brasil', 'pt', 'Idioma oficial do Brasil', 'pt.png', 1, NOW(), NOW());
UPDATE languages SET is_default = 0 WHERE code != 'pt';
SELECT id, name, code, is_default FROM languages;

# 5. Sair
exit;
```

---

## 🐛 **RESOLUÇÃO DE PROBLEMAS**

### Problema 1: "Permission denied" ou "Access denied"
**Solução:**
- Verifique se você tem permissão de admin no Railway
- Tente usar o usuário root do banco

### Problema 2: "Table 'languages' doesn't exist"
**Solução:**
- Verifique se está conectado no banco correto: `railway`
- Execute: `SHOW TABLES;` para listar tabelas
- Se não existir, o banco pode não estar importado

### Problema 3: Script executou mas não mudou
**Solução:**
```sql
-- Force a mudança
UPDATE languages SET is_default = 0;
UPDATE languages SET is_default = 1 WHERE code = 'pt';
```

### Problema 4: Ainda aparece em inglês
**Solução:**
1. Limpe cache do navegador (Ctrl+Shift+Del)
2. Faça logout
3. Feche TODAS as abas da plataforma
4. Abra em aba anônima/privada
5. Faça login novamente

### Problema 5: Erro "Duplicate entry"
**Solução:**
```sql
-- Remova primeiro
DELETE FROM languages WHERE code = 'pt';
-- Depois insira novamente
INSERT INTO languages (name, code, info, image, is_default, created_at, updated_at) 
VALUES ('Português Brasil', 'pt', 'Idioma oficial do Brasil', 'pt.png', 1, NOW(), NOW());
```

---

## ✅ **CHECKLIST DE VERIFICAÇÃO**

Antes de considerar concluído, verifique:

- [ ] Script SQL executado sem erros
- [ ] Query de verificação mostra `is_default = 1` apenas para PT
- [ ] Cache do navegador limpo
- [ ] Logout feito
- [ ] Login novo realizado
- [ ] Interface em português

---

## 📞 **AINDA COM PROBLEMAS?**

Se NADA funcionar, pode ser que:

1. **O arquivo pt.json não existe** (improvável, pois vimos que existe)
2. **Permissões do arquivo** (verificar com `ls -la resources/lang/pt.json`)
3. **Cache do Laravel** não foi limpo

**Neste caso, me avise e vou criar um script PHP para executar direto no servidor!**

---

## 🎯 **RESUMO SUPER RÁPIDO**

```sql
DELETE FROM languages WHERE code = 'pt';
INSERT INTO languages VALUES (NULL, 'Português Brasil', 'pt', 'Idioma oficial', 'pt.png', 1, NOW(), NOW());
UPDATE languages SET is_default = 0 WHERE code != 'pt';
```

**Cole isso no Railway MySQL Query → Execute → Pronto!** 🚀

---

**Criado em:** 22/10/2025  
**Método:** Direct SQL via Railway  
**Tempo estimado:** 2-5 minutos
