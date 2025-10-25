# 🎨 GUIA COMPLETO - CORES DO SISTEMA

**Data**: 25 de Outubro de 2025  
**Sistema**: Inteligência MAX - OvoWpp  
**Versão**: 1.0

---

## 📋 RESUMO EXECUTIVO

Este documento explica **TUDO** sobre as cores do sistema: onde estão configuradas, como funcionam e como alterar.

---

## 🎨 CORES ATUAIS DO SISTEMA

### 🔵 CORES PADRÃO CONFIGURADAS

| Área | Cor Atual | Código Hex | Onde Aparece |
|------|-----------|------------|--------------|
| **Admin Panel** | Azul | `#29B6F6` | Dashboard admin, botões, links |
| **User Dashboard** | Azul/Verde* | `#29B6F6` ou `#25d466` | Dashboard do usuário |
| **Landing Page** | Azul | `#29B6F6` | Página inicial, login |
| **Secundária** | Azul Escuro | `#004AAD` | Elementos secundários |
| **Accent** | Laranja | `#FF6600` | Destaques especiais |
| **Sucesso** | Verde | `#28a745` | Mensagens de sucesso |
| **Aviso** | Amarelo | `#ffc107` | Alertas |
| **Erro** | Vermelho | `#dc3545` | Mensagens de erro |
| **Info** | Azul Info | `#17a2b8` | Informações |

**\*Nota**: Existe conflito entre banco de dados e arquivos estáticos.

---

## 📁 ONDE AS CORES SÃO CONTROLADAS

### 1️⃣ **BANCO DE DADOS** (Principal)

**Tabela**: `general_settings`  
**Campo**: `base_color`  
**Valor Atual**: `29B6F6` (azul)  
**Caminho no Railway**: Database → MySQL → Query

```sql
-- Ver cor atual
SELECT base_color FROM general_settings WHERE id = 1;

-- Alterar cor (exemplo: verde)
UPDATE general_settings SET base_color = '25d466' WHERE id = 1;

-- Alterar cor (exemplo: roxo)
UPDATE general_settings SET base_color = '9C27B0' WHERE id = 1;
```

**⚠️ IMPORTANTE**: Esta é a cor do **Dashboard do Usuário** (user panel).

---

### 2️⃣ **ARQUIVO .ENV** (Configuração Ambiente)

**Arquivo**: `/home/user/webapp/.env` (Railway usa variáveis de ambiente)  
**Local no Git**: `.env.example` (template)

```env
# Cores principais
APP_PRIMARY_COLOR=#29B6F6       # Azul (cor principal)
APP_SECONDARY_COLOR=#004AAD     # Azul escuro
APP_ACCENT_COLOR=#FF6600        # Laranja

# Cores de status
APP_SUCCESS_COLOR=#28a745       # Verde
APP_WARNING_COLOR=#ffc107       # Amarelo
APP_DANGER_COLOR=#dc3545        # Vermelho
APP_INFO_COLOR=#17a2b8          # Azul info

# Gradientes
APP_GRADIENT_START=#29B6F6
APP_GRADIENT_END=#039BE5

# Modo escuro
APP_DARK_PRIMARY_COLOR=#1a1a1a
APP_DARK_SECONDARY_COLOR=#2d2d2d
```

**⚠️ IMPORTANTE**: Estas cores afetam **Landing Page** e podem sobrescrever outras.

---

### 3️⃣ **ARQUIVOS COLOR.PHP** (Gerador Dinâmico)

Existem **3 arquivos** color.php que geram CSS dinamicamente:

#### A) **Admin Panel Color**
**Arquivo**: `public/assets/admin/css/color.php`  
**Controla**: Dashboard do Admin  
**Fonte de Dados**: Lê do banco (`general_settings.base_color`)

```php
// Linha 20-21
$general = app('App\Models\GeneralSetting')->first();
$baseColor = $general->base_color ?? '29B6F6';
```

**Como funciona**:
1. Lê cor do banco de dados
2. Gera variações (light, dark)
3. Retorna CSS dinâmico
4. Navegador aplica automaticamente

#### B) **User Dashboard Color**
**Arquivo**: `public/assets/templates/basic/css/color.php`  
**Controla**: Dashboard do Usuário  
**Fonte de Dados**: Lê do `.env` E permite `?color=` na URL

