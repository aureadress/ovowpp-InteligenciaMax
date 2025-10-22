#!/usr/bin/env python3
"""
Script para atualizar o nome do site no banco de dados
Remove referências a 'OvoWpp' e define 'Inteligência MAX'
"""

import pymysql
import os
from dotenv import load_dotenv

# Carregar variáveis de ambiente
load_dotenv()

# Configurações do banco de dados
DB_CONFIG = {
    'host': os.getenv('DB_HOST', 'metro.proxy.rlwy.net'),
    'port': int(os.getenv('DB_PORT', 37078)),
    'user': os.getenv('DB_USERNAME', 'root'),
    'password': os.getenv('DB_PASSWORD', ''),
    'database': os.getenv('DB_DATABASE', 'railway'),
    'charset': 'utf8mb4',
    'cursorclass': pymysql.cursors.DictCursor
}

def atualizar_nome_site():
    """Atualiza o nome do site no banco de dados"""
    try:
        # Conectar ao banco
        print("🔌 Conectando ao banco de dados...")
        connection = pymysql.connect(**DB_CONFIG)
        
        with connection.cursor() as cursor:
            # Verificar nome atual
            print("\n📋 Verificando nome atual do site...")
            cursor.execute("SELECT * FROM general_settings WHERE id = 1")
            config = cursor.fetchone()
            
            if config:
                print(f"✓ Nome atual: {config.get('site_name', 'N/A')}")
                
                # Atualizar nome do site
                print("\n🔄 Atualizando nome do site...")
                cursor.execute("""
                    UPDATE general_settings 
                    SET site_name = 'Inteligência MAX'
                    WHERE id = 1
                """)
                
                # Verificar se há outras configurações relacionadas
                cursor.execute("""
                    UPDATE general_settings 
                    SET 
                        system_name = 'inteligenciamax',
                        system_title = 'Inteligência MAX - Sistema de WhatsApp Marketing'
                    WHERE id = 1
                """)
                
                connection.commit()
                print("✅ Nome do site atualizado com sucesso!")
                
                # Verificar atualização
                cursor.execute("SELECT site_name, system_name FROM general_settings WHERE id = 1")
                updated = cursor.fetchone()
                print(f"\n✓ Novo nome: {updated.get('site_name', 'N/A')}")
                print(f"✓ Nome do sistema: {updated.get('system_name', 'N/A')}")
                
            else:
                print("❌ Configurações gerais não encontradas")
                return False
        
        connection.close()
        return True
        
    except pymysql.Error as e:
        print(f"❌ Erro ao conectar ao banco de dados: {e}")
        return False
    except Exception as e:
        print(f"❌ Erro inesperado: {e}")
        return False

def atualizar_metadados():
    """Atualiza metadados SEO e outras referências"""
    try:
        connection = pymysql.connect(**DB_CONFIG)
        
        with connection.cursor() as cursor:
            print("\n🔍 Atualizando metadados SEO...")
            
            # Atualizar descrições e keywords
            cursor.execute("""
                UPDATE general_settings 
                SET 
                    meta_description = 'Inteligência MAX - Plataforma completa de automação e marketing via WhatsApp',
                    meta_keywords = 'whatsapp marketing, automação whatsapp, inteligencia max, chatbot whatsapp'
                WHERE id = 1
            """)
            
            connection.commit()
            print("✅ Metadados atualizados!")
        
        connection.close()
        
    except Exception as e:
        print(f"⚠️  Aviso: Não foi possível atualizar metadados - {e}")

if __name__ == "__main__":
    print("=" * 60)
    print("  ATUALIZAÇÃO DE NOME DO SITE - INTELIGÊNCIA MAX")
    print("=" * 60)
    print()
    
    # Atualizar nome do site
    if atualizar_nome_site():
        print("\n✅ Atualização concluída com sucesso!")
        
        # Atualizar metadados
        atualizar_metadados()
        
        print("\n" + "=" * 60)
        print("  PRÓXIMOS PASSOS:")
        print("=" * 60)
        print("1. Limpar cache: php artisan config:clear")
        print("2. Limpar cache: php artisan view:clear")
        print("3. Limpar cache: php artisan cache:clear")
        print("4. Recarregar o navegador com Ctrl+F5")
        print()
    else:
        print("\n❌ Falha na atualização")
        exit(1)
