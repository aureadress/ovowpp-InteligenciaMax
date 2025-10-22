<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ThemeRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:refresh 
                            {--force : Force refresh without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpa todos os caches relacionados ao tema e força o reload das configurações';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Deseja limpar todos os caches e recarregar o tema?', true)) {
                $this->info('Operação cancelada.');
                return 0;
            }
        }

        $this->info('🎨 Iniciando atualização do tema...');
        $this->newLine();

        // 1. Limpar cache de configuração
        $this->task('Limpando cache de configuração', function () {
            Artisan::call('config:clear');
            return true;
        });

        // 2. Limpar cache de views
        $this->task('Limpando cache de views', function () {
            Artisan::call('view:clear');
            return true;
        });

        // 3. Limpar cache geral
        $this->task('Limpando cache geral', function () {
            Artisan::call('cache:clear');
            return true;
        });

        // 4. Limpar cache de rotas
        $this->task('Limpando cache de rotas', function () {
            Artisan::call('route:clear');
            return true;
        });

        // 5. Otimizar aplicação
        $this->task('Otimizando aplicação', function () {
            Artisan::call('optimize:clear');
            return true;
        });

        // 6. Verificar arquivos de tema
        $this->newLine();
        $this->info('📁 Verificando arquivos do tema...');
        $this->checkThemeFiles();

        // 7. Mostrar configurações atuais
        $this->newLine();
        $this->info('⚙️ Configurações Atuais do Tema:');
        $this->displayCurrentTheme();

        $this->newLine();
        $this->info('✅ Tema atualizado com sucesso!');
        $this->info('💡 Dica: Pressione Ctrl+F5 no navegador para forçar o reload.');

        return 0;
    }

    /**
     * Verifica se os arquivos essenciais do tema existem
     */
    protected function checkThemeFiles()
    {
        $files = [
            'config/theme.php' => 'Arquivo de configuração',
            'public/assets/theme/theme-custom.css' => 'CSS customizado',
            'resources/views/components/theme-logo.blade.php' => 'Componente de logo',
        ];

        foreach ($files as $path => $description) {
            $fullPath = base_path($path);
            $exists = File::exists($fullPath);
            
            if ($exists) {
                $this->info("  ✓ {$description}: " . $this->formatPath($path));
            } else {
                $this->warn("  ✗ {$description}: NÃO ENCONTRADO");
            }
        }

        // Verificar logos
        $this->newLine();
        $this->info('🖼️ Verificando logotipos:');
        
        $logoLight = config('theme.logo_light');
        $logoDark = config('theme.logo_dark');
        $favicon = config('theme.favicon');

        $this->checkFile($logoLight, 'Logo Light');
        $this->checkFile($logoDark, 'Logo Dark');
        $this->checkFile($favicon, 'Favicon');
    }

    /**
     * Verifica se um arquivo existe
     */
    protected function checkFile($path, $label)
    {
        if (!$path) {
            $this->warn("  ✗ {$label}: não configurado");
            return;
        }

        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
            $size = File::size($fullPath);
            $sizeFormatted = $this->formatBytes($size);
            $this->info("  ✓ {$label}: {$path} ({$sizeFormatted})");
        } else {
            $this->warn("  ✗ {$label}: {$path} (NÃO ENCONTRADO)");
        }
    }

    /**
     * Exibe as configurações atuais do tema
     */
    protected function displayCurrentTheme()
    {
        $theme = [
            'Cor Primária' => config('theme.primary_color', 'não definida'),
            'Cor Secundária' => config('theme.secondary_color', 'não definida'),
            'Cor Accent' => config('theme.accent_color', 'não definida'),
            'Fonte Primária' => config('theme.font_family_primary', 'não definida'),
            'Fonte Heading' => config('theme.font_family_heading', 'não definida'),
            'Logo Light' => config('theme.logo_light', 'não definido'),
            'Logo Dark' => config('theme.logo_dark', 'não definido'),
            'Favicon' => config('theme.favicon', 'não definido'),
        ];

        foreach ($theme as $key => $value) {
            $this->line("  • {$key}: <fg=cyan>{$value}</>");
        }
    }

    /**
     * Formata o caminho do arquivo
     */
    protected function formatPath($path)
    {
        return str_replace(base_path(), '.', base_path($path));
    }

    /**
     * Formata bytes em formato legível
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
