#!/usr/bin/env python3
"""
Script de Verificação Completa de Rotas
Laravel 11 OvoWpp InteligenciaMax
Data: 2025-10-23
"""

import subprocess
import json
import re
from typing import List, Dict, Tuple
from collections import defaultdict

def get_all_routes() -> List[Dict]:
    """Obtém todas as rotas do Laravel via artisan"""
    print("📋 Obtendo lista completa de rotas do Laravel...")
    
    result = subprocess.run(
        ["php", "artisan", "route:list", "--json"],
        cwd="/home/user/webapp",
        capture_output=True,
        text=True
    )
    
    if result.returncode != 0:
        print(f"❌ Erro ao obter rotas: {result.stderr}")
        return []
    
    try:
        routes = json.loads(result.stdout)
        print(f"✅ {len(routes)} rotas encontradas\n")
        return routes
    except json.JSONDecodeError as e:
        print(f"❌ Erro ao parsear JSON: {e}")
        return []

def categorize_routes(routes: List[Dict]) -> Dict[str, List[Dict]]:
    """Categoriza rotas por área"""
    categories = {
        'public': [],
        'admin': [],
        'user': [],
        'api': [],
        'ajax': [],
        'other': []
    }
    
    for route in routes:
        uri = route.get('uri', '') or ''
        name = route.get('name', '') or ''
        
        if uri.startswith('admin/'):
            categories['admin'].append(route)
        elif uri.startswith('user/'):
            categories['user'].append(route)
        elif uri.startswith('api/'):
            categories['api'].append(route)
        elif 'ajax' in uri.lower() or 'ajax' in name.lower():
            categories['ajax'].append(route)
        elif uri in ['/', 'login', 'register', 'contact', 'about']:
            categories['public'].append(route)
        else:
            categories['other'].append(route)
    
    return categories

def analyze_route_methods(routes: List[Dict]) -> Dict[str, int]:
    """Analisa métodos HTTP usados"""
    methods = defaultdict(int)
    
    for route in routes:
        route_methods = route.get('method', 'GET').split('|')
        for method in route_methods:
            method = method.strip()
            if method not in ['HEAD']:  # Ignora HEAD
                methods[method] += 1
    
    return dict(methods)

def analyze_middlewares(routes: List[Dict]) -> Dict[str, int]:
    """Analisa middlewares mais usados"""
    middlewares = defaultdict(int)
    
    for route in routes:
        route_middleware = route.get('middleware', [])
        if isinstance(route_middleware, str):
            route_middleware = [route_middleware]
        
        for mw in route_middleware:
            if mw:
                middlewares[mw] += 1
    
    return dict(sorted(middlewares.items(), key=lambda x: x[1], reverse=True))

def find_protected_routes(routes: List[Dict]) -> Tuple[List[Dict], List[Dict]]:
    """Identifica rotas protegidas vs públicas"""
    protected = []
    public = []
    
    for route in routes:
        middleware = route.get('middleware', [])
        if isinstance(middleware, str):
            middleware = [middleware]
        
        # Verifica se tem middleware de autenticação
        has_auth = any(
            'auth' in str(mw).lower() or 
            'admin' in str(mw).lower() or
            'user' in str(mw).lower()
            for mw in middleware
        )
        
        if has_auth:
            protected.append(route)
        else:
            public.append(route)
    
    return protected, public

def find_permission_routes(routes: List[Dict]) -> List[Dict]:
    """Encontra rotas com middleware de permissão"""
    permission_routes = []
    
    for route in routes:
        middleware = route.get('middleware', [])
        if isinstance(middleware, str):
            middleware = [middleware]
        
        has_permission = any('permission' in str(mw).lower() for mw in middleware)
        
        if has_permission:
            permission_routes.append(route)
    
    return permission_routes

def analyze_controllers(routes: List[Dict]) -> Dict[str, int]:
    """Analisa controllers mais usados"""
    controllers = defaultdict(int)
    
    for route in routes:
        action = route.get('action', '')
        if action and '@' in action:
            controller = action.split('@')[0]
            # Remove namespace
            controller_name = controller.split('\\')[-1]
            controllers[controller_name] += 1
    
    return dict(sorted(controllers.items(), key=lambda x: x[1], reverse=True)[:15])

