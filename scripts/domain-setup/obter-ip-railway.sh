#!/bin/bash

# Script para obter o IP do Railway automaticamente
# Autor: Claude AI
# Data: 2025-10-21

# Cores
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   Obter IP do Railway${NC}"
echo -e "${BLUE}========================================${NC}\n"

# Verificar se URL foi fornecida
if [ -z "$1" ]; then
    echo -e "${YELLOW}📍 Como usar:${NC}"
    echo -e "   ./obter-ip-railway.sh [sua-url-railway].up.railway.app"
    echo ""
    echo -e "${YELLOW}📍 Exemplo:${NC}"
    echo -e "   ./obter-ip-railway.sh ovowpp-production-xxxx.up.railway.app"
    echo ""
    echo -e "${RED}❌ Erro: URL do Railway não fornecida${NC}\n"
    exit 1
fi

RAILWAY_URL=$1

echo -e "${YELLOW}📍 Obtendo IP para: ${RAILWAY_URL}${NC}\n"

# Método 1: nslookup
if command -v nslookup >/dev/null 2>&1; then
    echo -e "${BLUE}Método 1: nslookup${NC}"
    IP_NSLOOKUP=$(nslookup ${RAILWAY_URL} 2>/dev/null | grep -A1 "Name:" | tail -1 | awk '{print $2}')
    if [ -n "$IP_NSLOOKUP" ]; then
        echo -e "${GREEN}✅ IP encontrado: ${IP_NSLOOKUP}${NC}\n"
    else
        echo -e "${RED}❌ IP não encontrado${NC}\n"
    fi
fi

# Método 2: dig
if command -v dig >/dev/null 2>&1; then
    echo -e "${BLUE}Método 2: dig${NC}"
    IP_DIG=$(dig ${RAILWAY_URL} +short | head -1)
    if [ -n "$IP_DIG" ]; then
        echo -e "${GREEN}✅ IP encontrado: ${IP_DIG}${NC}\n"
    else
        echo -e "${RED}❌ IP não encontrado${NC}\n"
    fi
fi

# Método 3: host
if command -v host >/dev/null 2>&1; then
    echo -e "${BLUE}Método 3: host${NC}"
    IP_HOST=$(host ${RAILWAY_URL} | grep "has address" | awk '{print $4}' | head -1)
    if [ -n "$IP_HOST" ]; then
        echo -e "${GREEN}✅ IP encontrado: ${IP_HOST}${NC}\n"
    else
        echo -e "${RED}❌ IP não encontrado${NC}\n"
    fi
fi

# Método 4: ping (último recurso)
if command -v ping >/dev/null 2>&1; then
    echo -e "${BLUE}Método 4: ping${NC}"
    IP_PING=$(ping -c 1 ${RAILWAY_URL} 2>/dev/null | grep "PING" | awk -F'[()]' '{print $2}')
    if [ -n "$IP_PING" ]; then
        echo -e "${GREEN}✅ IP encontrado: ${IP_PING}${NC}\n"
    else
        echo -e "${RED}❌ IP não encontrado${NC}\n"
    fi
fi

# Resumo
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   Resumo dos IPs Encontrados${NC}"
echo -e "${BLUE}========================================${NC}\n"

# Escolher o IP mais confiável
FINAL_IP=""

if [ -n "$IP_DIG" ]; then
    FINAL_IP=$IP_DIG
elif [ -n "$IP_NSLOOKUP" ]; then
    FINAL_IP=$IP_NSLOOKUP
elif [ -n "$IP_HOST" ]; then
    FINAL_IP=$IP_HOST
elif [ -n "$IP_PING" ]; then
    FINAL_IP=$IP_PING
fi

if [ -n "$FINAL_IP" ]; then
    echo -e "${GREEN}✅ IP DO RAILWAY: ${FINAL_IP}${NC}\n"
    echo -e "${YELLOW}📍 Use este IP no Registro.br:${NC}"
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${GREEN}Tipo: A${NC}"
    echo -e "${GREEN}Nome: @${NC}"
    echo -e "${GREEN}Valor: ${FINAL_IP}${NC}"
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}\n"
    
    # Salvar em arquivo
    echo "${FINAL_IP}" > railway-ip.txt
    echo -e "${GREEN}✅ IP salvo em: railway-ip.txt${NC}\n"
else
    echo -e "${RED}❌ Não foi possível obter o IP${NC}"
    echo -e "${YELLOW}ℹ️  Verifique se a URL está correta${NC}"
    echo -e "${YELLOW}ℹ️  Verifique sua conexão com a internet${NC}\n"
    exit 1
fi

# Verificar conectividade
echo -e "${YELLOW}📍 Testando conectividade com o IP...${NC}"
if command -v curl >/dev/null 2>&1; then
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" --max-time 10 http://${FINAL_IP} 2>/dev/null)
    if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "302" ] || [ "$HTTP_CODE" = "301" ]; then
        echo -e "${GREEN}✅ IP acessível (HTTP ${HTTP_CODE})${NC}\n"
    else
        echo -e "${YELLOW}⚠️  IP respondeu com código HTTP ${HTTP_CODE}${NC}"
        echo -e "${YELLOW}ℹ️  Isso é normal, o Railway pode requerer HTTPS${NC}\n"
    fi
fi

echo -e "${GREEN}✅ Pronto! Use o IP acima na configuração DNS${NC}\n"
