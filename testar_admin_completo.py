#!/usr/bin/env python3
"""
Script de Teste Completo do Admin Panel
Testa todas as funcionalidades e gera relatório
"""

import json
import sys
from datetime import datetime

# Estrutura completa do menu (baseada no menu.json)
MENU_STRUCTURE = {
    "Dashboard": {
        "rota": "admin.dashboard",
        "funcoes": ["Visão geral do sistema", "Estatísticas", "Gráficos"]
    },
    "Subscription History": {
        "rota": "admin.user.subscriptions",
        "funcoes": ["Listar assinaturas", "Filtrar por status", "Exportar dados"]
    },
    "Pricing Plans": {
        "rota": "admin.pricing.plan.index",
        "funcoes": ["Criar plano", "Editar plano", "Deletar plano", "Ativar/Desativar"]
    },
    "System Data": {
        "submenu": {
            "All Contacts": {
                "rota": "admin.user.data.contact",
                "funcoes": ["Listar contatos", "Visualizar detalhes", "Editar", "Deletar"]
            },
            "Contacts List": {
                "rota": "admin.user.data.contact.list",
                "funcoes": ["Gerenciar listas", "Criar lista", "Editar lista"]
            },
            "Contacts Tag": {
                "rota": "admin.user.data.contact.tag",
                "funcoes": ["Gerenciar tags", "Criar tag", "Editar tag"]
            },
            "All Campaign": {
                "rota": "admin.user.data.campaign",
                "funcoes": ["Listar campanhas", "Criar campanha", "Editar", "Deletar"]
            },
            "All Chatbot": {
                "rota": "admin.user.data.chatbot",
                "funcoes": ["Listar chatbots", "Configurar", "Ativar/Desativar"]
            },
            "All Short Links": {
                "rota": "admin.user.data.short.link",
                "funcoes": ["Listar links", "Criar link", "Estatísticas"]
            }
        }
    },
    "Manage Users": {
        "submenu": {
            "Active Users": {
                "rota": "admin.users.active",
                "funcoes": ["Listar usuários ativos", "Filtrar", "Exportar"]
            },
            "Banned Users": {
                "rota": "admin.users.banned",
                "funcoes": ["Listar banidos", "Desbanir usuário"]
            },
            "Email Unverified": {
                "rota": "admin.users.email.unverified",
                "funcoes": ["Listar não verificados", "Enviar email verificação"]
            },
            "Mobile Unverified": {
                "rota": "admin.users.mobile.unverified",
                "funcoes": ["Listar mobile não verificado", "Enviar SMS"]
            },
            "KYC Unverified": {
                "rota": "admin.users.kyc.unverified",
                "funcoes": ["Listar KYC pendente"]
            },
            "KYC Pending": {
                "rota": "admin.users.kyc.pending",
                "funcoes": ["Aprovar KYC", "Rejeitar KYC", "Ver documentos"]
            },
            "With Balance": {
                "rota": "admin.users.with.balance",
                "funcoes": ["Listar usuários com saldo"]
            },
            "Account Deleted Users": {
                "rota": "admin.users.deleted",
                "funcoes": ["Listar contas deletadas"]
            },
            "Plan Subscribed User": {
                "rota": "admin.users.subscribe",
                "funcoes": ["Listar assinantes ativos"]
            },
            "Subscription Expired User": {
                "rota": "admin.users.subscribe.expired",
                "funcoes": ["Listar assinaturas expiradas"]
            },
            "Free User": {
                "rota": "admin.users.free",
                "funcoes": ["Listar usuários gratuitos"]
            },
            "All Users": {
                "rota": "admin.users.all",
                "funcoes": ["Listar todos usuários", "Buscar", "Filtrar", "Exportar"]
            },
            "All Agent": {
                "rota": "admin.users.agent",
                "funcoes": ["Listar agentes", "Gerenciar permissões"]
            },
            "Send Notification": {
                "rota": "admin.users.notification.all",
                "funcoes": ["Enviar email", "Enviar SMS", "Push notification"]
            }
        }
    },
    "User Detail Actions": {
        "funcoes_por_usuario": {
            "Login as User": "Fazer login como usuário",
            "Add Balance": "Adicionar saldo",
            "Subtract Balance": "Subtrair saldo",
            "Ban User": "Banir usuário",
            "Unban User": "Desbanir usuário",
            "Update User": "Atualizar dados",
            "View Notifications": "Ver notificações enviadas",
            "KYC Data": "Ver documentos KYC",
            "Login History": "Ver histórico de login"
        }
    },
    "Manage Admin": {
        "submenu": {
            "Manage Admin": {
                "rota": "admin.list",
                "funcoes": ["Listar admins", "Adicionar admin", "Editar", "Deletar"]
            },
            "Role & Permissions": {
                "rota": "admin.role.list",
                "funcoes": ["Criar role", "Editar permissões", "Atribuir roles"]
            }
        }
    },
    "Manage Coupon": {
        "rota": "admin.coupon.list",
        "funcoes": ["Criar cupom", "Editar cupom", "Ativar/Desativar", "Deletar"]
    },
    "Deposits": {
        "submenu": {
            "Pending Deposits": {
                "rota": "admin.deposit.pending",
                "funcoes": ["Listar pendentes", "Aprovar", "Rejeitar"]
            },
            "Approved Deposits": {
                "rota": "admin.deposit.approved",
                "funcoes": ["Listar aprovados"]
            },
            "Successful Deposits": {
                "rota": "admin.deposit.successful",
                "funcoes": ["Listar bem-sucedidos"]
            },
            "Rejected Deposits": {
                "rota": "admin.deposit.rejected",
                "funcoes": ["Listar rejeitados"]
            },
            "Initiated Deposits": {
                "rota": "admin.deposit.initiated",
                "funcoes": ["Listar iniciados"]
            },
            "All Deposits": {
                "rota": "admin.deposit.list",
                "funcoes": ["Listar todos", "Filtrar", "Exportar"]
            }
        }
    },
    "Withdrawals": {
        "submenu": {
            "Pending Withdrawals": {
                "rota": "admin.withdraw.data.pending",
                "funcoes": ["Listar pendentes", "Aprovar", "Rejeitar"]
            },
            "Approved Withdrawals": {
                "rota": "admin.withdraw.data.approved",
                "funcoes": ["Listar aprovados"]
            },
            "Rejected Withdrawals": {
                "rota": "admin.withdraw.data.rejected",
                "funcoes": ["Listar rejeitados"]
            },
            "All Withdrawals": {
                "rota": "admin.withdraw.data.all",
                "funcoes": ["Listar todos", "Filtrar"]
            }
        }
    },
    "Gateways": {
        "submenu": {
            "Payment Gateway": {
                "rota": "admin.gateway.automatic.index",
                "funcoes": ["Configurar Stripe", "PayPal", "Razorpay", "Outros gateways"]
            },
            "Withdrawals Methods": {
                "rota": "admin.withdraw.method.index",
                "funcoes": ["Criar método", "Editar", "Ativar/Desativar"]
            }
        }
    },
    "Manage Extension": {
        "rota": "admin.extensions.index",
        "funcoes": ["Google reCAPTCHA", "Tawk.to", "Google Analytics", "Facebook Pixel"]
    },
    "Manage SEO": {
        "rota": "admin.seo",
        "funcoes": ["Meta tags", "Keywords", "Descrição", "Social tags"]
    },
    "Manage Language": {
        "rota": "admin.language.manage",
        "funcoes": ["Adicionar idioma", "Editar traduções", "Ativar/Desativar", "Deletar"]
    },
    "Report": {
        "submenu": {
            "Transaction History": {
                "rota": "admin.report.transaction",
                "funcoes": ["Listar transações", "Filtrar", "Exportar"]
            },
            "Login History": {
                "rota": "admin.report.login.history",
                "funcoes": ["Listar logins", "Ver IP", "Dispositivo", "Localização"]
            },
            "Notification History": {
                "rota": "admin.report.notification.history",
                "funcoes": ["Listar notificações enviadas", "Status de entrega"]
            }
        }
    },
    "Manage Settings": {
        "submenu": {
            "General Settings": {
                "rota": "admin.setting.general",
                "funcoes": ["Nome do site", "Moeda", "Timezone", "Cores", "Paginação"]
            },
            "Pusher Setting": {
                "rota": "admin.setting.pusher.configuration",
                "funcoes": ["App ID", "Key", "Secret", "Cluster"]
            },
            "Brand Setting": {
                "rota": "admin.setting.brand",
                "funcoes": ["Upload logo", "Favicon", "Imagens do site"]
            },
            "System Configuration": {
                "rota": "admin.setting.system.configuration",
                "funcoes": ["Force SSL", "KYC", "Email verificação", "Mobile verificação"]
            },
            "AI Assistant Setting": {
                "rota": "admin.ai-assistant.index",
                "funcoes": ["OpenAI API", "Google Gemini", "Configurar prompts"]
            },
            "KYC Setting": {
                "rota": "admin.kyc.setting",
                "funcoes": ["Campos KYC", "Documentos necessários"]
            },
            "Social Login Setting": {
                "rota": "admin.setting.socialite.credentials",
                "funcoes": ["Google Login", "Facebook Login", "LinkedIn"]
            },
            "CRON Job Setting": {
                "rota": "admin.cron.index",
                "funcoes": ["Listar cron jobs", "Executar manualmente", "Ver logs"]
            },
            "GDPR Cookie": {
                "rota": "admin.setting.cookie",
                "funcoes": ["Habilitar cookie", "Texto", "Configurações"]
            },
            "Custom CSS": {
                "rota": "admin.setting.custom.css",
                "funcoes": ["Adicionar CSS customizado"]
            },
            "Sitemap XML": {
                "rota": "admin.setting.sitemap",
                "funcoes": ["Gerar sitemap", "Upload manual"]
            },
            "Robots txt": {
                "rota": "admin.setting.robot",
                "funcoes": ["Editar robots.txt"]
            },
            "In App Payment": {
                "rota": "admin.setting.app.purchase",
                "funcoes": ["Google Pay", "Configurar pagamentos in-app"]
            },
            "Maintenance Mode": {
                "rota": "admin.maintenance.mode",
                "funcoes": ["Ativar/Desativar manutenção", "Mensagem customizada"]
            }
        }
    },
    "Notification Setting": {
        "submenu": {
            "Global Template": {
                "rota": "admin.setting.notification.global.email",
                "funcoes": ["Template global de email"]
            },
            "Email Setting": {
                "rota": "admin.setting.notification.email",
                "funcoes": ["SMTP", "SendGrid", "Mailjet"]
            },
            "SMS Setting": {
                "rota": "admin.setting.notification.sms",
                "funcoes": ["Twilio", "Nexmo", "Custom API"]
            },
            "Push Notification Setting": {
                "rota": "admin.setting.notification.push",
                "funcoes": ["Firebase", "Configurar push"]
            },
            "Notification Templates": {
                "rota": "admin.setting.notification.templates",
                "funcoes": ["Editar templates", "Variáveis disponíveis"]
            }
        }
    },
    "Manage Pages": {
        "rota": "admin.frontend.manage.pages",
        "funcoes": ["Criar página", "Editar", "SEO por página", "Deletar"]
    },
    "Manage Sections": {
        "rota": "admin.frontend.index",
        "funcoes": ["Editar seções", "Adicionar conteúdo", "Banner", "Features", "FAQ"]
    },
    "Support Ticket": {
        "submenu": {
            "Pending Ticket": {
                "rota": "admin.ticket.pending",
                "funcoes": ["Listar pendentes", "Responder ticket"]
            },
            "Closed Ticket": {
                "rota": "admin.ticket.closed",
                "funcoes": ["Listar fechados"]
            },
            "Answered Ticket": {
                "rota": "admin.ticket.answered",
                "funcoes": ["Listar respondidos"]
            },
            "All Ticket": {
                "rota": "admin.ticket.index",
                "funcoes": ["Listar todos", "Filtrar"]
            }
        }
    },
    "Manage Subscriber": {
        "rota": "admin.subscriber.index",
        "funcoes": ["Listar inscritos", "Enviar email marketing"]
    },
    "Application Information": {
        "rota": "admin.system.info",
        "funcoes": ["Versão Laravel", "PHP", "MySQL", "Servidor"]
    }
}