def find_crud_patterns(routes: List[Dict]) -> Dict[str, List[str]]:
    """Identifica padrões CRUD por recurso"""
    resources = defaultdict(lambda: defaultdict(list))
    
    for route in routes:
        uri = route.get('uri', '') or ''
        name = route.get('name', '') or ''
        methods = route.get('method', 'GET').split('|')
        
        # Extrai recurso base (ex: admin/users, user/agent)
        parts = uri.split('/')
        if len(parts) >= 2:
            resource = '/'.join(parts[:2])
            
            for method in methods:
                method = method.strip()
                if method in ['GET', 'POST', 'PUT', 'DELETE', 'PATCH']:
                    resources[resource][method].append(name or uri)
    
    return dict(resources)

def check_role_routes(routes: List[Dict]) -> Dict:
    """Verifica especificamente as rotas de Role"""
    role_routes = []
    
    for route in routes:
        uri = route.get('uri', '') or ''
        name = route.get('name', '') or ''
        
        if 'role' in uri.lower() or 'role' in name.lower():
            role_routes.append({
                'method': route.get('method'),
                'uri': uri,
                'name': name,
                'action': route.get('action'),
                'middleware': route.get('middleware', [])
            })
    
    return {
        'total': len(role_routes),
        'routes': role_routes
    }

