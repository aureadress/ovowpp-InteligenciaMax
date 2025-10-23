#!/usr/bin/env python3
"""
Script para testar todas as rotas importantes do dashboard admin e usuário
"""
import requests
import json
from urllib.parse import urljoin

BASE_URL = "https://inteligenciamax.com.br"

# Rotas principais do ADMIN (requerem autenticação)
ADMIN_ROUTES = [
    "/admin/dashboard",
    "/admin/user/subscriptions",
    "/admin/pricing/plan",
    "/admin/user/data/contact",
    "/admin/user/data/contact/list",
    "/admin/user/data/contact/tag",
    "/admin/user/data/campaign",
    "/admin/user/data/chatbot",
    "/admin/user/data/short-link",
    "/admin/users/active",
    "/admin/users/banned",
    "/admin/users/all",
    "/admin/users/agent",
    "/admin/list",
    "/admin/role",
    "/admin/coupon",
    "/admin/deposit/list",
    "/admin/withdraw/all",
    "/admin/gateway/automatic",
    "/admin/withdraw/method",
    "/admin/extensions",
    "/admin/seo",
    "/admin/language",
    "/admin/report/transaction",
    "/admin/report/login/history",
    "/admin/report/notification/history",
    "/admin/setting/general",
    "/admin/setting/pusher",
    "/admin/setting/brand",
    "/admin/setting/system-configuration",
    "/admin/ai-assistant",
    "/admin/kyc/setting",
    "/admin/setting/socialite/credentials",
    "/admin/cron",
    "/admin/setting/cookie",
    "/admin/setting/custom-css",
    "/admin/setting/sitemap",
    "/admin/setting/robot",
    "/admin/setting/app/purchase",
    "/admin/maintenance-mode",
    "/admin/setting/notification/global",
    "/admin/setting/notification/email",
    "/admin/setting/notification/sms",
    "/admin/setting/notification/push",
    "/admin/setting/notification/templates",
    "/admin/frontend/manage-pages",
    "/admin/frontend",
    "/admin/ticket",
    "/admin/subscriber",
    "/admin/system/info"
]

# Rotas principais do USUÁRIO (requerem autenticação)
USER_ROUTES = [
    "/user/dashboard",
    "/user/contact",
    "/user/contact/list/create",
    "/user/contact/tag",
    "/user/campaign",
    "/user/chatbot",
    "/user/short-link",
    "/user/agent/list",
    "/user/agent/create",
    "/user/floater",
    "/user/template",
    "/user/cta-url",
    "/user/carousel",
    "/user/embed-code",
    "/user/plan",
    "/user/subscription-log",
    "/user/deposit/history",
    "/user/withdraw",
    "/user/transactions",
    "/user/notification/setting",
    "/user/ai-assistant/setting",
    "/user/profile-setting",
    "/user/change-password",
    "/user/twofactor"
]

# Rotas públicas (não requerem autenticação)
PUBLIC_ROUTES = [
    "/",
    "/pricing",
    "/features",
    "/blogs",
    "/contact",
    "/login",
    "/register"
]

def test_route(url, route_name):
    """Testa uma rota e retorna status"""
    try:
        full_url = urljoin(BASE_URL, url)
        response = requests.get(full_url, timeout=10, allow_redirects=False)
        
        status = response.status_code
        
        if status == 200:
            return {"url": url, "status": status, "result": "✅ OK", "type": "success"}
        elif status == 302 or status == 301:
            redirect = response.headers.get('Location', 'N/A')
            return {"url": url, "status": status, "result": f"🔄 REDIRECT → {redirect}", "type": "redirect"}
        elif status == 404:
            return {"url": url, "status": status, "result": "❌ NOT FOUND", "type": "error"}
        elif status == 500:
            return {"url": url, "status": status, "result": "🔥 SERVER ERROR", "type": "critical"}
        elif status == 403:
            return {"url": url, "status": status, "result": "🚫 FORBIDDEN", "type": "warning"}
        else:
            return {"url": url, "status": status, "result": f"⚠️ {status}", "type": "warning"}
    except requests.exceptions.Timeout:
        return {"url": url, "status": "TIMEOUT", "result": "⏱️ TIMEOUT", "type": "critical"}
    except requests.exceptions.ConnectionError:
        return {"url": url, "status": "ERROR", "result": "🔌 CONNECTION ERROR", "type": "critical"}
    except Exception as e:
        return {"url": url, "status": "ERROR", "result": f"💥 {str(e)[:50]}", "type": "critical"}

def main():
    print("=" * 80)
    print("🧪 TESTE DE ROTAS - InteligenciaMax")
    print("=" * 80)
    print()
    
    results = {
        "public": [],
        "admin": [],
        "user": []
    }
    
    # Testar rotas públicas
    print("📄 TESTANDO ROTAS PÚBLICAS...")
    print("-" * 80)
    for route in PUBLIC_ROUTES:
        result = test_route(route, "public")
        results["public"].append(result)
        print(f"{result['result']:<30} {route}")
    print()
    
    # Testar rotas de usuário
    print("👤 TESTANDO ROTAS DE USUÁRIO (requerem auth - esperado redirect)...")
    print("-" * 80)
    for route in USER_ROUTES[:10]:  # Testar apenas 10 primeiras
        result = test_route(route, "user")
        results["user"].append(result)
        print(f"{result['result']:<30} {route}")
    print()
    
    # Testar rotas de admin
    print("🔐 TESTANDO ROTAS DE ADMIN (requerem auth - esperado redirect)...")
    print("-" * 80)
    for route in ADMIN_ROUTES[:10]:  # Testar apenas 10 primeiras
        result = test_route(route, "admin")
        results["admin"].append(result)
        print(f"{result['result']:<30} {route}")
    print()
    
    # Resumo
    print("=" * 80)
    print("📊 RESUMO DOS TESTES")
    print("=" * 80)
    
    total_tests = len(results["public"]) + len(results["user"]) + len(results["admin"])
    errors = sum(1 for r in results["public"] + results["user"] + results["admin"] if r["type"] in ["error", "critical"])
    success = sum(1 for r in results["public"] + results["user"] + results["admin"] if r["type"] == "success")
    redirects = sum(1 for r in results["public"] + results["user"] + results["admin"] if r["type"] == "redirect")
    
    print(f"Total de rotas testadas: {total_tests}")
    print(f"✅ Sucesso (200): {success}")
    print(f"🔄 Redirecionamentos (302/301): {redirects}")
    print(f"❌ Erros (404/500/timeout): {errors}")
    print()
    
    # Listar erros críticos
    critical_errors = [r for r in results["public"] + results["user"] + results["admin"] 
                       if r["type"] == "critical" or (r["type"] == "error" and r["status"] == 500)]
    
    if critical_errors:
        print("🔥 ERROS CRÍTICOS ENCONTRADOS:")
        print("-" * 80)
        for error in critical_errors:
            print(f"{error['result']:<30} {error['url']}")
    else:
        print("✅ Nenhum erro crítico encontrado!")
    
    print("=" * 80)
    
    # Salvar resultados em JSON
    with open('/home/user/webapp/route_test_results.json', 'w', encoding='utf-8') as f:
        json.dump(results, f, indent=2, ensure_ascii=False)
    
    print("📁 Resultados salvos em: route_test_results.json")

if __name__ == "__main__":
    main()
