#!/bin/bash

# 🔍 Script de Validação de Ambiente - OvoWpp Inteligência MAX
# Verifica se todas as variáveis de ambiente necessárias estão configuradas

echo "🔍 Validando configurações de ambiente..."
echo ""

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Contadores
MISSING=0
CONFIGURED=0
OPTIONAL=0

# Função para verificar variável
check_var() {
    local var_name=$1
    local is_optional=$2
    
    if [ -z "${!var_name}" ]; then
        if [ "$is_optional" = "true" ]; then
            echo -e "${YELLOW}⚠️  $var_name${NC} (opcional - não configurado)"
            ((OPTIONAL++))
        else
            echo -e "${RED}❌ $var_name${NC} (OBRIGATÓRIO - não configurado)"
            ((MISSING++))
        fi
    else
        echo -e "${GREEN}✅ $var_name${NC}"
        ((CONFIGURED++))
    fi
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 VARIÁVEIS OBRIGATÓRIAS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_var "APP_NAME" false
check_var "APP_ENV" false
check_var "APP_KEY" false
check_var "APP_URL" false
check_var "DB_CONNECTION" false
check_var "DB_HOST" false
check_var "DB_PORT" false
check_var "DB_DATABASE" false
check_var "DB_USERNAME" false
check_var "DB_PASSWORD" false

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔧 VARIÁVEIS OPCIONAIS (Configurar depois)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_var "WHATSAPP_ACCESS_TOKEN" true
check_var "WHATSAPP_PHONE_NUMBER_ID" true
check_var "OPENAI_API_KEY" true
check_var "GEMINI_API_KEY" true
check_var "PUSHER_APP_ID" true
check_var "PUSHER_APP_KEY" true
check_var "PUSHER_APP_SECRET" true
check_var "FIREBASE_API_KEY" true

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📊 RESUMO"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo -e "${GREEN}✅ Configuradas:${NC} $CONFIGURED"
echo -e "${YELLOW}⚠️  Opcionais:${NC} $OPTIONAL"
echo -e "${RED}❌ Faltando:${NC} $MISSING"
echo ""

if [ $MISSING -gt 0 ]; then
    echo -e "${RED}⚠️  ATENÇÃO: $MISSING variável(is) obrigatória(s) não configurada(s)!${NC}"
    echo "Por favor, configure todas as variáveis obrigatórias antes de fazer deploy."
    exit 1
else
    echo -e "${GREEN}🎉 Todas as variáveis obrigatórias estão configuradas!${NC}"
    if [ $OPTIONAL -gt 0 ]; then
        echo -e "${YELLOW}💡 Lembre-se de configurar as variáveis opcionais para funcionalidades completas.${NC}"
    fi
    exit 0
fi