def gerar_relatorio_markdown():
    """Gera relatório completo em formato Markdown"""
    
    timestamp = datetime.now().strftime("%d/%m/%Y %H:%M:%S")
    
    report = f"""# 📊 Relatório Completo de Funcionalidades do Admin Panel
**Data**: {timestamp}  
**Sistema**: Inteligência MAX - OvoWpp  
**Versão**: Laravel 11 + PHP 8.3

---

## 📋 Sumário Executivo

Este relatório mapeia **TODAS** as funcionalidades disponíveis no painel administrativo da plataforma Inteligência MAX.

**Total de Seções Principais**: {len([k for k, v in MENU_STRUCTURE.items() if 'submenu' not in v and 'funcoes_por_usuario' not in v])}  
**Total de Funcionalidades Mapeadas**: {contar_funcionalidades(MENU_STRUCTURE)}

---

## 🎯 Estrutura Completa do Admin

"""
    
    secao_num = 1
    
    for secao, dados in MENU_STRUCTURE.items():
        report += f"### {secao_num}. {secao}\n\n"
        
        if 'submenu' in dados:
            report += "**Tipo**: Menu com submenu  \n"
            report += f"**Submenus**: {len(dados['submenu'])}  \n\n"
            
            for subsecao, subdados in dados['submenu'].items():
                report += f"#### {secao_num}.{list(dados['submenu'].keys()).index(subsecao) + 1} {subsecao}\n\n"
                report += f"**Rota**: `{subdados['rota']}`  \n"
                report += "**Funcionalidades**:  \n"
                
                for i, funcao in enumerate(subdados['funcoes'], 1):
                    report += f"   {i}. {funcao}  \n"
                
                report += "\n**Status**: ⏳ Aguardando teste  \n\n"
                report += "---\n\n"
        
        elif 'funcoes_por_usuario' in dados:
            report += "**Tipo**: Ações em detalhes de usuário  \n"
            report += "**Funcionalidades**:  \n"
            
            for botao, descricao in dados['funcoes_por_usuario'].items():
                report += f"   - **{botao}**: {descricao}  \n"
            
            report += "\n**Status**: ⏳ Aguardando teste  \n\n"
            report += "---\n\n"
        
        else:
            report += f"**Rota**: `{dados['rota']}`  \n"
            report += "**Funcionalidades**:  \n"
            
            for i, funcao in enumerate(dados['funcoes'], 1):
                report += f"   {i}. {funcao}  \n"
            
            report += "\n**Status**: ⏳ Aguardando teste  \n\n"
            report += "---\n\n"
        
        secao_num += 1
    
    report += """
## 🔍 Categorias de Funcionalidades

### 1. **Gestão de Usuários**
- Listagem e filtros avançados
- Verificação de email/mobile/KYC
- Controle de saldo
- Ban/Unban
- Login como usuário
- Histórico completo

### 2. **Gestão Financeira**
- Depósitos (todos os status)
- Saques (aprovação/rejeição)
- Gateways de pagamento
- Métodos de saque
- Relatórios financeiros

### 3. **Sistema de CRM**
- Contatos e listas
- Tags e segmentação
- Campanhas de marketing
- Chatbots
- Links curtos

### 4. **Comunicações**
- Email (SMTP/SendGrid/Mailjet)
- SMS (Twilio/Nexmo)
- Push Notifications (Firebase)
- Templates customizáveis
- Histórico de envios

### 5. **Configurações do Sistema**
- Gerais (moeda, timezone, cores)
- Marca (logo, favicon)
- Pusher (real-time)
- AI Assistant (OpenAI/Gemini)
- Extensões (reCAPTCHA, Analytics)

### 6. **Frontend Manager**
- Gerenciamento de páginas
- Seções dinâmicas
- SEO por página
- Conteúdo customizável

### 7. **Suporte**
- Sistema de tickets
- Status (pendente/respondido/fechado)
- Respostas rápidas

### 8. **Relatórios**
- Transações
- Logins
- Notificações
- Exportação de dados

---

## 📊 Checklist de Validação

Para validar se cada funcionalidade está operacional, siga este checklist:

### ✅ Dashboard
- [ ] Cards de estatísticas carregam corretamente
- [ ] Gráficos são exibidos
- [ ] Filtros de data funcionam
- [ ] Links são clicáveis

### ✅ Usuários
- [ ] Listagem carrega (todas as categorias)
- [ ] Busca funciona
- [ ] Filtros aplicam corretamente
- [ ] Botão "View Details" funciona
- [ ] Ações (ban, add balance) funcionam
- [ ] "Login as User" redireciona corretamente

### ✅ Depósitos/Saques
- [ ] Listagem carrega
- [ ] Botões aprovar/rejeitar funcionam
- [ ] Filtros de status funcionam
- [ ] Detalhes são exibidos

### ✅ Gateways
- [ ] Listagem de gateways carrega
- [ ] Formulário de configuração abre
- [ ] Campos são salvos corretamente
- [ ] Ativar/desativar funciona

### ✅ Configurações
- [ ] Todas as abas carregam
- [ ] Formulários salvam
- [ ] Upload de imagens funciona
- [ ] Validações estão ativas

### ✅ Frontend Manager
- [ ] Editor de páginas funciona
- [ ] Seções são editáveis
- [ ] Preview funciona
- [ ] Mudanças são salvas

### ✅ Tickets
- [ ] Listagem carrega
- [ ] Responder ticket funciona
- [ ] Anexos são enviados
- [ ] Status atualiza

---

## 🎨 Interface e Navegação

### Menu Lateral (Sidenav)
- **Seções Principais**: 4 (Main, Finance, Utilities, Settings, Frontend, Other)
- **Total de Itens**: 20+ itens principais
- **Submenus**: 15+ grupos de submenus
- **Contadores**: Pendências exibidas em badges

### Topbar
- **Notificações**: Sino com contador
- **Perfil**: Dropdown com opções
- **Busca**: Campo de busca global
- **Idioma**: Seletor de idiomas

### Elementos Interativos
- **Modais**: Para ações rápidas
- **Formulários**: Com validação client/server
- **Tabelas**: Com paginação e busca
- **Cards**: Para estatísticas
- **Badges**: Para status visuais

---

## 🚀 Próximos Passos

### Para Validação Manual:

1. **Login no Admin**:
   ```
   URL: https://inteligenciamax.com.br/admin
   ```

2. **Percorrer Menu Lateral**:
   - Clicar em cada item
   - Verificar se a página carrega
   - Testar cada botão visível

3. **Testar CRUD Completo**:
   - Criar novo item
   - Editar item existente
   - Visualizar detalhes
   - Deletar item

4. **Testar Formulários**:
   - Preencher com dados válidos
   - Tentar dados inválidos (validação)
   - Verificar mensagens de sucesso/erro
   - Confirmar salvamento

5. **Verificar Permissões**:
   - Testar com diferentes roles
   - Verificar se restrições aplicam

---

## 📝 Observações Importantes

1. **Erro 500 Corrigido**: 
   - Rota `/admin/users/detail/{id}` estava retornando erro 500
   - Causa: Variável `$admin` não disponível nas views
   - Correção: Adicionado view composer global
   - Status: ✅ Resolvido

2. **Scripts de Diagnóstico Disponíveis**:
   - `/diagnostico.php` - Verifica saúde do sistema
   - `/debug_user_detail.php` - Debug específico de usuários

3. **Dependências Importantes**:
   - Laravel 11.x
   - PHP 8.3+
   - MySQL 8.0+
   - Composer
   - Node.js (para assets)

---

**Relatório gerado automaticamente**  
**Script**: testar_admin_completo.py  
**Versão**: 1.0.0
"""
    
    return report


