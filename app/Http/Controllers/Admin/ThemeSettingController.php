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