def generate_report(routes: List[Dict]):
    """Gera relatório completo"""
    
    print("=" * 80)
    print("🎯 RELATÓRIO COMPLETO DE VERIFICAÇÃO DE ROTAS")
    print("   Laravel 11 OvoWpp InteligenciaMax")
    print("=" * 80)
    print()
    
    # 1. Estatísticas Gerais
    print("📊 ESTATÍSTICAS GERAIS")
    print("-" * 80)
    print(f"   Total de Rotas: {len(routes)}")
    
    # Categorias
    categories = categorize_routes(routes)
    print(f"\n   📁 Rotas por Categoria:")
    for cat, cat_routes in categories.items():
        if cat_routes:
            print(f"      • {cat.upper()}: {len(cat_routes)} rotas")
    
    # Métodos HTTP
    methods = analyze_route_methods(routes)
    print(f"\n   🔧 Métodos HTTP:")
    for method, count in sorted(methods.items()):
        print(f"      • {method}: {count} rotas")
    
    print()
    
    # 2. Análise de Segurança
    print("🔒 ANÁLISE DE SEGURANÇA")
    print("-" * 80)
    
    protected, public = find_protected_routes(routes)
    print(f"   Rotas Protegidas (com auth): {len(protected)}")
    print(f"   Rotas Públicas: {len(public)}")
    
    permission_routes = find_permission_routes(routes)
    print(f"   Rotas com Middleware de Permissão: {len(permission_routes)}")
    
    print()
    
    # 3. Middlewares
    print("🛡️  MIDDLEWARES MAIS USADOS")
    print("-" * 80)
    middlewares = analyze_middlewares(routes)
    for i, (mw, count) in enumerate(list(middlewares.items())[:10], 1):
        print(f"   {i:2d}. {mw}: {count} rotas")
    
    print()
    
    # 4. Controllers
    print("🎮 CONTROLLERS MAIS USADOS")
    print("-" * 80)
    controllers = analyze_controllers(routes)
    for i, (controller, count) in enumerate(list(controllers.items())[:10], 1):
        print(f"   {i:2d}. {controller}: {count} rotas")
    
    print()
    
    # 5. Rotas Admin Detalhadas
    print("👨‍💼 ROTAS DO DASHBOARD ADMIN")
    print("-" * 80)
    admin_routes = categories['admin']
    
    # Agrupar por prefixo
    admin_groups = defaultdict(list)
    for route in admin_routes:
        uri = route.get('uri', '')
        # Pega o segundo segmento (admin/XXX)
        parts = uri.split('/')
        if len(parts) >= 2:
            group = parts[1]
        else:
            group = 'root'
        admin_groups[group].append(route)
    
    for group in sorted(admin_groups.keys())[:15]:
        routes_in_group = admin_groups[group]
        methods_in_group = set()
        for r in routes_in_group:
            methods_in_group.update(r.get('method', 'GET').split('|'))
        methods_in_group.discard('HEAD')
        
        print(f"   • admin/{group}: {len(routes_in_group)} rotas ({', '.join(sorted(methods_in_group))})")
    
    if len(admin_groups) > 15:
        print(f"   ... e mais {len(admin_groups) - 15} grupos")
    
    print()
    
    # 6. Rotas User Detalhadas
    print("👤 ROTAS DO DASHBOARD USUÁRIO")
    print("-" * 80)
    user_routes = categories['user']
    
    # Agrupar por prefixo
    user_groups = defaultdict(list)
    for route in user_routes:
        uri = route.get('uri', '')
        parts = uri.split('/')
        if len(parts) >= 2:
            group = parts[1]
        else:
            group = 'root'
        user_groups[group].append(route)
    
    for group in sorted(user_groups.keys()):
        routes_in_group = user_groups[group]
        methods_in_group = set()
        for r in routes_in_group:
            methods_in_group.update(r.get('method', 'GET').split('|'))
        methods_in_group.discard('HEAD')
        
        print(f"   • user/{group}: {len(routes_in_group)} rotas ({', '.join(sorted(methods_in_group))})")
    
    print()
    
    # 7. Verificação Específica de ROLE
    print("🔍 VERIFICAÇÃO ESPECÍFICA: ROTAS DE ROLE")
    print("-" * 80)
    role_info = check_role_routes(routes)
    print(f"   Total de Rotas de Role: {role_info['total']}")
    print()
    
    for i, route in enumerate(role_info['routes'], 1):
        print(f"   {i}. {route['method']} {route['uri']}")
        print(f"      Nome: {route['name']}")
        print(f"      Action: {route['action']}")
        print(f"      Middleware: {', '.join(route['middleware']) if route['middleware'] else 'Nenhum'}")
        print()
    
    # 8. Padrões CRUD
    print("📝 PADRÕES CRUD IDENTIFICADOS")
    print("-" * 80)
    crud_patterns = find_crud_patterns(routes)
    
    # Filtrar apenas recursos principais
    main_resources = {
        k: v for k, v in crud_patterns.items() 
        if any(v.values())  # Tem pelo menos um método
    }
    
    for resource in sorted(main_resources.keys())[:10]:
        patterns = main_resources[resource]
        has_methods = [m for m, routes in patterns.items() if routes]
        if has_methods:
            print(f"   • {resource}: {', '.join(has_methods)}")
    
    print()
    
    # 9. Rotas Potencialmente Problemáticas
    print("⚠️  ANÁLISE DE ROTAS CRÍTICAS")
    print("-" * 80)
    
    # Rotas POST sem middleware de auth
    public_posts = [
        r for r in routes 
        if 'POST' in r.get('method', '') 
        and not any('auth' in str(mw).lower() for mw in r.get('middleware', []))
        and not r.get('uri', '').startswith('api/')
    ]
    
    print(f"   Rotas POST Públicas: {len(public_posts)}")
    for route in public_posts[:5]:
        print(f"      • POST {route.get('uri')} ({route.get('name', 'sem nome')})")
    if len(public_posts) > 5:
        print(f"      ... e mais {len(public_posts) - 5} rotas")
    
    print()
    
    # 10. Resumo Final
    print("=" * 80)
    print("✅ RESUMO FINAL")
    print("=" * 80)
    print(f"   Total de Rotas Analisadas: {len(routes)}")
    print(f"   Rotas Admin: {len(categories['admin'])}")
    print(f"   Rotas User: {len(categories['user'])}")
    print(f"   Rotas Protegidas: {len(protected)}")
    print(f"   Rotas com Permissão: {len(permission_routes)}")
    print(f"   Controllers Únicos: {len(controllers)}")
    print()
    print("   🎯 Status: ANÁLISE COMPLETA")
    print("=" * 80)

def main():
    """Função principal"""
    routes = get_all_routes()
    
    if not routes:
        print("❌ Não foi possível obter as rotas")
        return
    
    generate_report(routes)
    
    # Salvar rotas em arquivo JSON para análise posterior
    output_file = "/home/user/webapp/routes_analysis.json"
    with open(output_file, 'w', encoding='utf-8') as f:
        json.dump(routes, f, indent=2, ensure_ascii=False)
    
    print(f"\n💾 Dados completos salvos em: {output_file}")
    print()

if __name__ == "__main__":
    main()
