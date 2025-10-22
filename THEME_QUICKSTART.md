# 🚀 Guia Rápido de Rebranding - InteligenciaMax

**Tempo estimado**: 10 minutos  
**Dificuldade**: Fácil

---

## 📝 Resumo

Este sistema permite personalizar completamente a identidade visual da plataforma **InteligenciaMax** editando apenas o arquivo `.env` e substituindo os logos.

---

## ⚡ 3 Passos Rápidos

### 1️⃣ Editar `.env`

```env
# Suas cores (formato hexadecimal)
APP_PRIMARY_COLOR=#FF6600
APP_SECONDARY_COLOR=#1B1B1B
APP_ACCENT_COLOR=#FFD700

# Seus logos (caminhos relativos à pasta public/)
APP_LOGO_LIGHT=assets/images/brand/logo.png
APP_LOGO_DARK=assets/images/brand/logo-dark.png
APP_FAVICON=assets/images/brand/favicon.png

# Suas fontes
APP_FONT_PRIMARY="Poppins, sans-serif"
APP_FONT_HEADING="Montserrat, sans-serif"
```

### 2️⃣ Substituir Logos

Coloque seus arquivos em `public/assets/images/brand/`:

- `logo.png` (fundo claro)
- `logo-dark.png` (fundo escuro)
- `favicon.png` (32x32 ou 64x64px)

### 3️⃣ Limpar Cache

```bash
cd /home/user/webapp
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

Depois, no navegador: **Ctrl + F5**

---

## ✅ Pronto!

Sua plataforma agora tem a nova identidade visual aplicada em:

- ✅ Painel Admin
- ✅ Área do Usuário
- ✅ Páginas Públicas (Home, Login, Registro)
- ✅ Componentes e modais
- ✅ Favicon em todas as páginas

---

## 📚 Documentação Completa

- **Guia Detalhado**: [THEME_CUSTOMIZATION.md](THEME_CUSTOMIZATION.md)
- **Exemplo Prático**: [REBRANDING_EXAMPLE.md](REBRANDING_EXAMPLE.md)

---

## 🎨 Variáveis Disponíveis

### Cores

```env
APP_PRIMARY_COLOR        # Cor principal
APP_SECONDARY_COLOR      # Cor secundária
APP_ACCENT_COLOR         # Cor de destaque
APP_SUCCESS_COLOR        # Verde (sucesso)
APP_WARNING_COLOR        # Amarelo (aviso)
APP_DANGER_COLOR         # Vermelho (erro)
APP_INFO_COLOR           # Azul (informação)
```

### Logos

```env
APP_LOGO_LIGHT           # Logo para fundo claro
APP_LOGO_DARK            # Logo para fundo escuro
APP_LOGO_ICON            # Ícone (usado na sidebar)
APP_FAVICON              # Favicon do site
APP_LOGO_HEIGHT          # Altura do logo (ex: 50px)
APP_LOGO_WIDTH           # Largura do logo (ex: auto)
```

### Tipografia

```env
APP_FONT_PRIMARY         # Fonte principal (corpo)
APP_FONT_SECONDARY       # Fonte secundária
APP_FONT_HEADING         # Fonte dos títulos
APP_FONT_SIZE            # Tamanho base (ex: 14px)
APP_FONT_SIZE_HEADING    # Tamanho dos títulos (ex: 24px)
```

### Design System

```env
APP_BORDER_RADIUS        # Raio das bordas (ex: 8px)
APP_BORDER_RADIUS_LARGE  # Raio grande (ex: 16px)
APP_BOX_SHADOW           # Sombra padrão
APP_BOX_SHADOW_HOVER     # Sombra no hover
APP_SPACING_UNIT         # Unidade de espaçamento (ex: 8px)
```

### Layout

```env
APP_SIDEBAR_WIDTH        # Largura da sidebar (ex: 260px)
APP_TOPBAR_HEIGHT        # Altura da barra superior (ex: 70px)
```

### Gradientes

```env
APP_GRADIENT_START       # Cor inicial do gradiente
APP_GRADIENT_END         # Cor final do gradiente
```

### Modo Escuro

```env
APP_DARK_MODE_ENABLED    # true/false
APP_DARK_PRIMARY_COLOR   # Cor primária no modo escuro
APP_DARK_SECONDARY_COLOR # Cor secundária no modo escuro
```

### Animações

```env
APP_ANIMATION_DURATION   # Duração (ex: 0.3s)
APP_ANIMATION_EASING     # Easing (ex: ease-in-out)
```

---

## 🔧 Funções Auxiliares

Use em arquivos `.blade.php`:

```php
{{ themeLogo('light') }}           // URL do logo claro
{{ themeLogo('dark') }}            // URL do logo escuro
{{ themeFavicon() }}               // URL do favicon
{{ themeColor('primary') }}        // Cor primária
{{ themeGradient('135deg') }}      // Gradiente CSS
{{ themeFont('primary') }}         // Fonte primária
{{ themeConfig('border_radius') }} // Qualquer config
```

---

## 🎭 Classes CSS Prontas

Use em HTML:

```html
<!-- Botões -->
<button class="btn-theme-primary">Primário</button>
<button class="btn-theme-secondary">Secundário</button>

