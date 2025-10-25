<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InstallThemeColorsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:install
                            {--force : Force installation even if table exists}
                            {--reset : Reset colors to default values}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instalar sistema de cores isoladas (Admin/User/Chat)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->showBanner();
        
        // Verificar se a tabela já existe
        if (Schema::hasTable('theme_settings') && !$this->option('force') && !$this->option('reset')) {
            $this->warn('⚠️  Tabela theme_settings já existe!');
            $this->newLine();
            
            $this->showCurrentColors();
            
            $this->info('💡 Use --force para forçar reinstalação ou --reset para resetar cores');
            return Command::SUCCESS;
        }
        
        // Reset colors
        if ($this->option('reset')) {
            return $this->resetColors();
        }
        
        // Executar migration
        $this->info('🚀 Executando migration...');
        $this->newLine();
        
        try {
            $exitCode = Artisan::call('migrate', [
                '--path' => 'database/migrations/2025_10_25_000001_create_theme_settings_table.php',
                '--force' => true
            ]);
            
            if ($exitCode === 0) {
                $this->newLine();
                $this->info('✅ Migration executada com sucesso!');
                $this->newLine();
                
                // Verificar instalação
                $this->verifyInstallation();
                
                $this->newLine();
                $this->showSuccessMessage();
                
                return Command::SUCCESS;
            } else {
                $this->error('❌ Erro ao executar migration!');
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Erro: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
    
    /**
     * Show command banner
     */
    protected function showBanner()
    {
        $this->newLine();
        $this->line('╔═══════════════════════════════════════════════════════════╗');
        $this->line('║                                                           ║');
        $this->line('║         <fg=magenta>🎨 THEME COLORS INSTALLATION 🎨</fg=magenta>                ║');
        $this->line('║                                                           ║');
        $this->line('║         Sistema de Cores Isoladas                        ║');
        $this->line('║         Admin / User / Chat                              ║');
        $this->line('║                                                           ║');
        $this->line('╚═══════════════════════════════════════════════════════════╝');
        $this->newLine();
    }
    
    /**
     * Show current colors
     */
    protected function showCurrentColors()
    {
        $theme = DB::table('theme_settings')->first();
        
        if (!$theme) {
            $this->warn('Nenhuma configuração encontrada.');
            return;
        }
        
        $this->info('📊 Cores Atuais:');
        $this->newLine();
        
        $this->table(
            ['Área', 'Tipo', 'Cor'],
            [
                ['<fg=blue>Admin</fg=blue>', 'Primária', $theme->admin_primary_color],
                ['<fg=blue>Admin</fg=blue>', 'Secundária', $theme->admin_secondary_color],
                ['<fg=blue>Admin</fg=blue>', 'Destaque', $theme->admin_accent_color],
                ['', '', ''],
                ['<fg=green>User</fg=green>', 'Primária', $theme->user_primary_color],
                ['<fg=green>User</fg=green>', 'Secundária', $theme->user_secondary_color],
                ['<fg=green>User</fg=green>', 'Destaque', $theme->user_accent_color],
                ['', '', ''],
                ['<fg=cyan>Chat</fg=cyan>', 'Primária', $theme->chat_primary_color],
                ['<fg=cyan>Chat</fg=cyan>', 'Secundária', $theme->chat_secondary_color],
                ['<fg=cyan>Chat</fg=cyan>', 'Mensagem Enviada', $theme->chat_bubble_sent],
            ]
        );
    }
    
    /**
     * Verify installation
     */
    protected function verifyInstallation()
    {
        $this->info('🔍 Verificando instalação...');
        $this->newLine();
        
        $theme = DB::table('theme_settings')->first();
        
        if ($theme) {
            $this->info('✅ Cores padrão instaladas com sucesso!');
            $this->newLine();
            
            $this->table(
                ['Área', 'Cor Primária'],
                [
                    ['<fg=blue>🔵 Admin Dashboard</fg=blue>', $theme->admin_primary_color],
                    ['<fg=green>🟢 User Dashboard</fg=green>', $theme->user_primary_color],
                    ['<fg=cyan>💬 Chat/Inbox</fg=cyan>', $theme->chat_primary_color],
                ]
            );
        } else {
            $this->warn('⚠️  Tabela criada mas sem dados.');
        }
    }
    
    /**
     * Reset colors to default
     */
    protected function resetColors()
    {
        $this->warn('🔄 Resetando cores para valores padrão...');
        $this->newLine();
        
        try {
            $affected = DB::table('theme_settings')->update([
                'admin_primary_color' => '#29B6F6',
                'admin_secondary_color' => '#004AAD',
                'admin_accent_color' => '#FF6600',
                'admin_sidebar_bg' => '#1a1d29',
                'admin_sidebar_text' => '#ffffff',
                
                'user_primary_color' => '#00BCD4',
                'user_secondary_color' => '#0097A7',
                'user_accent_color' => '#FF5722',
                'user_sidebar_bg' => '#263238',
                'user_sidebar_text' => '#ffffff',
                
                'chat_primary_color' => '#4CAF50',
                'chat_secondary_color' => '#388E3C',
                'chat_bubble_sent' => '#DCF8C6',
                'chat_bubble_received' => '#FFFFFF',
                'chat_header_bg' => '#075E54',
                
                'success_color' => '#28a745',
                'warning_color' => '#ffc107',
                'danger_color' => '#dc3545',
                'info_color' => '#17a2b8',
                
                'theme_name' => 'Default',
            ]);
            
            if ($affected > 0) {
                $this->newLine();
                $this->info('✅ Cores resetadas com sucesso!');
                $this->newLine();
                
                $this->showCurrentColors();
                
                return Command::SUCCESS;
            } else {
                $this->warn('⚠️  Nenhum registro foi atualizado.');
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Erro ao resetar cores: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
    
    /**
     * Show success message
     */
    protected function showSuccessMessage()
    {
        $this->line('╔═══════════════════════════════════════════════════════════╗');
        $this->line('║                                                           ║');
        $this->line('║              <fg=green>🎉 INSTALAÇÃO COMPLETA! 🎉</fg=green>                   ║');
        $this->line('║                                                           ║');
        $this->line('╚═══════════════════════════════════════════════════════════╝');
        $this->newLine();
        
        $this->info('📍 Próximos passos:');
        $this->newLine();
        $this->line('  1. Acesse: <fg=cyan>/admin/theme/colors</fg=cyan>');
        $this->line('  2. Configure as cores para Admin, User e Chat');
        $this->line('  3. Salve as alterações');
        $this->newLine();
        
        $this->comment('💡 Comandos úteis:');
        $this->line('  - Ver cores atuais: <fg=yellow>php artisan theme:install</fg=yellow>');
        $this->line('  - Resetar cores: <fg=yellow>php artisan theme:install --reset</fg=yellow>');
        $this->newLine();
    }
}