```php
// Linha 40-46
if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
} elseif ($configLoaded && isset($themeConfig['primary'])) {
    $color = $themeConfig['primary']; // Do .env
} else {
    $color = "#29B6F6"; // Fallback
}
```

**Como funciona**:
1. Prioridade 1: `?color=` na URL
2. Prioridade 2: `.env` (`APP_PRIMARY_COLOR`)
3. Prioridade 3: Fallback `#29B6F6`
4. Gera CSS com variáveis HSL
5. Navegador aplica

#### C) **Assets Color (Cópia)**
**Arquivo**: `assets/templates/basic/css/color.php`  
**Controla**: Backup/Build do anterior  
**Nota**: Sincronizado com `public/assets/templates/basic/css/color.php`

---

### 4️⃣ **ARQUIVOS CSS CUSTOMIZADOS**

#### A) **Custom CSS - User Dashboard**
**Arquivo**: `public/assets/templates/basic/css/custom.css`  
**Tamanho**: 24KB  
**Controla**: Sobrescreve estilos específicos do usuário

```css
/* Exemplo de sobrescrita */
.btn--base {
    background: #29B6F6 !important; /* Força azul */
}

/* Gradientes específicos */
.gradient-primary {
    background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%);
}
```

#### B) **Beautiful CSS**
**Arquivo**: `public/assets/templates/basic/css/beautiful.css`  
**Tamanho**: 6.8KB  
**Controla**: Estilos visuais bonitos

#### C) **Custom Animation CSS**
**Arquivo**: `public/assets/templates/basic/css/custom-animation.css`  
**Tamanho**: 16KB  
**Controla**: Animações customizadas

---

## 🔧 HIERARQUIA DE CORES (Ordem de Aplicação)

### Para **Admin Panel**:
```
1. color.php (lê do banco) ← MAIS FORTE
2. CSS inline/específico
3. Bootstrap padrão
4. Fallback (#29B6F6)
```

### Para **User Dashboard**:
```
1. custom.css (!important) ← MAIS FORTE
2. color.php?color= (URL)
3. color.php (lê do .env)
4. Banco de dados (legacy)
5. Fallback (#29B6F6)
```

### Para **Landing Page**:
```
1. custom.css (!important) ← MAIS FORTE
2. .env (APP_PRIMARY_COLOR)
3. color.php
4. Fallback (#29B6F6)
```

---

## 🎯 COMO MUDAR AS CORES

### ✅ **Método 1: Via Banco de Dados** (Recomendado para User Dashboard)

**Passos**:
1. Acessar Railway → MySQL
2. Executar SQL:
```sql
UPDATE general_settings SET base_color = 'SUA_COR_SEM_#' WHERE id = 1;
```
3. Limpar cache do navegador
4. Recarregar dashboard do usuário

**Exemplos de cores**:
```sql
-- Verde
UPDATE general_settings SET base_color = '25d466' WHERE id = 1;

-- Roxo
UPDATE general_settings SET base_color = '9C27B0' WHERE id = 1;

-- Vermelho
UPDATE general_settings SET base_color = 'E53935' WHERE id = 1;

-- Azul atual
UPDATE general_settings SET base_color = '29B6F6' WHERE id = 1;
```

---

### ✅ **Método 2: Via Arquivo .ENV** (Recomendado para Landing Page)

**No Railway**:
1. Acessar projeto no Railway
2. Ir em "Variables"
3. Adicionar/Editar:
   - `APP_PRIMARY_COLOR` = `#SUA_COR`
   - `APP_GRADIENT_START` = `#SUA_COR`
   - `APP_GRADIENT_END` = `#COR_ESCURA`
4. Railway faz redeploy automático

**No Git**:
1. Editar `.env` (se existir localmente)
2. Fazer commit
3. Push para GitHub
4. Railway detecta e faz redeploy

---

### ✅ **Método 3: Via Admin Panel** (Futuro)

**⚠️ Ainda não implementado**, mas pode ser criado:

**Caminho planejado**: Settings → General Settings → Base Color

**Como implementar**:
1. Adicionar campo color picker no formulário
2. Salvar no banco (`general_settings.base_color`)
3. Limpar cache
4. Redirecionar

