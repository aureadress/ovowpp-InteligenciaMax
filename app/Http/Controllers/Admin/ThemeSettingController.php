<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ThemeSettingController extends Controller
{
    /**
     * Display the theme color settings page
     */
    public function index()
    {
        $pageTitle = 'Configurações de Cores do Tema';
        $theme = ThemeSetting::active();
        
        // Se não existe configuração, criar uma padrão
        if (!$theme) {
            $theme = ThemeSetting::create([
                'theme_name' => 'Default',
                'is_active' => true,
            ]);
        }
        
        return view('admin.theme.colors', compact('pageTitle', 'theme'));
    }

    /**
     * Update theme colors
     */
    public function update(Request $request)
    {
        // Validação dinâmica de cores (aceita hex #RRGGBB ou com transparência #RRGGBBAA)
        $colorRegex = 'required|regex:/^#[0-9A-Fa-f]{6}([0-9A-Fa-f]{2})?$/';
        
        $rules = [
            // Admin colors
            'admin_primary_color' => $colorRegex,
            'admin_secondary_color' => $colorRegex,
            'admin_accent_color' => $colorRegex,
            'admin_sidebar_bg' => $colorRegex,
            'admin_sidebar_text' => $colorRegex,
            
            // User colors
            'user_primary_color' => $colorRegex,
            'user_secondary_color' => $colorRegex,
            'user_accent_color' => $colorRegex,
            'user_sidebar_bg' => $colorRegex,
            'user_sidebar_text' => $colorRegex,
            
            // Chat colors
            'chat_primary_color' => $colorRegex,
            'chat_secondary_color' => $colorRegex,
            'chat_bubble_sent' => $colorRegex,
            'chat_bubble_received' => $colorRegex,
            'chat_header_bg' => $colorRegex,
            
            // Global colors
            'success_color' => $colorRegex,
            'warning_color' => $colorRegex,
            'danger_color' => $colorRegex,
            'info_color' => $colorRegex,
        ];
        
        // Adicionar validações do Frontend (se existirem no request)
        $frontendFields = [
            'frontend_btn_primary', 'frontend_btn_primary_hover', 'frontend_btn_secondary', 
            'frontend_btn_secondary_hover', 'frontend_btn_text', 'frontend_header_bg',
            'frontend_header_text', 'frontend_header_link', 'frontend_header_link_hover',
            'frontend_footer_bg', 'frontend_footer_text', 'frontend_footer_link',
            'frontend_footer_link_hover', 'frontend_bg_color', 'frontend_bg_gradient_start',
            'frontend_bg_gradient_end', 'frontend_card_bg', 'frontend_card_border',
            'frontend_card_shadow', 'frontend_text_primary', 'frontend_text_secondary',
            'frontend_heading_color', 'frontend_link_color', 'frontend_link_hover',
            'frontend_modal_bg', 'frontend_modal_header_bg', 'frontend_modal_header_text',
            'frontend_modal_overlay', 'frontend_border_color', 'frontend_hero_bg',
            'frontend_hero_text', 'frontend_hero_overlay', 'frontend_feature_bg',
            'frontend_feature_icon', 'frontend_feature_border',
        ];
        
        foreach ($frontendFields as $field) {
            if ($request->has($field)) {
                $rules[$field] = $colorRegex;
            }
        }
        
        // Campo especial: border radius (0-99)
        if ($request->has('frontend_border_radius')) {
            $rules['frontend_border_radius'] = 'required|integer|min:0|max:99';
        }
        
        // Campo especial: usar gradiente (boolean)
        if ($request->has('frontend_use_gradient')) {
            $rules['frontend_use_gradient'] = 'required|boolean';
        }
        
        $validator = Validator::make($request->all(), $rules, [
            'regex' => 'O campo :attribute deve ser uma cor hexadecimal válida (ex: #29B6F6)',
            'integer' => 'O campo :attribute deve ser um número inteiro',
            'min' => 'O campo :attribute deve ser no mínimo :min',
            'max' => 'O campo :attribute deve ser no máximo :max',
            'boolean' => 'O campo :attribute deve ser verdadeiro ou falso',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $theme = ThemeSetting::active();
        
        if (!$theme) {
            $theme = new ThemeSetting();
            $theme->theme_name = 'Default';
            $theme->is_active = true;
        }

        // Campos que serão atualizados (todos os fillable do model)
        $updateFields = array_merge([
            'admin_primary_color',
            'admin_secondary_color',
            'admin_accent_color',
            'admin_sidebar_bg',
            'admin_sidebar_text',
            
            'user_primary_color',
            'user_secondary_color',
            'user_accent_color',
            'user_sidebar_bg',
            'user_sidebar_text',
            
            'chat_primary_color',
            'chat_secondary_color',
            'chat_bubble_sent',
            'chat_bubble_received',
            'chat_header_bg',
            
            'success_color',
            'warning_color',
            'danger_color',
            'info_color',
        ], $frontendFields, ['frontend_border_radius', 'frontend_use_gradient']);
        
        // Atualizar apenas os campos presentes no request
        $theme->fill($request->only($updateFields));
        $theme->save();
        
        // Gerar arquivos CSS estáticos
        try {
            $cssGenerated = $this->generateStaticCSS($theme);
            \Log::info('Theme CSS Generation', [
                'success' => $cssGenerated,
                'theme_id' => $theme->id,
                'timestamp' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Theme CSS Generation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        $notify[] = ['success', 'Cores atualizadas com sucesso! Recarregue a página para ver as mudanças.'];
        return response()->json([
            'success' => true,
            'message' => 'Cores atualizadas com sucesso!',
            'notify' => $notify,
        ]);
    }

    /**
     * Reset colors to default
     */
    public function reset()
    {
        $theme = ThemeSetting::active();
        
        if (!$theme) {
            $theme = new ThemeSetting();
        }

        // Reset to default colors
        $theme->admin_primary_color = '#29B6F6';
        $theme->admin_secondary_color = '#004AAD';
        $theme->admin_accent_color = '#FF6600';
        $theme->admin_sidebar_bg = '#1a1d29';
        $theme->admin_sidebar_text = '#ffffff';
        
        $theme->user_primary_color = '#00BCD4';
        $theme->user_secondary_color = '#0097A7';
        $theme->user_accent_color = '#FF5722';
        $theme->user_sidebar_bg = '#263238';
        $theme->user_sidebar_text = '#ffffff';
        
        $theme->chat_primary_color = '#4CAF50';
        $theme->chat_secondary_color = '#388E3C';
        $theme->chat_bubble_sent = '#DCF8C6';
        $theme->chat_bubble_received = '#FFFFFF';
        $theme->chat_header_bg = '#075E54';
        
        $theme->success_color = '#28a745';
        $theme->warning_color = '#ffc107';
        $theme->danger_color = '#dc3545';
        $theme->info_color = '#17a2b8';
        
        $theme->is_active = true;
        $theme->theme_name = 'Default';
        $theme->save();

        $notify[] = ['success', 'Cores restauradas para os valores padrão!'];
        return back()->withNotify($notify);
    }

    /**
     * Get current colors as JSON (for preview)
     */
    public function getColors()
    {
        $theme = ThemeSetting::active();
        
        if (!$theme) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma configuração de tema encontrada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'admin' => $theme->getAdminColors(),
            'user' => $theme->getUserColors(),
            'chat' => $theme->getChatColors(),
            'global' => $theme->getGlobalColors(),
        ]);
    }
    
    /**
     * Generate static CSS files from theme colors
     * This replaces dynamic PHP color files with static CSS
     */
    private function generateStaticCSS($theme)
    {
        try {
            // Ensure target directories exist
            $paths = [
                public_path('assets/admin/css'),
                public_path('assets/templates/basic/css'),
            ];
            
            foreach ($paths as $path) {
                File::ensureDirectoryExists($path);
            }
            
            // 1. Generate Admin CSS
            $this->generateAdminCSS($theme);
            \Log::info('Admin CSS generated successfully', ['path' => 'public/assets/admin/css/theme-colors.css']);
            
            // 2. Generate User/Frontend CSS
            $this->generateUserCSS($theme);
            \Log::info('User CSS generated successfully', ['path' => 'public/assets/templates/basic/css/theme-colors.css']);
            
            // 3. Generate Frontend Public CSS
            $this->generateFrontendCSS($theme);
            \Log::info('Frontend CSS generated successfully', ['path' => 'public/assets/templates/basic/css/frontend-colors.css']);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Error generating static CSS: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generate Admin Dashboard CSS
     */
    private function generateAdminCSS($theme)
    {
        $adminColors = $theme->getAdminColors();
        $primaryColor = $adminColors['primary'] ?? '#29B6F6';
        $secondaryColor = $adminColors['secondary'] ?? '#004AAD';
        $accentColor = $adminColors['accent'] ?? '#FF6600';
        $sidebarBg = $adminColors['sidebar_bg'] ?? '#1a1d29';
        $sidebarText = $adminColors['sidebar_text'] ?? '#ffffff';
        
        // Calculate variations
        $primaryLight = $this->adjustBrightness($primaryColor, 40);
        $primaryDark = $this->adjustBrightness($primaryColor, -40);
        $primaryRgb = $this->hexToRgb($primaryColor);
        $secondaryRgb = $this->hexToRgb($secondaryColor);
        $accentRgb = $this->hexToRgb($accentColor);
        
        $css = <<<CSS
/* ============================================================================
   ADMIN DASHBOARD COLORS - Auto-generated from theme_settings
   Generated at: {$this->getCurrentTimestamp()}
   ============================================================================ */

:root {
    /* Admin Primary Colors */
    --primary-color: {$primaryColor};
    --primary-color-rgb: {$primaryRgb};
    --primary-light: {$primaryLight};
    --primary-dark: {$primaryDark};
    --base-color: {$primaryColor};
    
    /* Admin Secondary Colors */
    --secondary-color: {$secondaryColor};
    --secondary-color-rgb: {$secondaryRgb};
    
    /* Admin Accent Colors */
    --accent-color: {$accentColor};
    --accent-color-rgb: {$accentRgb};
    
    /* Admin Sidebar Colors */
    --sidebar-bg: {$sidebarBg};
    --sidebar-text: {$sidebarText};
}

/* Primary color applications */
.btn-primary,
.bg-primary,
.badge-primary {
    background-color: {$primaryColor} !important;
    border-color: {$primaryColor} !important;
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: {$primaryDark} !important;
    border-color: {$primaryDark} !important;
}

.text-primary {
    color: {$primaryColor} !important;
}

.border-primary {
    border-color: {$primaryColor} !important;
}

/* Links */
a {
    color: {$primaryColor};
}

a:hover {
    color: {$primaryDark};
}

/* Custom elements */
.custom-primary {
    color: {$primaryColor};
}

.custom-primary-bg {
    background-color: {$primaryColor};
}

/* Form controls focus */
.form-control:focus {
    border-color: {$primaryColor};
    box-shadow: 0 0 0 0.2rem rgba({$primaryRgb}, 0.25);
}

/* Sidebar Styling */
.sidebar,
.navbar-wrapper__left,
.sidebar-menu {
    background-color: {$sidebarBg} !important;
}

.sidebar .menu-item,
.sidebar .menu-link,
.sidebar-menu li a {
    color: {$sidebarText} !important;
}

.sidebar .menu-item.active,
.sidebar .menu-item:hover {
    background-color: {$primaryColor};
    color: #ffffff !important;
}

.sidebar .menu-item.active .menu-link,
.sidebar .menu-item:hover .menu-link {
    color: #ffffff !important;
}

/* Secondary Color Applications */
.btn-secondary,
.bg-secondary,
.badge-secondary {
    background-color: {$secondaryColor} !important;
    border-color: {$secondaryColor} !important;
}

/* Accent Color Applications */
.btn-accent,
.bg-accent,
.badge-accent,
.text-accent {
    background-color: {$accentColor} !important;
    color: #ffffff !important;
}

/* Pagination */
.pagination .page-item.active .page-link {
    background-color: {$primaryColor};
    border-color: {$primaryColor};
}

/* Progress bars */
.progress-bar {
    background-color: {$primaryColor};
}

/* Generated at: {$this->getCurrentTimestamp()} */
CSS;
        
        // Save to file with error checking
        $path = public_path('assets/admin/css/theme-colors.css');
        File::ensureDirectoryExists(dirname($path));
        
        $result = file_put_contents($path, $css);
        if ($result === false) {
            throw new \RuntimeException("Failed to write admin CSS file: {$path}");
        }
    }
    
    /**
     * Generate User Dashboard CSS
     */
    private function generateUserCSS($theme)
    {
        $userColors = $theme->getUserColors();
        $globalColors = $theme->getGlobalColors();
        
        $color = $userColors['primary'] ?? '#29B6F6';
        $secondaryColor = $userColors['secondary'] ?? '#004AAD';
        $accentColor = $userColors['accent'] ?? '#FF6600';
        $sidebarBg = $userColors['sidebar_bg'] ?? '#f8f9fa';
        $sidebarText = $userColors['sidebar_text'] ?? '#212529';
        
        $successColor = $globalColors['success'] ?? '#28a745';
        $warningColor = $globalColors['warning'] ?? '#ffc107';
        $dangerColor = $globalColors['danger'] ?? '#dc3545';
        $infoColor = $globalColors['info'] ?? '#17a2b8';
        
        $primaryLight = $this->adjustBrightness($color, 40);
        $primaryDark = $this->adjustBrightness($color, -40);
        $hsl = $this->hexToHsl($color);
        
        $css = <<<CSS
/* ============================================================================
   USER DASHBOARD COLORS - Auto-generated from theme_settings
   Generated at: {$this->getCurrentTimestamp()}
   ============================================================================ */

:root {
    /* Cores Base (HSL) */
    --base-h: {$hsl['h']};
    --base-s: {$hsl['s']}%;
    --base-l: {$hsl['l']}%;

    /* Cores Primárias */
    --primary-color: {$color};
    --primary-light: {$primaryLight};
    --primary-dark: {$primaryDark};
    --secondary-color: {$secondaryColor};
    --accent-color: {$accentColor};

    /* Cores de Status */
    --success-color: {$successColor};
    --warning-color: {$warningColor};
    --danger-color: {$dangerColor};
    --info-color: {$infoColor};
    
    /* Sidebar do User Dashboard */
    --user-sidebar-bg: {$sidebarBg};
    --user-sidebar-text: {$sidebarText};

    /* Gradientes */
    --gradient-primary: linear-gradient(135deg, {$color} 0%, {$primaryDark} 100%);
    --gradient-secondary: linear-gradient(135deg, {$secondaryColor} 0%, {$primaryDark} 100%);
}

/* Aplicação das cores nos componentes */
.btn-primary,
.badge-primary,
.bg-primary {
    background-color: var(--primary-color) !important;
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: var(--primary-dark) !important;
}

.text-primary {
    color: var(--primary-color) !important;
}

.border-primary {
    border-color: var(--primary-color) !important;
}

.btn-secondary,
.badge-secondary,
.bg-secondary {
    background-color: var(--secondary-color) !important;
}

.text-secondary {
    color: var(--secondary-color) !important;
}

.btn-success,
.badge-success,
.bg-success {
    background-color: var(--success-color) !important;
}

.btn-warning,
.badge-warning,
.bg-warning {
    background-color: var(--warning-color) !important;
}

.btn-danger,
.badge-danger,
.bg-danger {
    background-color: var(--danger-color) !important;
}

.btn-info,
.badge-info,
.bg-info {
    background-color: var(--info-color) !important;
}

/* User Dashboard Sidebar */
.user-sidebar,
.user-menu,
.dashboard-sidebar {
    background-color: var(--user-sidebar-bg) !important;
}

.user-sidebar .menu-item,
.user-sidebar .menu-link,
.user-menu li a {
    color: var(--user-sidebar-text) !important;
}

.user-sidebar .menu-item.active,
.user-sidebar .menu-item:hover {
    background-color: var(--primary-color) !important;
    color: #ffffff !important;
}

/* Accent Color Applications */
.btn-accent,
.bg-accent,
.badge-accent {
    background-color: var(--accent-color) !important;
    color: #ffffff !important;
}

/* Generated at: {$this->getCurrentTimestamp()} */
CSS;
        
        $path = public_path('assets/templates/basic/css/theme-colors.css');
        File::ensureDirectoryExists(dirname($path));
        
        $result = file_put_contents($path, $css);
        if ($result === false) {
            throw new \RuntimeException("Failed to write user CSS file: {$path}");
        }
    }
    
    /**
     * Generate Frontend Public CSS
     */
    private function generateFrontendCSS($theme)
    {
        $frontendColors = $theme->getFrontendColors();
        
        $css = <<<CSS
/* ============================================================================
   FRONTEND PUBLIC COLORS - Auto-generated from theme_settings
   Generated at: {$this->getCurrentTimestamp()}
   ============================================================================ */

:root {
    /* Botões */
    --frontend-btn-primary: {$frontendColors['buttons']['primary']};
    --frontend-btn-primary-hover: {$frontendColors['buttons']['primary_hover']};
    --frontend-btn-secondary: {$frontendColors['buttons']['secondary']};
    --frontend-btn-secondary-hover: {$frontendColors['buttons']['secondary_hover']};
    --frontend-btn-text: {$frontendColors['buttons']['text']};
    
    /* Header/Navbar */
    --frontend-header-bg: {$frontendColors['header']['bg']};
    --frontend-header-text: {$frontendColors['header']['text']};
    --frontend-header-link: {$frontendColors['header']['link']};
    --frontend-header-link-hover: {$frontendColors['header']['link_hover']};
    
    /* Footer */
    --frontend-footer-bg: {$frontendColors['footer']['bg']};
    --frontend-footer-text: {$frontendColors['footer']['text']};
    --frontend-footer-link: {$frontendColors['footer']['link']};
    --frontend-footer-link-hover: {$frontendColors['footer']['link_hover']};
    
    /* Background & Gradient */
    --frontend-bg-color: {$frontendColors['background']['color']};
    --frontend-bg-gradient-start: {$frontendColors['background']['gradient_start']};
    --frontend-bg-gradient-end: {$frontendColors['background']['gradient_end']};
    
    /* Cards/Sections */
    --frontend-card-bg: {$frontendColors['cards']['bg']};
    --frontend-card-border: {$frontendColors['cards']['border']};
    --frontend-card-shadow: {$frontendColors['cards']['shadow']};
    
    /* Text */
    --frontend-text-primary: {$frontendColors['text']['primary']};
    --frontend-text-secondary: {$frontendColors['text']['secondary']};
    --frontend-heading-color: {$frontendColors['text']['heading']};
    
    /* Links */
    --frontend-link-color: {$frontendColors['links']['color']};
    --frontend-link-hover: {$frontendColors['links']['hover']};
    
    /* Modals */
    --frontend-modal-bg: {$frontendColors['modal']['bg']};
    --frontend-modal-header-bg: {$frontendColors['modal']['header_bg']};
    --frontend-modal-header-text: {$frontendColors['modal']['header_text']};
    --frontend-modal-overlay: {$frontendColors['modal']['overlay']};
    
    /* Borders */
    --frontend-border-color: {$frontendColors['borders']['color']};
    --frontend-border-radius: {$frontendColors['borders']['radius']}px;
    
    /* Hero Section */
    --frontend-hero-bg: {$frontendColors['hero']['bg']};
    --frontend-hero-text: {$frontendColors['hero']['text']};
    --frontend-hero-overlay: {$frontendColors['hero']['overlay']};
    
    /* Features */
    --frontend-feature-bg: {$frontendColors['features']['bg']};
    --frontend-feature-icon: {$frontendColors['features']['icon']};
    --frontend-feature-border: {$frontendColors['features']['border']};
}

/* ========== APLICAÇÃO DAS CORES NO FRONTEND ========== */

/* Background do Site */
body.frontend,
main.frontend {
    background-color: var(--frontend-bg-color);
}

/* Gradiente de Fundo (se ativado) */
body.frontend.use-gradient {
    background: linear-gradient(135deg, var(--frontend-bg-gradient-start) 0%, var(--frontend-bg-gradient-end) 100%);
}

/* Botões Primários */
.btn-primary,
.frontend .btn-primary {
    background-color: var(--frontend-btn-primary) !important;
    border-color: var(--frontend-btn-primary) !important;
    color: var(--frontend-btn-text) !important;
}

.btn-primary:hover,
.frontend .btn-primary:hover {
    background-color: var(--frontend-btn-primary-hover) !important;
    border-color: var(--frontend-btn-primary-hover) !important;
}

/* Botões Secundários */
.btn-secondary,
.frontend .btn-secondary {
    background-color: var(--frontend-btn-secondary) !important;
    border-color: var(--frontend-btn-secondary) !important;
    color: #ffffff !important;
}

.btn-secondary:hover,
.frontend .btn-secondary:hover {
    background-color: var(--frontend-btn-secondary-hover) !important;
    border-color: var(--frontend-btn-secondary-hover) !important;
}

/* Header/Navbar */
.header,
.navbar,
.top-header {
    background-color: var(--frontend-header-bg) !important;
    color: var(--frontend-header-text) !important;
}

.header a,
.navbar a,
.navbar-nav .nav-link {
    color: var(--frontend-header-link) !important;
}

.header a:hover,
.navbar a:hover,
.navbar-nav .nav-link:hover {
    color: var(--frontend-header-link-hover) !important;
}

/* Footer */
.footer,
footer {
    background-color: var(--frontend-footer-bg) !important;
    color: var(--frontend-footer-text) !important;
}

.footer a,
footer a {
    color: var(--frontend-footer-link) !important;
}

.footer a:hover,
footer a:hover {
    color: var(--frontend-footer-link-hover) !important;
}

/* Cards */
.card,
.frontend .card {
    background-color: var(--frontend-card-bg) !important;
    border-color: var(--frontend-card-border) !important;
    box-shadow: 0 4px 8px var(--frontend-card-shadow);
    border-radius: var(--frontend-border-radius);
}

/* Hero Section */
.hero-section,
.banner-section,
.hero {
    background-color: var(--frontend-hero-bg) !important;
    color: var(--frontend-hero-text) !important;
}

/* Features/Services */
.feature-item,
.service-item,
.features .card {
    background-color: var(--frontend-feature-bg) !important;
    border-color: var(--frontend-feature-border) !important;
}

.feature-item .icon,
.service-item .icon,
.feature-icon {
    color: var(--frontend-feature-icon) !important;
}

/* Generated at: {$this->getCurrentTimestamp()} */
CSS;
        
        $path = public_path('assets/templates/basic/css/frontend-colors.css');
        File::ensureDirectoryExists(dirname($path));
        
        $result = file_put_contents($path, $css);
        if ($result === false) {
            throw new \RuntimeException("Failed to write frontend CSS file: {$path}");
        }
    }
    
    /**
     * Helper: Adjust color brightness
     */
    private function adjustBrightness($hex, $steps)
    {
        $hex = ltrim($hex, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));
        
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
    
    /**
     * Helper: Convert hex to RGB string
     */
    private function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return "$r, $g, $b";
    }
    
    /**
     * Helper: Convert hex to HSL
     */
    private function hexToHsl($hex)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2)) / 255;
        $g = hexdec(substr($hex, 2, 2)) / 255;
        $b = hexdec(substr($hex, 4, 2)) / 255;
        
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $l = ($max + $min) / 2;
        
        if ($max == $min) {
            $h = $s = 0;
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
            
            switch ($max) {
                case $r:
                    $h = (($g - $b) / $d + ($g < $b ? 6 : 0)) / 6;
                    break;
                case $g:
                    $h = (($b - $r) / $d + 2) / 6;
                    break;
                case $b:
                    $h = (($r - $g) / $d + 4) / 6;
                    break;
            }
        }
        
        return [
            'h' => round($h * 360),
            's' => round($s * 100),
            'l' => round($l * 100),
        ];
    }
    
    /**
     * Get current timestamp
     */
    private function getCurrentTimestamp()
    {
        return date('Y-m-d H:i:s');
    }
}
