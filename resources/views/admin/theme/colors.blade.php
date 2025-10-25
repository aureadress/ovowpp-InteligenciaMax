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
