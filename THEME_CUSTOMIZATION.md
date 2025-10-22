# 🎨 Guia de Customização de Tema - InteligenciaMax

Este documento explica como personalizar completamente a identidade visual da plataforma **InteligenciaMax**.

---

## 📋 Índice

1. [Configuração Rápida](#configuração-rápida)
2. [Cores do Tema](#cores-do-tema)
3. [Logotipos e Ícones](#logotipos-e-ícones)
4. [Tipografia](#tipografia)
5. [Design System](#design-system)
6. [Funções Auxiliares](#funções-auxiliares)
7. [Componentes CSS](#componentes-css)
8. [Limpeza de Cache](#limpeza-de-cache)
9. [Troubleshooting](#troubleshooting)

---

## 🚀 Configuração Rápida

### 1. Editar o arquivo `.env`

Abra o arquivo `.env` na raiz do projeto e configure as variáveis do tema:

```env
# Cores Primárias
APP_PRIMARY_COLOR=#FF6600        # Cor principal da marca
APP_SECONDARY_COLOR=#1B1B1B      # Cor secundária
APP_ACCENT_COLOR=#FFD700         # Cor de destaque

# Logotipos (caminhos relativos à pasta public/)
APP_LOGO_LIGHT=assets/images/brand/logo.png
APP_LOGO_DARK=assets/images/brand/logo-dark.png
APP_FAVICON=assets/images/brand/favicon.png

# Tipografia
APP_FONT_PRIMARY="Poppins, sans-serif"
APP_FONT_HEADING="Montserrat, sans-serif"
```

### 2. Substituir os arquivos de logo

Coloque seus arquivos de logo na pasta especificada:

```
public/
  assets/
    images/
      brand/                    # Crie esta pasta
        logo.png               # Logo para fundo claro
        logo-dark.png          # Logo para fundo escuro
        favicon.png            # Ícone do site
```

**Especificações recomendadas:**
- **Logo**: PNG transparente, 200x50px (altura recomendada)
- **Favicon**: PNG ou ICO, 32x32px ou 64x64px

### 3. Limpar o cache

Execute os comandos no terminal:

```bash
php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear
```

### 4. Recarregar o navegador

Pressione `Ctrl + F5` (ou `Cmd + Shift + R` no Mac) para forçar o reload com limpeza de cache.

---

## 🎨 Cores do Tema

### Cores Principais

```env
APP_PRIMARY_COLOR=#29B6F6        # Azul principal
APP_SECONDARY_COLOR=#004AAD      # Azul escuro
APP_ACCENT_COLOR=#FF6600         # Laranja destaque
```

### Cores de Status

```env
APP_SUCCESS_COLOR=#28a745        # Verde (sucesso)
APP_WARNING_COLOR=#ffc107        # Amarelo (aviso)
APP_DANGER_COLOR=#dc3545         # Vermelho (erro)
APP_INFO_COLOR=#17a2b8           # Azul claro (info)
```

### Gradientes

```env
APP_GRADIENT_START=#29B6F6       # Início do gradiente
APP_GRADIENT_END=#039BE5         # Fim do gradiente
```

**Como testar cores:**
Use um seletor de cores online como [Coolors.co](https://coolors.co/) ou [Adobe Color](https://color.adobe.com/) para criar paletas harmoniosas.

---

## 🖼️ Logotipos e Ícones

### Estrutura de Arquivos

```
public/assets/images/
  logo_icon/              # Pasta padrão do sistema
    logo.png             # Logo principal
    logo_dark.png        # Logo para modo escuro
    favicon.png          # Favicon
  brand/                 # Sua pasta personalizada (criar)
    logo.png
    logo-dark.png
    favicon.png
```

### Configuração no `.env`

```env
# Usar a pasta padrão
APP_LOGO_LIGHT=assets/images/logo_icon/logo.png
APP_LOGO_DARK=assets/images/logo_icon/logo_dark.png
APP_FAVICON=assets/images/logo_icon/favicon.png

# OU usar sua pasta personalizada
APP_LOGO_LIGHT=assets/images/brand/logo.png
APP_LOGO_DARK=assets/images/brand/logo-dark.png
APP_FAVICON=assets/images/brand/favicon.png
```

### Dimensões do Logo

```env
APP_LOGO_HEIGHT=50px             # Altura do logo
APP_LOGO_WIDTH=auto              # Largura (auto mantém proporção)
```

### Usando Logo nas Views

**Método 1: Função Helper**
```blade
<img src="{{ siteLogo('light') }}" alt="Logo">
<img src="{{ siteLogo('dark') }}" alt="Logo Dark">
```

**Método 2: Componente Blade**
```blade
<x-theme-logo type="light" height="50px" />
<x-theme-logo type="dark" height="60px" class="my-custom-class" />
<x-theme-logo type="icon" width="32px" />
```

---

## ✍️ Tipografia

### Fontes Personalizadas

```env
# Fonte principal (corpo do texto)
APP_FONT_PRIMARY="Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif"

# Fonte secundária
APP_FONT_SECONDARY="Montserrat, sans-serif"

# Fonte de títulos
APP_FONT_HEADING="Poppins, sans-serif"
```

### Importar Google Fonts

Edite o arquivo `resources/views/templates/basic/layouts/app.blade.php`:

```blade
<head>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Resto do código... -->
</head>
```

### Tamanhos de Fonte

```env
APP_FONT_SIZE=14px               # Tamanho base
APP_FONT_SIZE_HEADING=24px       # Tamanho dos títulos
```

---

## 🎭 Design System

### Bordas e Raios

```env
APP_BORDER_RADIUS=8px            # Raio de borda padrão
APP_BORDER_RADIUS_LARGE=16px     # Raio grande (cards, modais)
```

### Sombras

```env
APP_BOX_SHADOW="0 2px 8px rgba(0,0,0,0.1)"
APP_BOX_SHADOW_HOVER="0 4px 16px rgba(0,0,0,0.15)"
```

### Espaçamentos

```env
APP_SPACING_UNIT=8px             # Unidade base de espaçamento
```

### Layout

```env
APP_SIDEBAR_WIDTH=260px          # Largura da sidebar
APP_TOPBAR_HEIGHT=70px           # Altura da barra superior
```

### Modo Escuro

```env
APP_DARK_MODE_ENABLED=true
APP_DARK_PRIMARY_COLOR=#1a1a1a
APP_DARK_SECONDARY_COLOR=#2d2d2d
```

### Animações

```env
APP_ANIMATION_DURATION=0.3s
APP_ANIMATION_EASING=ease-in-out
```

---

## 🔧 Funções Auxiliares

### PHP Helpers

Use estas funções em qualquer arquivo `.blade.php`:

```php
// Retorna URL do logo
{{ themeLogo('light') }}        // Logo claro
{{ themeLogo('dark') }}         // Logo escuro
{{ themeLogo('icon') }}         // Ícone

// Retorna URL do favicon
{{ themeFavicon() }}

// Retorna uma cor
{{ themeColor('primary') }}     // #29B6F6
{{ themeColor('secondary') }}   // #004AAD

// Retorna gradiente CSS
{{ themeGradient('135deg') }}   // linear-gradient(135deg, ...)

// Retorna fonte
{{ themeFont('primary') }}      // Inter, sans-serif
{{ themeFont('heading') }}      // Poppins, sans-serif

// Retorna qualquer config
{{ themeConfig('border_radius') }}        // 8px
{{ themeConfig('logo_height') }}          // 50px
```

### Variáveis CSS

Use estas variáveis em arquivos `.css` ou `<style>`:

```css
/* Cores */
var(--theme-primary)
var(--theme-secondary)
var(--theme-accent)
var(--theme-success)
var(--theme-warning)
var(--theme-danger)
var(--theme-info)

/* Tipografia */
var(--theme-font-primary)
var(--theme-font-heading)

/* Layout */
var(--theme-border-radius)
var(--theme-logo-height)

/* Gradientes */
var(--gradient-primary)
var(--gradient-secondary)
```

**Exemplo de uso:**

```css
.meu-botao {
    background-color: var(--theme-primary);
    font-family: var(--theme-font-primary);
    border-radius: var(--theme-border-radius);
}

.meu-card {
    background: var(--gradient-primary);
}
```

---

## 🧩 Componentes CSS

O arquivo `public/assets/theme/theme-custom.css` fornece classes prontas:

### Botões

```html
<button class="btn-theme-primary">Botão Primário</button>
<button class="btn-theme-secondary">Botão Secundário</button>
<button class="btn-theme-accent">Botão Destaque</button>
```

### Cards

```html
<div class="card card-theme-primary">
    <div class="card-header">Título</div>
    <div class="card-body">Conteúdo</div>
</div>
```

### Badges

```html
<span class="badge badge-theme-primary">Novo</span>
<span class="badge badge-theme-secondary">Premium</span>
<span class="badge badge-theme-accent">Hot</span>
```

### Alerts

```html
<div class="alert alert-theme-info">
    Mensagem informativa
</div>
```

### Cores de Texto

```html
<p class="text-theme-primary">Texto na cor primária</p>
<p class="text-theme-secondary">Texto na cor secundária</p>
```

### Cores de Fundo

```html
<div class="bg-theme-primary">Fundo primário</div>
<div class="bg-theme-secondary">Fundo secundário</div>
```

### Gradientes

```html
<div class="gradient-theme-primary">
    Fundo com gradiente primário
</div>
```

### Animações

```html
<div class="fade-in">Aparece com fade</div>
<div class="slide-in">Desliza da esquerda</div>
```

---

## 🧹 Limpeza de Cache

### Via Terminal (SSH/Railway)

```bash
cd /home/user/webapp

# Limpar todos os caches
php artisan optimize:clear

# OU limpar individualmente
php artisan config:clear      # Cache de configuração
php artisan view:clear         # Cache de views
php artisan cache:clear        # Cache geral
php artisan route:clear        # Cache de rotas
```

### Via Navegador

Após limpar o cache do servidor, limpe o cache do navegador:

**Chrome/Edge:**
- `Ctrl + Shift + Delete` → Selecionar "Imagens e arquivos em cache"
- OU `Ctrl + F5` na página

**Firefox:**
- `Ctrl + Shift + Delete` → Selecionar "Cache"
- OU `Ctrl + Shift + R` na página

**Safari:**
- `Cmd + Option + E` para limpar cache
- OU `Cmd + Shift + R` na página

---

## 🔍 Troubleshooting

### Problema: Cores não mudam após editar `.env`

**Solução:**
1. Verificar se as variáveis estão corretas no `.env`
2. Limpar cache: `php artisan config:clear`
3. Recarregar página com `Ctrl + F5`

### Problema: Logo não aparece

**Solução:**
1. Verificar se o caminho no `.env` está correto
2. Verificar se o arquivo existe em `public/[caminho]`
3. Verificar permissões: `chmod 644 public/assets/images/brand/*.png`
4. Limpar cache de views: `php artisan view:clear`

### Problema: Fontes não carregam

**Solução:**
1. Verificar se o link do Google Fonts está no `<head>`
2. Verificar se o nome da fonte está entre aspas no `.env`:
   ```env
   APP_FONT_PRIMARY="Poppins, sans-serif"
   ```
3. Limpar cache do navegador

### Problema: CSS customizado não aplica

**Solução:**
1. Verificar se `theme-custom.css` existe em `public/assets/theme/`
2. Verificar se o link está no layout:
   ```blade
   <link rel="stylesheet" href="{{ asset('assets/theme/theme-custom.css') }}">
   ```
3. Adicionar `?v={{ time() }}` no final do link para forçar reload
4. Limpar cache

### Problema: Variáveis CSS não funcionam

**Solução:**
1. Verificar se as variáveis estão definidas no `<style>` do layout
2. Usar fallback nas propriedades CSS:
   ```css
   background-color: var(--theme-primary, #29B6F6);
   ```
3. Verificar compatibilidade do navegador (IE11 não suporta CSS vars)

---

## 📚 Referências

### Arquivos de Configuração

- **Config Principal**: `config/theme.php`
- **Variáveis de Ambiente**: `.env`
- **CSS Dinâmico**: `assets/templates/basic/css/color.php`
- **CSS Customizado**: `public/assets/theme/theme-custom.css`
- **Helpers PHP**: `app/Http/Helpers/helpers.php`

### Layouts Principais

- **User Layout**: `resources/views/templates/basic/layouts/app.blade.php`
- **Admin Layout**: `resources/views/admin/layouts/master.blade.php`
- **User Sidebar**: `resources/views/templates/basic/partials/sidebar.blade.php`
- **Admin Sidebar**: `resources/views/admin/partials/sidenav.blade.php`

### Componentes

- **Theme Logo**: `resources/views/components/theme-logo.blade.php`

---

## 🎯 Checklist de Rebranding

Use este checklist para garantir um rebranding completo:

- [ ] Definir paleta de cores (primária, secundária, accent)
- [ ] Criar logos (light, dark, favicon) nas dimensões corretas
- [ ] Configurar variáveis no `.env`
- [ ] Substituir arquivos de logo na pasta `public/assets/images/`
- [ ] Selecionar e configurar fontes (Google Fonts ou custom)
- [ ] Limpar todos os caches (`php artisan optimize:clear`)
- [ ] Testar no navegador (modo claro e escuro)
- [ ] Verificar responsividade (mobile, tablet, desktop)
- [ ] Testar em diferentes navegadores (Chrome, Firefox, Safari)
- [ ] Validar painel Admin
- [ ] Validar área do Usuário
- [ ] Validar páginas públicas (Home, Login, Registro)
- [ ] Confirmar favicon em todas as páginas
- [ ] Documentar alterações para a equipe

---

## 💡 Dicas de Design

### Escolha de Cores

1. **Contraste**: Certifique-se de que o texto é legível sobre fundos coloridos
2. **Acessibilidade**: Use ferramentas como [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
3. **Consistência**: Use no máximo 3-4 cores principais
4. **Psicologia**: Cores transmitem emoções (azul = confiança, verde = crescimento, laranja = energia)

### Tipografia

1. **Legibilidade**: Fontes sans-serif são mais legíveis em telas
2. **Hierarquia**: Use tamanhos e pesos diferentes para criar hierarquia
3. **Contraste**: Combine fontes diferentes para títulos e corpo (ex: Poppins + Inter)
4. **Carregamento**: Use `font-display: swap` para evitar FOIT (Flash of Invisible Text)

### Logos

1. **Formatos**: PNG transparente para web, SVG para escalabilidade
2. **Versões**: Sempre tenha versões para fundo claro e escuro
3. **Espaçamento**: Mantenha área de respiro ao redor do logo
4. **Tamanho**: Otimize arquivos (use TinyPNG ou similar)

---

## 🆘 Suporte

Para questões específicas sobre customização de tema:

1. Consulte este documento primeiro
2. Verifique o arquivo `config/theme.php` para opções disponíveis
3. Revise os helpers em `app/Http/Helpers/helpers.php`
4. Inspecione os componentes em `public/assets/theme/theme-custom.css`

---

**Última atualização**: 2025-10-22  
**Versão do sistema**: InteligenciaMax 1.3  
**Autor**: Equipe de Desenvolvimento
