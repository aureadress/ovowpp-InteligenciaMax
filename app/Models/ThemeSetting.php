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
        
        // Metadata
        'is_active',
        'theme_name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
}
