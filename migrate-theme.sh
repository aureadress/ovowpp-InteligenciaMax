#!/bin/bash

################################################################################
# Script de Migration - Theme Settings
# 
# Este script instala a tabela theme_settings e cores padrão
# 
# COMO USAR NO RAILWAY:
# 1. Abra o console do Railway
# 2. Execute: bash migrate-theme.sh
# 
# OU execute diretamente:
# php artisan migrate --path=database/migrations/2025_10_25_000001_create_theme_settings_table.php --force
################################################################################

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Banner
echo -e "${PURPLE}"
echo "╔═══════════════════════════════════════════════════════════╗"
echo "║                                                           ║"
echo "║         🎨 THEME SETTINGS MIGRATION SCRIPT 🎨            ║"
echo "║                                                           ║"
echo "║         Sistema de Cores Isoladas                        ║"
echo "║         Admin / User / Chat                              ║"
echo "║                                                           ║"
echo "╚═══════════════════════════════════════════════════════════╝"
echo -e "${NC}"
echo ""

# Verificar se estamos no diretório correto
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Erro: arquivo 'artisan' não encontrado!${NC}"
    echo -e "${YELLOW}Execute este script a partir da raiz do projeto Laravel.${NC}"
    exit 1
fi

echo -e "${BLUE}📦 Passo 1: Verificando ambiente...${NC}"
echo ""

# Verificar PHP
if ! command -v php &> /dev/null; then
    echo -e "${RED}❌ PHP não encontrado!${NC}"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo -e "${GREEN}✅ PHP instalado: ${PHP_VERSION}${NC}"

# Verificar Laravel
if [ -f "artisan" ]; then
    LARAVEL_VERSION=$(php artisan --version | grep -oP "Laravel Framework \K[0-9.]+")
    echo -e "${GREEN}✅ Laravel: ${LARAVEL_VERSION}${NC}"
fi

echo ""
echo -e "${BLUE}🔍 Passo 2: Verificando se tabela já existe...${NC}"
echo ""

# Verificar se tabela já existe
TABLE_EXISTS=$(php artisan tinker --execute="echo DB::schema()->hasTable('theme_settings') ? 'yes' : 'no';" 2>/dev/null | tail -n 1 | tr -d '\n')

if [ "$TABLE_EXISTS" = "yes" ]; then
    echo -e "${YELLOW}⚠️  Tabela 'theme_settings' já existe!${NC}"
    echo ""
    echo -e "${CYAN}Dados atuais:${NC}"
    php artisan tinker --execute="
        \$theme = DB::table('theme_settings')->first();
        if (\$theme) {
            echo '  Admin Primary: ' . \$theme->admin_primary_color . PHP_EOL;
            echo '  User Primary: ' . \$theme->user_primary_color . PHP_EOL;
            echo '  Chat Primary: ' . \$theme->chat_primary_color . PHP_EOL;
        }
    " 2>/dev/null
    echo ""
    echo -e "${GREEN}✅ Migration não é necessária!${NC}"
    echo ""
    echo -e "${CYAN}Acesse o painel: /admin/theme/colors${NC}"
    exit 0
fi

echo -e "${GREEN}✅ Tabela não existe. Prosseguindo...${NC}"
echo ""
echo -e "${BLUE}🚀 Passo 3: Executando migration...${NC}"
echo ""

# Executar migration
php artisan migrate --path=database/migrations/2025_10_25_000001_create_theme_settings_table.php --force

if [ $? -eq 0 ]; then
    echo ""
    echo -e "${GREEN}✅ Migration executada com sucesso!${NC}"
    echo ""
    
    echo -e "${BLUE}🔍 Passo 4: Verificando instalação...${NC}"
    echo ""
    
    # Verificar dados inseridos
    php artisan tinker --execute="
        \$theme = DB::table('theme_settings')->first();
        if (\$theme) {
            echo '${GREEN}✅ Cores padrão instaladas:${NC}' . PHP_EOL . PHP_EOL;
            echo '  🔵 Admin Primary: ' . \$theme->admin_primary_color . PHP_EOL;
            echo '  🟢 User Primary: ' . \$theme->user_primary_color . PHP_EOL;
            echo '  💬 Chat Primary: ' . \$theme->chat_primary_color . PHP_EOL;
            echo '  ⚠️  Warning: ' . \$theme->warning_color . PHP_EOL;
            echo '  ❌ Danger: ' . \$theme->danger_color . PHP_EOL;
        } else {
            echo '${YELLOW}⚠️  Tabela criada mas sem dados.${NC}' . PHP_EOL;
        }
    " 2>/dev/null
    
    echo ""
    echo -e "${PURPLE}╔═══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${PURPLE}║                                                           ║${NC}"
    echo -e "${PURPLE}║              🎉 INSTALAÇÃO COMPLETA! 🎉                   ║${NC}"
    echo -e "${PURPLE}║                                                           ║${NC}"
    echo -e "${PURPLE}╚═══════════════════════════════════════════════════════════╝${NC}"
    echo ""
    echo -e "${CYAN}📍 Próximos passos:${NC}"
    echo ""
    echo -e "  1. Acesse: ${GREEN}/admin/theme/colors${NC}"
    echo -e "  2. Configure as cores para Admin, User e Chat"
    echo -e "  3. Salve as alterações"
    echo ""
    echo -e "${YELLOW}🗑️  Você pode deletar este script agora: ${NC}"
    echo -e "   ${CYAN}rm migrate-theme.sh${NC}"
    echo ""
    
else
    echo ""
    echo -e "${RED}❌ Erro ao executar migration!${NC}"
    echo ""
    echo -e "${YELLOW}Tente executar manualmente:${NC}"
    echo -e "  ${CYAN}php artisan migrate --path=database/migrations/2025_10_25_000001_create_theme_settings_table.php --force${NC}"
    echo ""
    exit 1
fi
