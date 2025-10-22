#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import json
import os

# Dicionário de traduções PT-BR
translations = {
    # Autenticação
    "Welcome Back": "Bem-vindo de Volta",
    "Please enter your credentials to proceed to the next step.": "Por favor, insira suas credenciais para prosseguir para a próxima etapa.",
    "Username": "Usuário",
    "Password": "Senha",
    "Login": "Entrar",
    "Logout": "Sair",
    "Forgot your password": "Esqueceu sua senha",
    "Verify Code": "Verificar Código",
    "Please check your email for the verification code and enter it below": "Por favor, verifique seu e-mail para o código de verificação e insira abaixo",
    "Verify Now": "Verificar Agora",
    "Back to login": "Voltar para o login",
    "Recover Account": "Recuperar Conta",
    "Please enter your email to recover account": "Por favor, insira seu e-mail para recuperar a conta",
    "Email": "E-mail",
    "Submit": "Enviar",
    "Reset Password": "Redefinir Senha",
    "Please enter your new password below to secure your account": "Por favor, insira sua nova senha abaixo para proteger sua conta",
    "New Password": "Nova Senha",
    "Confirm Password": "Confirmar Senha",
    
    # Campos Comuns
    "Name": "Nome",
    "Date": "Data",
    "Type": "Tipo",
    "Status": "Status",
    "Actions": "Ações",
    "Action": "Ação",
    "Edit": "Editar",
    "Delete": "Excluir",
    "Add": "Adicionar",
    "Update": "Atualizar",
    "Save": "Salvar",
    "Cancel": "Cancelar",
    "Close": "Fechar",
    "Search": "Pesquisar",
    "Filter": "Filtrar",
    "Export": "Exportar",
    "Import": "Importar",
    "Details": "Detalhes",
    "View": "Visualizar",
    "Download": "Baixar",
    "Upload": "Enviar",
    "Remove": "Remover",
    "Disable": "Desativar",
    "Enable": "Ativar",
    "Enabled": "Ativado",
    "Disabled": "Desativado",
    "Active": "Ativo",
    "Inactive": "Inativo",
    "Yes": "Sim",
    "No": "Não",
    "All": "Todos",
    "None": "Nenhum",
    "Select": "Selecionar",
    "Select One": "Selecione Um",
    "Choose": "Escolher",
    "Continue": "Continuar",
    "Back": "Voltar",
    "Next": "Próximo",
    "Previous": "Anterior",
    "First": "Primeiro",
    "Last": "Último",
    "Loading": "Carregando",
    "Processing": "Processando",
    "Please wait": "Por favor, aguarde",
    
    # Mensagens Comuns
    "Success": "Sucesso",
    "Error": "Erro",
    "Warning": "Aviso",
    "Info": "Informação",
    "Confirm": "Confirmar",
    "Are you sure?": "Tem certeza?",
    "No data found": "Nenhum dado encontrado",
    "No File": "Nenhum Arquivo",
    "Required": "Obrigatório",
    "Optional": "Opcional",
    "Description": "Descrição",
    "Message": "Mensagem",
    "Title": "Título",
    "Content": "Conteúdo",
    "Image": "Imagem",
    "File": "Arquivo",
    "Attachment": "Anexo",
    
    # Usuários
    "User": "Usuário",
    "Users": "Usuários",
    "All User": "Todos os Usuários",
    "Active User": "Usuário Ativo",
    "Banned User": "Usuário Banido",
    "Profile": "Perfil",
    "My Profile": "Meu Perfil",
    "Update Profile": "Atualizar Perfil",
    "Profile Information": "Informações do Perfil",
    "Change Password": "Alterar Senha",
    "Full Name": "Nome Completo",
    "Email Address": "Endereço de E-mail",
    "Mobile": "Celular",
    "Phone": "Telefone",
    "Address": "Endereço",
    "City": "Cidade",
    "State": "Estado",
    "Country": "País",
    "Zip Code": "CEP",
    
    # Dashboard
    "Dashboard": "Painel",
    "Admin": "Administrador",
    "Home": "Início",
    "Statistics": "Estatísticas",
    "Reports": "Relatórios",
    "Settings": "Configurações",
    "General Setting": "Configurações Gerais",
    "System Configuration": "Configuração do Sistema",
    
    # Notificações
    "Notification": "Notificação",
    "Notifications": "Notificações",
    "New notifications": "Novas notificações",
    "No unread notifications were found": "Nenhuma notificação não lida foi encontrada",
    "Mark All as Read": "Marcar Tudo como Lido",
    "Notification Setting": "Configuração de Notificações",
    "Notification Title": "Título da Notificação",
    "Send Notification": "Enviar Notificação",
    
    # Transações
    "Transaction": "Transação",
    "Transactions": "Transações",
    "Transaction Number": "Número da Transação",
    "Transaction Type": "Tipo de Transação",
    "Amount": "Valor",
    "Balance": "Saldo",
    "Charge": "Taxa",
    "Total": "Total",
    "Currency": "Moeda",
    "Payment": "Pagamento",
    "Method": "Método",
    "Gateway": "Gateway",
    
    # Depósitos
    "Deposit": "Depósito",
    "Deposits": "Depósitos",
    "Pending Deposit": "Depósito Pendente",
    "Deposit Via": "Depósito Via",
    "Approve": "Aprovar",
    "Reject": "Rejeitar",
    "Approved": "Aprovado",
    "Rejected": "Rejeitado",
    "Pending": "Pendente",
    
    # Saques
    "Withdraw": "Saque",
    "Withdrawal": "Saque",
    "Withdrawals": "Saques",
    "Pending Withdrawals": "Saques Pendentes",
    
    # Tickets/Suporte
    "Ticket": "Ticket",
    "Tickets": "Tickets",
    "Pending Ticket": "Ticket Pendente",
    "Support": "Suporte",
    "Support Ticket": "Ticket de Suporte",
    "Open": "Aberto",
    "Closed": "Fechado",
    "Reply": "Responder",
    "Answer": "Resposta",
    
    # WhatsApp/CRM
    "WhatsApp": "WhatsApp",
    "Campaign": "Campanha",
    "Campaigns": "Campanhas",
    "Contact": "Contato",
    "Contacts": "Contatos",
    "Template": "Modelo",
    "Templates": "Modelos",
    "Automation": "Automação",
    "Schedule": "Agendar",
    "Scheduled": "Agendado",
    "Send": "Enviar",
    "Sent": "Enviado",
    "Delivered": "Entregue",
    "Failed": "Falhou",
    "Draft": "Rascunho",
    
    # Sistema
    "System": "Sistema",
    "Configuration": "Configuração",
    "Language": "Idioma",
    "Languages": "Idiomas",
    "Theme": "Tema",
    "Cache": "Cache",
    "Clear Cache": "Limpar Cache",
    "Maintenance": "Manutenção",
    "Maintenance Mode": "Modo de Manutenção",
    "Version": "Versão",
    "Documentation": "Documentação",
    "Help": "Ajuda",
    "About": "Sobre",
    
    # Configurações de Site
    "Site Title": "Título do Site",
    "Site Name": "Nome do Site",
    "Logo": "Logo",
    "Favicon": "Favicon",
    "Copyright": "Direitos Autorais",
    "Footer": "Rodapé",
    "Header": "Cabeçalho",
    "Menu": "Menu",
    "Social Media": "Redes Sociais",
    "Social Links": "Links Sociais",
    
    # SEO
    "SEO": "SEO",
    "SEO Setting": "Configuração de SEO",
    "Meta Title": "Meta Título",
    "Meta Description": "Meta Descrição",
    "Meta Keywords": "Meta Palavras-chave",
    "SEO Image": "Imagem SEO",
    
    # E-mail
    "Email Template": "Modelo de E-mail",
    "Email Configuration": "Configuração de E-mail",
    "Send Email": "Enviar E-mail",
    "Email Subject": "Assunto do E-mail",
    "Email Body": "Corpo do E-mail",
    "SMTP": "SMTP",
    "Send Test Email": "Enviar E-mail de Teste",
    
    # SMS
    "SMS": "SMS",
    "SMS Template": "Modelo de SMS",
    "SMS Configuration": "Configuração de SMS",
    "Send SMS": "Enviar SMS",
    "SMS Body": "Corpo do SMS",
    "Send Test SMS": "Enviar SMS de Teste",
    
    # API
    "API": "API",
    "API Key": "Chave da API",
    "API Secret": "Segredo da API",
    "API Configuration": "Configuração da API",
    "API Documentation": "Documentação da API",
    
    # Planos/Pacotes
    "Plan": "Plano",
    "Plans": "Planos",
    "Package": "Pacote",
    "Packages": "Pacotes",
    "Subscription": "Assinatura",
    "Subscriptions": "Assinaturas",
    "Price": "Preço",
    "Duration": "Duração",
    "Features": "Recursos",
    
    # Blog
    "Blog": "Blog",
    "Post": "Postagem",
    "Posts": "Postagens",
    "Category": "Categoria",
    "Categories": "Categorias",
    "Tag": "Tag",
    "Tags": "Tags",
    "Author": "Autor",
    "Published": "Publicado",
    "Draft": "Rascunho",
    "Publish": "Publicar",
    
    # Páginas
    "Page": "Página",
    "Pages": "Páginas",
    "Home Page": "Página Inicial",
    "About Page": "Página Sobre",
    "Contact Page": "Página de Contato",
    "Terms of Service": "Termos de Serviço",
    "Privacy Policy": "Política de Privacidade",
    "Cookie Policy": "Política de Cookies",
    
    # Relatórios
    "Report": "Relatório",
    "Reports": "Relatórios",
    "Analytics": "Análises",
    "Chart": "Gráfico",
    "Export Report": "Exportar Relatório",
    
    # Datas/Tempo
    "Today": "Hoje",
    "Yesterday": "Ontem",
    "This Week": "Esta Semana",
    "This Month": "Este Mês",
    "Last Month": "Mês Passado",
    "This Year": "Este Ano",
    "Custom Range": "Intervalo Personalizado",
    "From": "De",
    "To": "Até",
    "Start Date": "Data de Início",
    "End Date": "Data de Término",
    "Time": "Hora",
    "Timezone": "Fuso Horário",
    
    # Permissões/Roles
    "Role": "Função",
    "Roles": "Funções",
    "Permission": "Permissão",
    "Permissions": "Permissões",
    "Admin": "Administrador",
    "Manager": "Gerente",
    "Staff": "Equipe",
    "Customer": "Cliente",
    
    # Logs
    "Log": "Log",
    "Logs": "Logs",
    "Activity Log": "Log de Atividades",
    "Error Log": "Log de Erros",
    "Login History": "Histórico de Login",
    
    # Ações de Confirmação
    "Are you sure to delete this?": "Tem certeza que deseja excluir isso?",
    "Are you sure to enable this?": "Tem certeza que deseja ativar isso?",
    "Are you sure to disable this?": "Tem certeza que deseja desativar isso?",
    "Are you sure to remove this?": "Tem certeza que deseja remover isso?",
    "This action cannot be undone": "Esta ação não pode ser desfeita",
    
    # Botões de Conta
    "Register": "Registrar",
    "Sign Up": "Cadastrar",
    "Sign In": "Entrar",
    "Sign Out": "Sair",
    "Create Account": "Criar Conta",
    "Create Free Account": "Criar Conta Gratuita",
    "Get Started": "Começar",
    
    # Navegação
    "Home": "Início",
    "About": "Sobre",
    "Contact": "Contato",
    "Services": "Serviços",
    "Pricing": "Preços",
    "FAQ": "Perguntas Frequentes",
    "Terms": "Termos",
    "Privacy": "Privacidade",
    
    # Mensagens de Status
    "Processing...": "Processando...",
    "Please wait...": "Por favor, aguarde...",
    "Loading...": "Carregando...",
    "Saving...": "Salvando...",
    "Updating...": "Atualizando...",
    "Deleting...": "Excluindo...",
    "Uploading...": "Enviando...",
    "Downloading...": "Baixando...",
    
    # Validações
    "This field is required": "Este campo é obrigatório",
    "Invalid email address": "Endereço de e-mail inválido",
    "Passwords do not match": "As senhas não coincidem",
    "Password must be at least 6 characters": "A senha deve ter pelo menos 6 caracteres",
    "Please select an option": "Por favor, selecione uma opção",
    
    # Configurações Avançadas
    "Advanced Settings": "Configurações Avançadas",
    "General": "Geral",
    "Security": "Segurança",
    "Backup": "Backup",
    "Database": "Banco de Dados",
    "Storage": "Armazenamento",
    "Performance": "Desempenho",
    
    # Específicos do Sistema
    "Quick Link": "Link Rápido",
    "Quick Links": "Links Rápidos",
    "Subscriber": "Assinante",
    "Subscribers": "Assinantes",
    "Newsletter": "Newsletter",
    "Extension": "Extensão",
    "Extensions": "Extensões",
    "Plugin": "Plugin",
    "Plugins": "Plugins",
    "Widget": "Widget",
    "Widgets": "Widgets",
    
    # Adicionar mais conforme necessário
    "Custom": "Personalizado",
    "Default": "Padrão",
    "Options": "Opções",
    "Advanced": "Avançado",
    "Basic": "Básico",
    "Premium": "Premium",
    "Pro": "Pro",
    "Free": "Grátis",
    "Trial": "Teste",
    "Demo": "Demonstração",
}

# Ler arquivo inglês
with open('resources/lang/en.json', 'r', encoding='utf-8') as f:
    en_data = json.load(f)

# Criar traduções PT-BR
pt_data = {}
for key, value in en_data.items():
    # Se temos tradução, usa ela
    if key in translations:
        pt_data[key] = translations[key]
    # Senão, mantém o original (será traduzido manualmente depois)
    else:
        pt_data[key] = value

# Salvar arquivo PT-BR
with open('resources/lang/pt.json', 'w', encoding='utf-8') as f:
    json.dump(pt_data, f, ensure_ascii=False, indent=2)

print(f"✅ Tradução concluída!")
print(f"📊 Total de chaves: {len(en_data)}")
print(f"✅ Traduzidas: {len([k for k in en_data.keys() if k in translations])}")
print(f"⏳ Pendentes: {len([k for k in en_data.keys() if k not in translations])}")
print(f"📁 Arquivo salvo em: resources/lang/pt.json")