---

### ✅ **Método 4: Via CSS Customizado** (Avançado)

**Para mudanças específicas**:

**Arquivo**: `public/assets/templates/basic/css/custom.css`

```css
/* Adicionar no final do arquivo */

/* Mudar cor primária para verde */
:root {
    --primary-color: #25d466 !important;
    --primary-light: #4AE485 !important;
    --primary-dark: #1AB350 !important;
}

.btn--base,
.btn-primary {
    background: #25d466 !important;
    border-color: #25d466 !important;
}

.btn--base:hover,
.btn-primary:hover {
    background: #1AB350 !important;
    border-color: #1AB350 !important;
}
```

**Aplicar mudanças**:
```bash
git add public/assets/templates/basic/css/custom.css
git commit -m "style: Alterar cor primária para verde"
git push origin main
```

---

## 🗂️ ESTRUTURA DE ARQUIVOS NO GIT

```
/home/user/webapp/
│
├── .env.example                    ← Template de configuração
├── .env                            ← Configuração real (Railway)
│
├── public/
│   ├── assets/
│   │   ├── admin/
│   │   │   └── css/
│   │   │       └── color.php       ← 🎨 ADMIN PANEL (lê do banco)
│   │   │
│   │   └── templates/
│   │       └── basic/
│   │           ├── css/
│   │           │   ├── color.php   ← 🎨 USER DASHBOARD (lê do .env)
│   │           │   ├── custom.css  ← 🎨 SOBRESCRITAS
│   │           │   ├── beautiful.css
│   │           │   ├── custom-animation.css
│   │           │   └── main.css
│   │           │
│   │           └── images/         ← Logos, favicons
│   │
│   └── forcar_verde_agora.php      ← Script para forçar cor verde
│
├── assets/
│   └── templates/
│       └── basic/
│           └── css/
│               └── color.php       ← 🎨 BACKUP (sincronizado)
│
└── resources/
    └── views/
        └── templates/
            └── basic/
                └── layouts/        ← Templates que carregam CSS
```

---

## 🎨 PALETA DE CORES RECOMENDADAS

### **Azul (Atual)**
```
Primária:    #29B6F6 (Light Blue 400)
Secundária:  #039BE5 (Light Blue 600)
Escura:      #004AAD (Blue 800)
```

### **Verde (Alternativa)**
```
Primária:    #25d466 (Green 400)
Secundária:  #1AB350 (Green 500)
Escura:      #0F8939 (Green 700)
```

### **Roxo (Alternativa)**
```
Primária:    #9C27B0 (Purple 500)
Secundária:  #7B1FA2 (Purple 600)
Escura:      #4A148C (Purple 900)
```

### **Laranja (Alternativa)**
```
Primária:    #FF6F00 (Orange 900)
Secundária:  #E65100 (Deep Orange 900)
Escura:      #BF360C (Deep Orange A700)
```

### **Vermelho (Alternativa)**
```
Primária:    #E53935 (Red 600)
Secundária:  #C62828 (Red 800)
Escura:      #B71C1C (Red 900)
```

---

## 🔍 DIFERENÇAS ENTRE ADMIN E USER

### **Admin Panel** (Dashboard Admin)
- **Cor**: Lê do banco de dados
- **Arquivo**: `public/assets/admin/css/color.php`
- **Controle**: SQL direto
- **Usuários**: Apenas administradores
- **Customização**: Menos flexível

### **User Dashboard** (Dashboard Usuário)
- **Cor**: Lê do `.env` primeiro
- **Arquivo**: `public/assets/templates/basic/css/color.php`
- **Controle**: Variáveis de ambiente Railway
- **Usuários**: Clientes da plataforma
- **Customização**: Mais flexível (suporta `?color=` na URL)

### **Landing Page** (Página Inicial)
- **Cor**: Lê do `.env` e `custom.css`
- **Arquivo**: `public/assets/templates/basic/css/custom.css`
- **Controle**: Git + Railway env
- **Usuários**: Visitantes públicos
- **Customização**: Muito flexível

---

## 🛠️ SCRIPTS UTILITÁRIOS DISPONÍVEIS

