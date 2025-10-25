@extends('admin.layouts.app')

@section('panel')
    <div class="row gy-4">
        <!-- Formulário de Cores -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="las la-palette"></i> Personalização de Cores
                    </h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="resetColors()">
                        <i class="las la-redo-alt"></i> Restaurar Padrão
                    </button>
                </div>
                <div class="card-body">
                    <form id="colorForm" method="POST">
                        @csrf
                        
                        <!-- Admin Dashboard Colors -->
                        <div class="color-section mb-5">
                            <div class="section-header mb-4">
                                <h4 class="section-title">
                                    <i class="las la-user-shield text-primary"></i>
                                    Painel Administrativo (Admin)
                                </h4>
                                <p class="text-muted small">Cores do painel de administração</p>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cor Primária</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="admin_primary_color" 
                                                   value="{{ $theme->admin_primary_color }}"
                                                   title="Escolha a cor primária do admin">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->admin_primary_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor principal dos botões e links</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cor Secundária</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="admin_secondary_color" 
                                                   value="{{ $theme->admin_secondary_color }}"
                                                   title="Escolha a cor secundária do admin">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->admin_secondary_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor de elementos secundários</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cor de Destaque</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="admin_accent_color" 
                                                   value="{{ $theme->admin_accent_color }}"
                                                   title="Escolha a cor de destaque do admin">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->admin_accent_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor para elementos em destaque</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Fundo da Sidebar</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="admin_sidebar_bg" 
                                                   value="{{ $theme->admin_sidebar_bg }}"
                                                   title="Escolha a cor de fundo da sidebar">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->admin_sidebar_bg }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor de fundo do menu lateral</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Texto da Sidebar</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="admin_sidebar_text" 
                                                   value="{{ $theme->admin_sidebar_text }}"
                                                   title="Escolha a cor do texto da sidebar">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->admin_sidebar_text }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor do texto do menu lateral</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <!-- User Dashboard Colors -->
                        <div class="color-section mb-5">
                            <div class="section-header mb-4">
                                <h4 class="section-title">
                                    <i class="las la-user text-success"></i>
                                    Dashboard do Usuário (User)
                                </h4>
                                <p class="text-muted small">Cores do painel do usuário</p>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cor Primária</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="user_primary_color" 
                                                   value="{{ $theme->user_primary_color }}"
                                                   title="Escolha a cor primária do user">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->user_primary_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor principal do dashboard</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cor Secundária</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="user_secondary_color" 
                                                   value="{{ $theme->user_secondary_color }}"
                                                   title="Escolha a cor secundária do user">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->user_secondary_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor de elementos secundários</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cor de Destaque</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="user_accent_color" 
                                                   value="{{ $theme->user_accent_color }}"
                                                   title="Escolha a cor de destaque do user">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->user_accent_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor para elementos em destaque</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Fundo da Sidebar</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="user_sidebar_bg" 
                                                   value="{{ $theme->user_sidebar_bg }}"
                                                   title="Escolha a cor de fundo da sidebar">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->user_sidebar_bg }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor de fundo do menu lateral</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Texto da Sidebar</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="user_sidebar_text" 
                                                   value="{{ $theme->user_sidebar_text }}"
                                                   title="Escolha a cor do texto da sidebar">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->user_sidebar_text }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor do texto do menu lateral</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <!-- Chat/Inbox Colors -->
                        <div class="color-section mb-5">
                            <div class="section-header mb-4">
                                <h4 class="section-title">
                                    <i class="lab la-whatsapp text-success"></i>
                                    Chat / Inbox (Mensagens)
                                </h4>
                                <p class="text-muted small">Cores do sistema de mensagens</p>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cor Primária</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="chat_primary_color" 
                                                   value="{{ $theme->chat_primary_color }}"
                                                   title="Escolha a cor primária do chat">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->chat_primary_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor principal do chat</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cor Secundária</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="chat_secondary_color" 
                                                   value="{{ $theme->chat_secondary_color }}"
                                                   title="Escolha a cor secundária do chat">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->chat_secondary_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor de elementos secundários</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Mensagem Enviada</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="chat_bubble_sent" 
                                                   value="{{ $theme->chat_bubble_sent }}"
                                                   title="Escolha a cor das mensagens enviadas">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->chat_bubble_sent }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor das bolhas de mensagem enviadas</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Mensagem Recebida</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="chat_bubble_received" 
                                                   value="{{ $theme->chat_bubble_received }}"
                                                   title="Escolha a cor das mensagens recebidas">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->chat_bubble_received }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor das bolhas de mensagem recebidas</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="color-picker-group">
                                        <label class="form-label">Cabeçalho do Chat</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="chat_header_bg" 
                                                   value="{{ $theme->chat_header_bg }}"
                                                   title="Escolha a cor do cabeçalho do chat">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->chat_header_bg }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Cor do cabeçalho das conversas</small>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr class="my-5">

                        <!-- Frontend Public Colors -->
                        <div class="color-section mb-5">
                            <div class="section-header mb-4">
                                <h4 class="section-title">
                                    <i class="las la-globe-americas text-primary"></i>
                                    Frontend Público (Home, Landing Pages)
                                </h4>
                                <p class="text-muted small">Cores das páginas públicas acessíveis sem login</p>
                            </div>
                            
                            <!-- Botões -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-hand-pointer"></i> Botões
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Botão Primário</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_btn_primary" 
                                                       value="{{ $theme->frontend_btn_primary ?? '#29B6F6' }}"
                                                       title="Cor do botão primário">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_btn_primary ?? '#29B6F6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor principal dos botões de ação</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Botão Primário (Hover)</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_btn_primary_hover" 
                                                       value="{{ $theme->frontend_btn_primary_hover ?? '#0288D1' }}"
                                                       title="Cor ao passar o mouse">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_btn_primary_hover ?? '#0288D1' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor ao passar o mouse sobre o botão</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Botão Secundário</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_btn_secondary" 
                                                       value="{{ $theme->frontend_btn_secondary ?? '#6c757d' }}"
                                                       title="Cor do botão secundário">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_btn_secondary ?? '#6c757d' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de botões secundários</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Botão Secundário (Hover)</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_btn_secondary_hover" 
                                                       value="{{ $theme->frontend_btn_secondary_hover ?? '#5a6268' }}"
                                                       title="Cor ao passar o mouse">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_btn_secondary_hover ?? '#5a6268' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor ao passar mouse no botão secundário</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Texto dos Botões</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_btn_text" 
                                                       value="{{ $theme->frontend_btn_text ?? '#ffffff' }}"
                                                       title="Cor do texto dos botões">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_btn_text ?? '#ffffff' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor do texto dentro dos botões</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Header/Navbar -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-bars"></i> Cabeçalho / Menu de Navegação
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Fundo do Header</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_header_bg" 
                                                       value="{{ $theme->frontend_header_bg ?? '#ffffff' }}"
                                                       title="Cor de fundo do header">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_header_bg ?? '#ffffff' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de fundo do cabeçalho</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Texto do Header</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_header_text" 
                                                       value="{{ $theme->frontend_header_text ?? '#212529' }}"
                                                       title="Cor do texto do header">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_header_text ?? '#212529' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor do texto no cabeçalho</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Links do Header</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_header_link" 
                                                       value="{{ $theme->frontend_header_link ?? '#29B6F6' }}"
                                                       title="Cor dos links do header">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_header_link ?? '#29B6F6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor dos links de navegação</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Links do Header (Hover)</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_header_link_hover" 
                                                       value="{{ $theme->frontend_header_link_hover ?? '#0288D1' }}"
                                                       title="Cor ao passar o mouse">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_header_link_hover ?? '#0288D1' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor ao passar mouse nos links</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-th"></i> Rodapé
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Fundo do Rodapé</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_footer_bg" 
                                                       value="{{ $theme->frontend_footer_bg ?? '#212529' }}"
                                                       title="Cor de fundo do rodapé">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_footer_bg ?? '#212529' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de fundo do footer</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Texto do Rodapé</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_footer_text" 
                                                       value="{{ $theme->frontend_footer_text ?? '#ffffff' }}"
                                                       title="Cor do texto do rodapé">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_footer_text ?? '#ffffff' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor do texto no footer</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Links do Rodapé</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_footer_link" 
                                                       value="{{ $theme->frontend_footer_link ?? '#29B6F6' }}"
                                                       title="Cor dos links do rodapé">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_footer_link ?? '#29B6F6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor dos links no footer</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Links do Rodapé (Hover)</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_footer_link_hover" 
                                                       value="{{ $theme->frontend_footer_link_hover ?? '#0288D1' }}"
                                                       title="Cor ao passar o mouse">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_footer_link_hover ?? '#0288D1' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor ao passar mouse nos links</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Background & Gradiente -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-fill-drip"></i> Fundo da Página & Gradiente
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Cor de Fundo</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_bg_color" 
                                                       value="{{ $theme->frontend_bg_color ?? '#ffffff' }}"
                                                       title="Cor de fundo da página">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_bg_color ?? '#ffffff' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de fundo principal</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Gradiente - Início</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_bg_gradient_start" 
                                                       value="{{ $theme->frontend_bg_gradient_start ?? '#29B6F6' }}"
                                                       title="Cor inicial do gradiente">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_bg_gradient_start ?? '#29B6F6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de início do gradiente</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Gradiente - Fim</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_bg_gradient_end" 
                                                       value="{{ $theme->frontend_bg_gradient_end ?? '#0288D1' }}"
                                                       title="Cor final do gradiente">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_bg_gradient_end ?? '#0288D1' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de fim do gradiente</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Usar Gradiente?</label>
                                            <div class="form-check form-switch" style="padding-top: 10px;">
                                                <input class="form-check-input" type="checkbox" role="switch" 
                                                       name="frontend_use_gradient" 
                                                       id="useGradient"
                                                       value="1"
                                                       {{ ($theme->frontend_use_gradient ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="useGradient">
                                                    Ativar fundo em gradiente
                                                </label>
                                            </div>
                                            <small class="text-muted">Usar gradiente ao invés de cor sólida</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cards/Seções -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-layer-group"></i> Cards e Seções
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Fundo dos Cards</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_card_bg" 
                                                       value="{{ $theme->frontend_card_bg ?? '#ffffff' }}"
                                                       title="Cor de fundo dos cards">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_card_bg ?? '#ffffff' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de fundo dos cartões</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Borda dos Cards</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_card_border" 
                                                       value="{{ $theme->frontend_card_border ?? '#dee2e6' }}"
                                                       title="Cor da borda dos cards">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_card_border ?? '#dee2e6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor das bordas dos cartões</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Sombra dos Cards</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_card_shadow" 
                                                       value="{{ substr($theme->frontend_card_shadow ?? '#00000020', 0, 7) }}"
                                                       title="Cor da sombra dos cards">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_card_shadow ?? '#00000020' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor da sombra (pode ter transparência)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Textos -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-font"></i> Textos e Títulos
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Texto Principal</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_text_primary" 
                                                       value="{{ $theme->frontend_text_primary ?? '#212529' }}"
                                                       title="Cor do texto principal">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_text_primary ?? '#212529' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor principal do texto</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Texto Secundário</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_text_secondary" 
                                                       value="{{ $theme->frontend_text_secondary ?? '#6c757d' }}"
                                                       title="Cor do texto secundário">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_text_secondary ?? '#6c757d' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de textos secundários</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Títulos (H1, H2, H3)</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_heading_color" 
                                                       value="{{ $theme->frontend_heading_color ?? '#212529' }}"
                                                       title="Cor dos títulos">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_heading_color ?? '#212529' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor dos cabeçalhos e títulos</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Links -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-link"></i> Links
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="color-picker-group">
                                            <label class="form-label">Cor dos Links</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_link_color" 
                                                       value="{{ $theme->frontend_link_color ?? '#29B6F6' }}"
                                                       title="Cor dos links">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_link_color ?? '#29B6F6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor dos links no conteúdo</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="color-picker-group">
                                            <label class="form-label">Links (Hover)</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_link_hover" 
                                                       value="{{ $theme->frontend_link_hover ?? '#0288D1' }}"
                                                       title="Cor ao passar o mouse">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_link_hover ?? '#0288D1' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor ao passar mouse nos links</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modais -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-window-restore"></i> Modais / Pop-ups
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Fundo do Modal</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_modal_bg" 
                                                       value="{{ $theme->frontend_modal_bg ?? '#ffffff' }}"
                                                       title="Cor de fundo do modal">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_modal_bg ?? '#ffffff' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de fundo dos modais</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Cabeçalho do Modal</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_modal_header_bg" 
                                                       value="{{ $theme->frontend_modal_header_bg ?? '#29B6F6' }}"
                                                       title="Cor do cabeçalho">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_modal_header_bg ?? '#29B6F6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor do topo do modal</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Texto do Cabeçalho</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_modal_header_text" 
                                                       value="{{ $theme->frontend_modal_header_text ?? '#ffffff' }}"
                                                       title="Cor do texto do cabeçalho">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_modal_header_text ?? '#ffffff' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor do texto no topo</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-3">
                                        <div class="color-picker-group">
                                            <label class="form-label">Overlay de Fundo</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_modal_overlay" 
                                                       value="{{ substr($theme->frontend_modal_overlay ?? '#00000080', 0, 7) }}"
                                                       title="Cor do overlay">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_modal_overlay ?? '#00000080' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor do fundo escuro atrás do modal</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bordas -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-border-style"></i> Bordas e Cantos
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="color-picker-group">
                                            <label class="form-label">Cor das Bordas</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_border_color" 
                                                       value="{{ $theme->frontend_border_color ?? '#dee2e6' }}"
                                                       title="Cor das bordas">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_border_color ?? '#dee2e6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor padrão de todas as bordas</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="color-picker-group">
                                            <label class="form-label">Arredondamento (0-99px)</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" 
                                                       name="frontend_border_radius" 
                                                       value="{{ $theme->frontend_border_radius ?? '8' }}"
                                                       min="0"
                                                       max="99"
                                                       title="Raio de arredondamento">
                                                <span class="input-group-text">px</span>
                                            </div>
                                            <small class="text-muted">Arredondamento dos cantos (0 = reto, 50 = muito arredondado)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hero Section -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-image"></i> Seção Hero (Banner Principal)
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Fundo do Hero</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_hero_bg" 
                                                       value="{{ $theme->frontend_hero_bg ?? '#29B6F6' }}"
                                                       title="Cor de fundo do hero">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_hero_bg ?? '#29B6F6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de fundo do banner principal</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Texto do Hero</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_hero_text" 
                                                       value="{{ $theme->frontend_hero_text ?? '#ffffff' }}"
                                                       title="Cor do texto do hero">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_hero_text ?? '#ffffff' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor do texto no banner</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Overlay do Hero</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_hero_overlay" 
                                                       value="{{ substr($theme->frontend_hero_overlay ?? '#00000040', 0, 7) }}"
                                                       title="Cor do overlay">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_hero_overlay ?? '#00000040' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Camada semi-transparente sobre imagem</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Features/Destaques -->
                            <div class="subsection mb-4">
                                <h5 class="subsection-title mb-3">
                                    <i class="las la-star"></i> Features / Destaques
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Fundo das Features</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_feature_bg" 
                                                       value="{{ $theme->frontend_feature_bg ?? '#f8f9fa' }}"
                                                       title="Cor de fundo das features">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_feature_bg ?? '#f8f9fa' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor de fundo dos blocos de destaque</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Ícones das Features</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_feature_icon" 
                                                       value="{{ $theme->frontend_feature_icon ?? '#29B6F6' }}"
                                                       title="Cor dos ícones">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_feature_icon ?? '#29B6F6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor dos ícones de destaque</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="color-picker-group">
                                            <label class="form-label">Borda das Features</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="frontend_feature_border" 
                                                       value="{{ $theme->frontend_feature_border ?? '#dee2e6' }}"
                                                       title="Cor da borda das features">
                                                <input type="text" class="form-control" 
                                                       value="{{ $theme->frontend_feature_border ?? '#dee2e6' }}"
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Cor da borda dos blocos</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-5">

                        <!-- Global Colors -->
                        <div class="color-section mb-4">
                            <div class="section-header mb-4">
                                <h4 class="section-title">
                                    <i class="las la-globe text-info"></i>
                                    Cores Globais (Status e Alertas)
                                </h4>
                                <p class="text-muted small">Cores de status, avisos e notificações</p>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-3">
                                    <div class="color-picker-group">
                                        <label class="form-label">Sucesso</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="success_color" 
                                                   value="{{ $theme->success_color }}"
                                                   title="Escolha a cor de sucesso">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->success_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Mensagens de sucesso</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3">
                                    <div class="color-picker-group">
                                        <label class="form-label">Aviso</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="warning_color" 
                                                   value="{{ $theme->warning_color }}"
                                                   title="Escolha a cor de aviso">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->warning_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Mensagens de aviso</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3">
                                    <div class="color-picker-group">
                                        <label class="form-label">Erro</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="danger_color" 
                                                   value="{{ $theme->danger_color }}"
                                                   title="Escolha a cor de erro">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->danger_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Mensagens de erro</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3">
                                    <div class="color-picker-group">
                                        <label class="form-label">Informação</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   name="info_color" 
                                                   value="{{ $theme->info_color }}"
                                                   title="Escolha a cor de informação">
                                            <input type="text" class="form-control" 
                                                   value="{{ $theme->info_color }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">Mensagens informativas</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="mt-5 d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-outline-secondary" onclick="location.reload()">
                                <i class="las la-times"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" id="saveBtn">
                                <i class="las la-save"></i> Salvar Cores
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Cards -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="las la-eye"></i> Pré-visualização das Cores
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Admin Preview -->
                        <div class="col-md-4">
                            <div class="preview-card" style="border: 2px solid {{ $theme->admin_primary_color }};">
                                <div class="preview-header" style="background: {{ $theme->admin_primary_color }}; color: white; padding: 15px;">
                                    <strong>Admin Dashboard</strong>
                                </div>
                                <div class="preview-body" style="padding: 15px;">
                                    <button class="btn btn-sm mb-2" style="background: {{ $theme->admin_primary_color }}; color: white; border: none;">
                                        Botão Primário
                                    </button>
                                    <button class="btn btn-sm mb-2" style="background: {{ $theme->admin_secondary_color }}; color: white; border: none;">
                                        Botão Secundário
                                    </button>
                                    <button class="btn btn-sm mb-2" style="background: {{ $theme->admin_accent_color }}; color: white; border: none;">
                                        Botão Destaque
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User Preview -->
                        <div class="col-md-4">
                            <div class="preview-card" style="border: 2px solid {{ $theme->user_primary_color }};">
                                <div class="preview-header" style="background: {{ $theme->user_primary_color }}; color: white; padding: 15px;">
                                    <strong>User Dashboard</strong>
                                </div>
                                <div class="preview-body" style="padding: 15px;">
                                    <button class="btn btn-sm mb-2" style="background: {{ $theme->user_primary_color }}; color: white; border: none;">
                                        Botão Primário
                                    </button>
                                    <button class="btn btn-sm mb-2" style="background: {{ $theme->user_secondary_color }}; color: white; border: none;">
                                        Botão Secundário
                                    </button>
                                    <button class="btn btn-sm mb-2" style="background: {{ $theme->user_accent_color }}; color: white; border: none;">
                                        Botão Destaque
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Preview -->
                        <div class="col-md-4">
                            <div class="preview-card" style="border: 2px solid {{ $theme->chat_primary_color }};">
                                <div class="preview-header" style="background: {{ $theme->chat_header_bg }}; color: white; padding: 15px;">
                                    <strong>Chat / Inbox</strong>
                                </div>
                                <div class="preview-body" style="padding: 15px; background: #f5f5f5;">
                                    <div class="mb-2 text-end">
                                        <span class="badge" style="background: {{ $theme->chat_bubble_sent }}; color: #000;">
                                            Mensagem enviada
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge" style="background: {{ $theme->chat_bubble_received }}; color: #000; border: 1px solid #ddd;">
                                            Mensagem recebida
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Frontend Preview -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="las la-eye"></i> Pré-visualização do Frontend Público
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Header Preview -->
                        <div class="col-md-6">
                            <div class="preview-card">
                                <div class="preview-header" style="background: {{ $theme->frontend_header_bg ?? '#ffffff' }}; color: {{ $theme->frontend_header_text ?? '#212529' }}; padding: 15px; border-bottom: 1px solid {{ $theme->frontend_border_color ?? '#dee2e6' }};">
                                    <strong>Cabeçalho</strong>
                                    <a href="#" style="color: {{ $theme->frontend_header_link ?? '#29B6F6' }}; margin-left: 15px;">Link</a>
                                </div>
                                <div class="preview-body" style="padding: 20px; background: {{ $theme->frontend_bg_color ?? '#ffffff' }};">
                                    <h5 style="color: {{ $theme->frontend_heading_color ?? '#212529' }};">Título</h5>
                                    <p style="color: {{ $theme->frontend_text_primary ?? '#212529' }}; margin: 10px 0;">
                                        Texto principal do conteúdo.
                                    </p>
                                    <p style="color: {{ $theme->frontend_text_secondary ?? '#6c757d' }}; font-size: 0.9em;">
                                        Texto secundário menor.
                                    </p>
                                    <button class="btn btn-sm" style="background: {{ $theme->frontend_btn_primary ?? '#29B6F6' }}; color: {{ $theme->frontend_btn_text ?? '#ffffff' }}; border: none; border-radius: {{ $theme->frontend_border_radius ?? '8' }}px; padding: 8px 16px;">
                                        Botão Primário
                                    </button>
                                </div>
                                <div class="preview-footer" style="background: {{ $theme->frontend_footer_bg ?? '#212529' }}; color: {{ $theme->frontend_footer_text ?? '#ffffff' }}; padding: 15px;">
                                    <strong>Rodapé</strong>
                                    <a href="#" style="color: {{ $theme->frontend_footer_link ?? '#29B6F6' }}; margin-left: 15px;">Link</a>
                                </div>
                            </div>
                        </div>

                        <!-- Card & Modal Preview -->
                        <div class="col-md-6">
                            <div style="background: {{ $theme->frontend_card_bg ?? '#ffffff' }}; border: 1px solid {{ $theme->frontend_card_border ?? '#dee2e6' }}; border-radius: {{ $theme->frontend_border_radius ?? '8' }}px; padding: 20px; box-shadow: 0 2px 8px {{ $theme->frontend_card_shadow ?? '#00000020' }};">
                                <h6 style="color: {{ $theme->frontend_heading_color ?? '#212529' }}; margin-bottom: 10px;">
                                    <i class="las la-star" style="color: {{ $theme->frontend_feature_icon ?? '#29B6F6' }};"></i>
                                    Card / Feature
                                </h6>
                                <p style="color: {{ $theme->frontend_text_primary ?? '#212529' }}; font-size: 0.9em; margin-bottom: 15px;">
                                    Exemplo de card com bordas e sombra.
                                </p>
                                <a href="#" style="color: {{ $theme->frontend_link_color ?? '#29B6F6' }};">Link de exemplo</a>
                            </div>
                            
                            <div style="margin-top: 20px; background: {{ $theme->frontend_modal_bg ?? '#ffffff' }}; border: 2px solid {{ $theme->frontend_modal_header_bg ?? '#29B6F6' }}; border-radius: {{ $theme->frontend_border_radius ?? '8' }}px; overflow: hidden;">
                                <div style="background: {{ $theme->frontend_modal_header_bg ?? '#29B6F6' }}; color: {{ $theme->frontend_modal_header_text ?? '#ffffff' }}; padding: 10px 15px;">
                                    <strong>Modal / Pop-up</strong>
                                </div>
                                <div style="padding: 15px;">
                                    <p style="color: {{ $theme->frontend_text_primary ?? '#212529' }}; font-size: 0.85em; margin: 0;">
                                        Exemplo de janela modal
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    .color-section {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    
    .section-header {
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 15px;
    }
    
    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0;
    }
    
    .subsection {
        background: white;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #29B6F6;
    }
    
    .subsection-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0;
    }
    
    .color-picker-group {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        height: 100%;
    }
    
    .color-picker-group label {
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
    }
    
    .form-control-color {
        width: 60px;
        height: 45px;
        border: 1px solid #ced4da;
        cursor: pointer;
    }
    
    .color-picker-group .input-group input[type="text"] {
        background: #f8f9fa;
        font-family: monospace;
        font-weight: 600;
    }
    
    .preview-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .preview-header {
        font-size: 1.1rem;
    }
    
    .preview-body button {
        width: 100%;
        padding: 8px;
        border-radius: 4px;
    }
</style>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";
        
        // Sincronizar color picker com input de texto
        $('input[type="color"]').on('input', function() {
            const color = $(this).val();
            $(this).siblings('input[type="text"]').val(color);
            
            // Atualizar preview em tempo real
            updatePreview();
        });
        
        // Função para atualizar preview
        function updatePreview() {
            // Atualizar preview do Admin
            const adminPrimary = $('input[name="admin_primary_color"]').val();
            const adminSecondary = $('input[name="admin_secondary_color"]').val();
            const adminAccent = $('input[name="admin_accent_color"]').val();
            
            $('.preview-card').eq(0).css('border-color', adminPrimary);
            $('.preview-card').eq(0).find('.preview-header').css('background', adminPrimary);
            $('.preview-card').eq(0).find('button').eq(0).css('background', adminPrimary);
            $('.preview-card').eq(0).find('button').eq(1).css('background', adminSecondary);
            $('.preview-card').eq(0).find('button').eq(2).css('background', adminAccent);
            
            // Atualizar preview do User
            const userPrimary = $('input[name="user_primary_color"]').val();
            const userSecondary = $('input[name="user_secondary_color"]').val();
            const userAccent = $('input[name="user_accent_color"]').val();
            
            $('.preview-card').eq(1).css('border-color', userPrimary);
            $('.preview-card').eq(1).find('.preview-header').css('background', userPrimary);
            $('.preview-card').eq(1).find('button').eq(0).css('background', userPrimary);
            $('.preview-card').eq(1).find('button').eq(1).css('background', userSecondary);
            $('.preview-card').eq(1).find('button').eq(2).css('background', userAccent);
            
            // Atualizar preview do Chat
            const chatPrimary = $('input[name="chat_primary_color"]').val();
            const chatHeader = $('input[name="chat_header_bg"]').val();
            const chatSent = $('input[name="chat_bubble_sent"]').val();
            const chatReceived = $('input[name="chat_bubble_received"]').val();
            
            $('.preview-card').eq(2).css('border-color', chatPrimary);
            $('.preview-card').eq(2).find('.preview-header').css('background', chatHeader);
            $('.preview-card').eq(2).find('.badge').eq(0).css('background', chatSent);
            $('.preview-card').eq(2).find('.badge').eq(1).css('background', chatReceived);
        }
        
        // Submeter formulário via AJAX
        $('#colorForm').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $btn = $('#saveBtn');
            const originalText = $btn.html();
            
            $btn.html('<i class="las la-spinner la-spin"></i> Salvando...').prop('disabled', true);
            
            $.ajax({
                url: "{{ route('admin.theme.colors.update') }}",
                method: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    if (response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        
                        // Recarregar página após 1.5 segundos para aplicar cores
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Erro ao salvar cores!'
                    });
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        for (let field in errors) {
                            errorMsg += errors[field][0] + '\n';
                        }
                        alert(errorMsg);
                    }
                },
                complete: function() {
                    $btn.html(originalText).prop('disabled', false);
                }
            });
        });
        
        // Inicializar SweetAlert Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
    })(jQuery);
    
    // Função para resetar cores
    function resetColors() {
        Swal.fire({
            title: 'Restaurar Cores Padrão?',
            text: "Todas as cores serão restauradas para os valores padrão do sistema.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, restaurar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.theme.colors.reset') }}";
            }
        });
    }
</script>
@endpush
