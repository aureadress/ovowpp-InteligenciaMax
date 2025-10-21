#!/bin/bash

# Script para verificar configuração DNS do domínio inteligenciamax.com.br
# Autor: Claude AI
# Data: 2025-10-21

# Cores para output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

DOMAIN="inteligenciamax.com.br"
SUBDOMAIN="www.inteligenciamax.com.br"

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   Verificador DNS - OvoWpp Railway${NC}"
echo -e "${BLUE}========================================${NC}\n"

# Função para verificar se comando existe
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Verificar registro A
echo -e "${YELLOW}📍 Verificando registro A para ${DOMAIN}...${NC}"
if command_exists nslookup; then
    A_RECORD=$(nslookup ${DOMAIN} 2>/dev/null | grep -A1 "Name:" | tail -1 | awk '{print $2}')
    if [ -n "$A_RECORD" ]; then
        echo -e "${GREEN}✅ Registro A encontrado: ${A_RECORD}${NC}\n"
    else
        echo -e "${RED}❌ Nenhum registro A encontrado${NC}"
        echo -e "${YELLOW}ℹ️  Configure o registro A no Registro.br${NC}\n"
    fi
else
    echo -e "${RED}⚠️  Comando nslookup não encontrado${NC}\n"
fi

# Verificar registro CNAME para www
echo -e "${YELLOW}📍 Verificando registro CNAME para ${SUBDOMAIN}...${NC}"
if command_exists nslookup; then
    CNAME_RECORD=$(nslookup ${SUBDOMAIN} 2>/dev/null | grep "canonical name" | awk '{print $5}')
    if [ -n "$CNAME_RECORD" ]; then
        echo -e "${GREEN}✅ Registro CNAME encontrado: ${CNAME_RECORD}${NC}\n"
    else
        echo -e "${RED}❌ Nenhum registro CNAME encontrado${NC}"
        echo -e "${YELLOW}ℹ️  Configure o registro CNAME no Registro.br${NC}\n"
    fi
else
    echo -e "${RED}⚠️  Comando nslookup não encontrado${NC}\n"
fi

# Teste de conectividade HTTP
echo -e "${YELLOW}📍 Testando conectividade HTTP...${NC}"
if command_exists curl; then
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" --max-time 10 https://${DOMAIN} 2>/dev/null)
    if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "302" ] || [ "$HTTP_CODE" = "301" ]; then
        echo -e "${GREEN}✅ Site acessível via HTTPS (HTTP ${HTTP_CODE})${NC}\n"
    elif [ "$HTTP_CODE" = "000" ]; then
        echo -e "${RED}❌ Site não acessível (timeout ou DNS não propagado)${NC}"
        echo -e "${YELLOW}ℹ️  Aguarde a propagação DNS (15-30 minutos)${NC}\n"
    else
        echo -e "${YELLOW}⚠️  Site respondeu com código HTTP ${HTTP_CODE}${NC}\n"
    fi
else
    echo -e "${RED}⚠️  Comando curl não encontrado${NC}\n"
fi

# Verificar SSL/HTTPS
echo -e "${YELLOW}📍 Verificando certificado SSL...${NC}"
if command_exists openssl; then
    SSL_INFO=$(echo | timeout 5 openssl s_client -servername ${DOMAIN} -connect ${DOMAIN}:443 2>/dev/null | grep "Verify return code")
    if echo "$SSL_INFO" | grep -q "0 (ok)"; then
        echo -e "${GREEN}✅ Certificado SSL válido${NC}\n"
    else
        echo -e "${YELLOW}⚠️  Certificado SSL pode estar sendo gerado${NC}"
        echo -e "${YELLOW}ℹ️  Aguarde 15 minutos após DNS propagar${NC}\n"
    fi
else
    echo -e "${RED}⚠️  Comando openssl não encontrado${NC}\n"
fi

# Verificação avançada com dig (se disponível)
if command_exists dig; then
    echo -e "${BLUE}========================================${NC}"
    echo -e "${BLUE}   Informações Detalhadas (dig)${NC}"
    echo -e "${BLUE}========================================${NC}\n"
    
    echo -e "${YELLOW}📍 Detalhes do registro A:${NC}"
    dig ${DOMAIN} A +short
    echo ""
    
    echo -e "${YELLOW}📍 Detalhes do registro CNAME:${NC}"
    dig ${SUBDOMAIN} CNAME +short
    echo ""
fi

# Verificar propagação DNS global
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   Verificação de Propagação Global${NC}"
echo -e "${BLUE}========================================${NC}\n"

echo -e "${YELLOW}📍 Use ferramentas online para verificar propagação global:${NC}"
echo -e "   🌐 https://dnschecker.org/"
echo -e "   🌐 https://www.whatsmydns.net/"
echo ""

echo -e "${YELLOW}📍 Digite o domínio: ${DOMAIN}${NC}"
echo -e "${YELLOW}📍 Tipo de registro: A${NC}"
echo ""

# Resumo final
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   Resumo e Próximos Passos${NC}"
echo -e "${BLUE}========================================${NC}\n"

if [ -n "$A_RECORD" ] && [ -n "$CNAME_RECORD" ]; then
    echo -e "${GREEN}✅ Configuração DNS parece estar correta!${NC}"
    echo -e "${GREEN}✅ Aguarde a propagação global (15-30 minutos)${NC}\n"
    
    echo -e "${YELLOW}Próximos passos:${NC}"
    echo -e "  1. Verifique se o site abre em: https://${DOMAIN}"
    echo -e "  2. Verifique se o site abre em: https://${SUBDOMAIN}"
    echo -e "  3. Teste o login admin em: https://${DOMAIN}/admin"
    echo -e "  4. Verifique o SSL (cadeado verde no navegador)\n"
else
    echo -e "${RED}❌ Configuração DNS incompleta${NC}\n"
    
    echo -e "${YELLOW}Configure no Registro.br:${NC}"
    if [ -z "$A_RECORD" ]; then
        echo -e "  ${RED}❌ Registro A${NC}"
        echo -e "     Tipo: A"
        echo -e "     Nome: @"
        echo -e "     Valor: [IP do Railway]"
    else
        echo -e "  ${GREEN}✅ Registro A${NC}"
    fi
    
    if [ -z "$CNAME_RECORD" ]; then
        echo -e "  ${RED}❌ Registro CNAME${NC}"
        echo -e "     Tipo: CNAME"
        echo -e "     Nome: www"
        echo -e "     Valor: [sua-url].up.railway.app"
    else
        echo -e "  ${GREEN}✅ Registro CNAME${NC}"
    fi
    echo ""
fi

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   Para obter o IP do Railway:${NC}"
echo -e "${BLUE}========================================${NC}"
echo -e "${YELLOW}Execute: nslookup [sua-url-railway].up.railway.app${NC}"
echo -e "${YELLOW}Ou: dig [sua-url-railway].up.railway.app +short${NC}\n"

echo -e "${GREEN}✅ Verificação concluída!${NC}\n"
