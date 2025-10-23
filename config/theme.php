<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações de Tema e Branding
    |--------------------------------------------------------------------------
    |
    | Este arquivo permite personalizar completamente a identidade visual
    | da plataforma InteligenciaMax, incluindo cores, logotipos e tipografia.
    |
    */

    // Cores primárias do sistema
    'primary_color' => env('APP_PRIMARY_COLOR', '#29B6F6'),
    'secondary_color' => env('APP_SECONDARY_COLOR', '#004AAD'),
    'accent_color' => env('APP_ACCENT_COLOR', '#FF6600'),
    
    // Cores de suporte
    'success_color' => env('APP_SUCCESS_COLOR', '#28a745'),
    'warning_color' => env('APP_WARNING_COLOR', '#ffc107'),
    'danger_color' => env('APP_DANGER_COLOR', '#dc3545'),
    'info_color' => env('APP_INFO_COLOR', '#17a2b8'),
    
    // Gradientes
    'gradient_start' => env('APP_GRADIENT_START', '#29B6F6'),
    'gradient_end' => env('APP_GRADIENT_END', '#039BE5'),
    
    // Logotipos
    'logo_light' => env('APP_LOGO_LIGHT', 'assets/images/logo_icon/logo.png'),
    'logo_dark' => env('APP_LOGO_DARK', 'assets/images/logo_icon/logo_dark.png'),
    'logo_icon' => env('APP_LOGO_ICON', 'assets/images/logo_icon/favicon.png'),
    'favicon' => env('APP_FAVICON', 'assets/images/logo_icon/favicon.png'),
    
    // Dimensões de logo
    'logo_height' => env('APP_LOGO_HEIGHT', '50px'),
    'logo_width' => env('APP_LOGO_WIDTH', 'auto'),
    
    // Tipografia - JOST
    'font_family_primary' => env('APP_FONT_PRIMARY', '"Jost", sans-serif'),
    'font_family_secondary' => env('APP_FONT_SECONDARY', '"Jost", sans-serif'),
    'font_family_heading' => env('APP_FONT_HEADING', '"Jost", sans-serif'),
    
    // Tamanhos de fonte base
    'font_size_base' => env('APP_FONT_SIZE', '14px'),
    'font_size_heading' => env('APP_FONT_SIZE_HEADING', '24px'),
    
    // Bordas e raios
    'border_radius' => env('APP_BORDER_RADIUS', '8px'),
    'border_radius_large' => env('APP_BORDER_RADIUS_LARGE', '16px'),
    
    // Sombras
    'box_shadow' => env('APP_BOX_SHADOW', '0 2px 8px rgba(0,0,0,0.1)'),
    'box_shadow_hover' => env('APP_BOX_SHADOW_HOVER', '0 4px 16px rgba(0,0,0,0.15)'),
    
    // Espaçamentos
    'spacing_unit' => env('APP_SPACING_UNIT', '8px'),
    
    // Layout
    'sidebar_width' => env('APP_SIDEBAR_WIDTH', '260px'),
    'topbar_height' => env('APP_TOPBAR_HEIGHT', '70px'),
    
    // Modo escuro
    'dark_mode_enabled' => env('APP_DARK_MODE_ENABLED', true),
    'dark_primary_color' => env('APP_DARK_PRIMARY_COLOR', '#1a1a1a'),
    'dark_secondary_color' => env('APP_DARK_SECONDARY_COLOR', '#2d2d2d'),
    
    // Animações
    'animation_duration' => env('APP_ANIMATION_DURATION', '0.3s'),
    'animation_easing' => env('APP_ANIMATION_EASING', 'ease-in-out'),
];
