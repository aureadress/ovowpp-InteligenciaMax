<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        // Admin Dashboard
        'admin_primary_color',
        'admin_secondary_color',
        'admin_accent_color',
        'admin_sidebar_bg',
        'admin_sidebar_text',
        
        // User Dashboard
        'user_primary_color',
        'user_secondary_color',
        'user_accent_color',
        'user_sidebar_bg',
        'user_sidebar_text',
        
        // Chat/Inbox
        'chat_primary_color',
        'chat_secondary_color',
        'chat_bubble_sent',
        'chat_bubble_received',
        'chat_header_bg',
        
        // Global Colors
        'success_color',
        'warning_color',
        'danger_color',
        'info_color',
        
        // Frontend Buttons
        'frontend_btn_primary',
        'frontend_btn_primary_hover',
        'frontend_btn_secondary',
        'frontend_btn_secondary_hover',
        'frontend_btn_text',
        
        // Frontend Header/Navbar
        'frontend_header_bg',
        'frontend_header_text',
        'frontend_header_link',
        'frontend_header_link_hover',
        
        // Frontend Footer
        'frontend_footer_bg',
        'frontend_footer_text',
        'frontend_footer_link',
        'frontend_footer_link_hover',
        
        // Frontend Background
        'frontend_bg_color',
        'frontend_bg_gradient_start',
        'frontend_bg_gradient_end',
        'frontend_use_gradient',
        
        // Frontend Cards/Sections
        'frontend_card_bg',
        'frontend_card_border',
        'frontend_card_shadow',
        
        // Frontend Text
        'frontend_text_primary',
        'frontend_text_secondary',
        'frontend_heading_color',
        
        // Frontend Links
        'frontend_link_color',
        'frontend_link_hover',
        
        // Frontend Modals
        'frontend_modal_bg',
        'frontend_modal_header_bg',
        'frontend_modal_header_text',
        'frontend_modal_overlay',
        
        // Frontend Borders
        'frontend_border_color',
        'frontend_border_radius',
        
        // Frontend Hero Section
        'frontend_hero_bg',
        'frontend_hero_text',
        'frontend_hero_overlay',
        
        // Frontend Features
        'frontend_feature_bg',
        'frontend_feature_icon',
        'frontend_feature_border',
        
        // Metadata
        'is_active',
        'theme_name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'frontend_use_gradient' => 'boolean',
    ];

    /**
     * Get active theme settings
     */
    public static function active()
    {
        return self::where('is_active', true)->first() ?? self::first();
    }

    /**
     * Get color for specific area
     */
    public static function getColor($area, $type, $default = '#29B6F6')
    {
        $theme = self::active();
        if (!$theme) {
            return $default;
        }
        
        $field = "{$area}_{$type}_color";
        return $theme->$field ?? $default;
    }

    /**
     * Get all admin colors as array
     */
    public function getAdminColors()
    {
        return [
            'primary' => $this->admin_primary_color,
            'secondary' => $this->admin_secondary_color,
            'accent' => $this->admin_accent_color,
            'sidebar_bg' => $this->admin_sidebar_bg,
            'sidebar_text' => $this->admin_sidebar_text,
        ];
    }

    /**
     * Get all user colors as array
     */
    public function getUserColors()
    {
        return [
            'primary' => $this->user_primary_color,
            'secondary' => $this->user_secondary_color,
            'accent' => $this->user_accent_color,
            'sidebar_bg' => $this->user_sidebar_bg,
            'sidebar_text' => $this->user_sidebar_text,
        ];
    }

    /**
     * Get all chat colors as array
     */
    public function getChatColors()
    {
        return [
            'primary' => $this->chat_primary_color,
            'secondary' => $this->chat_secondary_color,
            'bubble_sent' => $this->chat_bubble_sent,
            'bubble_received' => $this->chat_bubble_received,
            'header_bg' => $this->chat_header_bg,
        ];
    }

    /**
     * Get all global colors as array
     */
    public function getGlobalColors()
    {
        return [
            'success' => $this->success_color,
            'warning' => $this->warning_color,
            'danger' => $this->danger_color,
            'info' => $this->info_color,
        ];
    }

    /**
     * Get all frontend colors as array
     */
    public function getFrontendColors()
    {
        return [
            'buttons' => [
                'primary' => $this->frontend_btn_primary,
                'primary_hover' => $this->frontend_btn_primary_hover,
                'secondary' => $this->frontend_btn_secondary,
                'secondary_hover' => $this->frontend_btn_secondary_hover,
                'text' => $this->frontend_btn_text,
            ],
            'header' => [
                'bg' => $this->frontend_header_bg,
                'text' => $this->frontend_header_text,
                'link' => $this->frontend_header_link,
                'link_hover' => $this->frontend_header_link_hover,
            ],
            'footer' => [
                'bg' => $this->frontend_footer_bg,
                'text' => $this->frontend_footer_text,
                'link' => $this->frontend_footer_link,
                'link_hover' => $this->frontend_footer_link_hover,
            ],
            'background' => [
                'color' => $this->frontend_bg_color,
                'gradient_start' => $this->frontend_bg_gradient_start,
                'gradient_end' => $this->frontend_bg_gradient_end,
                'use_gradient' => $this->frontend_use_gradient,
            ],
            'cards' => [
                'bg' => $this->frontend_card_bg,
                'border' => $this->frontend_card_border,
                'shadow' => $this->frontend_card_shadow,
            ],
            'text' => [
                'primary' => $this->frontend_text_primary,
                'secondary' => $this->frontend_text_secondary,
                'heading' => $this->frontend_heading_color,
            ],
            'links' => [
                'color' => $this->frontend_link_color,
                'hover' => $this->frontend_link_hover,
            ],
            'modal' => [
                'bg' => $this->frontend_modal_bg,
                'header_bg' => $this->frontend_modal_header_bg,
                'header_text' => $this->frontend_modal_header_text,
                'overlay' => $this->frontend_modal_overlay,
            ],
            'borders' => [
                'color' => $this->frontend_border_color,
                'radius' => $this->frontend_border_radius,
            ],
            'hero' => [
                'bg' => $this->frontend_hero_bg,
                'text' => $this->frontend_hero_text,
                'overlay' => $this->frontend_hero_overlay,
            ],
            'features' => [
                'bg' => $this->frontend_feature_bg,
                'icon' => $this->frontend_feature_icon,
                'border' => $this->frontend_feature_border,
            ],
        ];
    }
}