<!-- Cards -->
<div class="card card-theme-primary">...</div>

<!-- Badges -->
<span class="badge badge-theme-primary">Novo</span>

<!-- Cores de texto -->
<p class="text-theme-primary">Texto colorido</p>

<!-- Cores de fundo -->
<div class="bg-theme-primary">Fundo colorido</div>

<!-- Gradientes -->
<div class="gradient-theme-primary">Com gradiente</div>

<!-- Animações -->
<div class="fade-in">Fade in</div>
<div class="slide-in">Slide in</div>
```

---

## 🛠️ Comandos Úteis

```bash
# Limpar cache completo (recomendado)
php artisan optimize:clear

# Limpar cache específico
php artisan config:clear     # Configurações
php artisan view:clear       # Views
php artisan cache:clear      # Cache geral

# Comando personalizado (se disponível)
php artisan theme:refresh --force
```

---

## 💡 Dicas

### Escolher Cores

1. Use ferramentas como [Coolors.co](https://coolors.co/)
2. Certifique-se de bom contraste (acessibilidade)
3. Teste em modo claro e escuro
4. Use no máximo 3-4 cores principais

### Criar Logos

1. Use ferramentas como [Canva](https://www.canva.com/)
2. Exporte em PNG transparente
3. Otimize com [TinyPNG](https://tinypng.com/)
4. Crie versões para fundo claro e escuro

### Selecionar Fontes

1. Visite [Google Fonts](https://fonts.google.com/)
2. Escolha fontes legíveis (sans-serif para corpo)
3. Combine fonte de corpo + fonte de título
4. Importe apenas os pesos que vai usar

---

## ⚠️ Troubleshooting

### Mudanças não aparecem?

1. Limpe o cache do servidor: `php artisan optimize:clear`
2. Limpe o cache do navegador: `Ctrl + Shift + Delete`
3. Force reload: `Ctrl + F5`

### Logo não carrega?

1. Verifique se o arquivo existe no caminho correto
2. Verifique as permissões: `chmod 644 arquivo.png`
3. Confirme o caminho no `.env`

### Cores não mudam?

1. Verifique o formato hexadecimal (ex: `#FF6600`)
2. Limpe cache: `php artisan config:clear`
3. Recarregue a página

---

## 🎯 Checklist Rápido

Antes de considerar concluído:

- [ ] Editei as variáveis no `.env`
- [ ] Substitui os arquivos de logo
- [ ] Limpei o cache do servidor
- [ ] Limpei o cache do navegador
- [ ] Testei no painel Admin
- [ ] Testei na área do Usuário
- [ ] Testei nas páginas públicas
- [ ] Verifiquei o favicon
- [ ] Testei em mobile

---

## 📞 Suporte

- **Documentação Completa**: `THEME_CUSTOMIZATION.md`
- **Exemplo Prático**: `REBRANDING_EXAMPLE.md`
- **Configuração**: `config/theme.php`
- **CSS Customizado**: `public/assets/theme/theme-custom.css`

---

**Versão**: 1.0  
**Data**: 2025-10-22  
**Sistema**: InteligenciaMax
