<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            // Admin colors
            'admin_primary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_secondary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_accent_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_sidebar_bg' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_sidebar_text' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            
            // User colors
            'user_primary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'user_secondary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'user_accent_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'user_sidebar_bg' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'user_sidebar_text' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            
            // Chat colors
            'chat_primary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'chat_secondary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'chat_bubble_sent' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'chat_bubble_received' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'chat_header_bg' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            
            // Global colors
            'success_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'warning_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'danger_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'info_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'regex' => 'O campo :attribute deve ser uma cor hexadecimal válida (ex: #29B6F6)',
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

        // Update all colors
        $theme->fill($request->only([
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
        ]));

        $theme->save();

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
}