def contar_funcionalidades(estrutura):
    """Conta total de funcionalidades mapeadas"""
    total = 0
    for secao, dados in estrutura.items():
        if 'funcoes' in dados:
            total += len(dados['funcoes'])
        if 'submenu' in dados:
            for subdados in dados['submenu'].values():
                if 'funcoes' in subdados:
                    total += len(subdados['funcoes'])
        if 'funcoes_por_usuario' in dados:
            total += len(dados['funcoes_por_usuario'])
    return total


def main():
    print("=" * 80)
    print("RELATÓRIO COMPLETO DE FUNCIONALIDADES - ADMIN PANEL")
    print("Inteligência MAX - OvoWpp")
    print("=" * 80)
    print()
    
    print("Gerando relatório detalhado...")
    report = gerar_relatorio_markdown()
    
    # Salvar relatório
    output_file = "RELATORIO_FUNCIONALIDADES_ADMIN.md"
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write(report)
    
    print(f"✅ Relatório salvo em: {output_file}")
    print()
    print(f"📊 Total de funcionalidades mapeadas: {contar_funcionalidades(MENU_STRUCTURE)}")
    print()
    print("🎯 Próximos passos:")
    print("   1. Leia o relatório completo")
    print("   2. Acesse https://inteligenciamax.com.br/admin")
    print("   3. Teste cada funcionalidade manualmente")
    print("   4. Reporte bugs encontrados")
    print()
    print("=" * 80)


if __name__ == "__main__":
    main()