### 1. **Forçar Cor Verde**
**Arquivo**: `public/forcar_verde_agora.php`  
**URL**: https://inteligenciamax.com.br/forcar_verde_agora.php  
**Função**: Altera cor do banco para verde `#25d466`

### 2. **Debug de Cor**
**Arquivo**: `public/debug_cor.php`  
**URL**: https://inteligenciamax.com.br/debug_cor.php  
**Função**: Mostra cor atual do banco

### 3. **Verificar Cor**
**Arquivo**: `public/verificar_cor.php`  
**URL**: https://inteligenciamax.com.br/verificar_cor.php  
**Função**: Verifica configuração de cores

---

## 📊 CHECKLIST DE MUDANÇA DE COR

### ✅ **Para Mudar Cor do Admin Panel**:
1. [ ] Conectar no banco MySQL (Railway)
2. [ ] Executar SQL: `UPDATE general_settings SET base_color = 'NOVA_COR' WHERE id = 1;`
3. [ ] Limpar cache do navegador (Ctrl + Shift + R)
4. [ ] Acessar `/admin` e verificar
5. [ ] ✓ Pronto!

### ✅ **Para Mudar Cor do User Dashboard**:
1. [ ] Acessar Railway → Variáveis
2. [ ] Editar `APP_PRIMARY_COLOR` = `#NOVA_COR`
3. [ ] Editar `APP_GRADIENT_START` = `#NOVA_COR`
4. [ ] Editar `APP_GRADIENT_END` = `#COR_ESCURA`
5. [ ] Aguardar redeploy (~2 min)
6. [ ] Limpar cache do navegador
7. [ ] Acessar `/user/dashboard` e verificar
8. [ ] ✓ Pronto!

### ✅ **Para Mudar Cor da Landing Page**:
1. [ ] Editar `public/assets/templates/basic/css/custom.css`
2. [ ] Adicionar/modificar variáveis CSS `:root`
3. [ ] Fazer commit e push
4. [ ] Aguardar deploy Railway
5. [ ] Limpar cache (Ctrl + Shift + R)
6. [ ] Acessar `/` e verificar
7. [ ] ✓ Pronto!

---

## 🚨 PROBLEMAS COMUNS

### ❌ **Problema 1**: "Mudei a cor mas não aparece"
**Solução**: Limpar cache do navegador (Ctrl + Shift + R)

### ❌ **Problema 2**: "Admin e User têm cores diferentes"
**Causa**: São controlados por fontes diferentes  
**Solução**: Mudar ambos (banco + .env)

### ❌ **Problema 3**: "Cor volta para azul"
**Causa**: Cache ou color.php com fallback  
**Solução**: Verificar se mudança foi salva no banco

### ❌ **Problema 4**: "!important não funciona"
**Causa**: Outro !important mais específico  
**Solução**: Aumentar especificidade do seletor CSS

---

## 📞 LINKS E REFERÊNCIAS

### Arquivos Importantes:
- `.env.example` - Template de configuração
- `public/assets/admin/css/color.php` - Cores do admin
- `public/assets/templates/basic/css/color.php` - Cores do user
- `public/assets/templates/basic/css/custom.css` - Sobrescritas

### Scripts Utilitários:
- https://inteligenciamax.com.br/forcar_verde_agora.php
- https://inteligenciamax.com.br/debug_cor.php
- https://inteligenciamax.com.br/verificar_cor.php

### Banco de Dados:
- Tabela: `general_settings`
- Campo: `base_color`
- Query: `SELECT base_color FROM general_settings WHERE id = 1;`

---

## ✅ CONCLUSÃO

### 🎨 **3 Sistemas de Cores Diferentes**:

1. **Admin Panel**: Controlado pelo banco de dados
2. **User Dashboard**: Controlado por `.env` (Railway)
3. **Landing Page**: Controlado por `.env` + `custom.css`

### 🔧 **Para Mudar Cores**:
- **Rápido**: SQL no banco (admin) ou Railway env (user)
- **Permanente**: Git + commit + push
- **Específico**: Editar `custom.css` diretamente

### 🚀 **Sistema Flexível e Customizável**!

---

**Documento criado em**: 25/10/2025 04:30 UTC  
**Versão**: 1.0.0  
**Autor**: Claude AI (GenSpark)
