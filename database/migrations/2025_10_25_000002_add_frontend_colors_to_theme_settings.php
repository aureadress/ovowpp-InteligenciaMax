<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            // Cores de Botões
            $table->string('frontend_btn_primary', 7)->default('#29B6F6')->after('info_color')->comment('Cor do botão primário');
            $table->string('frontend_btn_primary_hover', 7)->default('#0288D1')->after('frontend_btn_primary')->comment('Cor do botão primário ao passar mouse');
            $table->string('frontend_btn_secondary', 7)->default('#6c757d')->after('frontend_btn_primary_hover')->comment('Cor do botão secundário');
            $table->string('frontend_btn_secondary_hover', 7)->default('#5a6268')->after('frontend_btn_secondary')->comment('Cor do botão secundário ao passar mouse');
            $table->string('frontend_btn_text', 7)->default('#ffffff')->after('frontend_btn_secondary_hover')->comment('Cor do texto dos botões');
            
            // Cores de Header/Navbar
            $table->string('frontend_header_bg', 7)->default('#ffffff')->after('frontend_btn_text')->comment('Cor de fundo do header');
            $table->string('frontend_header_text', 7)->default('#212529')->after('frontend_header_bg')->comment('Cor do texto do header');
            $table->string('frontend_header_link', 7)->default('#29B6F6')->after('frontend_header_text')->comment('Cor dos links do header');
            $table->string('frontend_header_link_hover', 7)->default('#0288D1')->after('frontend_header_link')->comment('Cor dos links do header ao passar mouse');
            
            // Cores de Footer
            $table->string('frontend_footer_bg', 7)->default('#212529')->after('frontend_header_link_hover')->comment('Cor de fundo do footer');
            $table->string('frontend_footer_text', 7)->default('#ffffff')->after('frontend_footer_bg')->comment('Cor do texto do footer');
            $table->string('frontend_footer_link', 7)->default('#29B6F6')->after('frontend_footer_text')->comment('Cor dos links do footer');
            $table->string('frontend_footer_link_hover', 7)->default('#0288D1')->after('frontend_footer_link')->comment('Cor dos links do footer ao passar mouse');
            
            // Cores de Background
            $table->string('frontend_bg_color', 7)->default('#ffffff')->after('frontend_footer_link_hover')->comment('Cor de fundo principal');
            $table->string('frontend_bg_gradient_start', 7)->default('#29B6F6')->after('frontend_bg_color')->comment('Cor inicial do gradiente de fundo');
            $table->string('frontend_bg_gradient_end', 7)->default('#0288D1')->after('frontend_bg_gradient_start')->comment('Cor final do gradiente de fundo');
            $table->boolean('frontend_use_gradient')->default(false)->after('frontend_bg_gradient_end')->comment('Usar gradiente no fundo');
            
            // Cores de Seções/Cards
            $table->string('frontend_card_bg', 7)->default('#ffffff')->after('frontend_use_gradient')->comment('Cor de fundo dos cards');
            $table->string('frontend_card_border', 7)->default('#dee2e6')->after('frontend_card_bg')->comment('Cor da borda dos cards');
            $table->string('frontend_card_shadow', 7)->default('#00000020')->after('frontend_card_border')->comment('Cor da sombra dos cards (com transparência)');
            
            // Cores de Texto
            $table->string('frontend_text_primary', 7)->default('#212529')->after('frontend_card_shadow')->comment('Cor do texto principal');
            $table->string('frontend_text_secondary', 7)->default('#6c757d')->after('frontend_text_primary')->comment('Cor do texto secundário');
            $table->string('frontend_heading_color', 7)->default('#212529')->after('frontend_text_secondary')->comment('Cor dos títulos (h1, h2, h3)');
            
            // Cores de Links
            $table->string('frontend_link_color', 7)->default('#29B6F6')->after('frontend_heading_color')->comment('Cor dos links');
            $table->string('frontend_link_hover', 7)->default('#0288D1')->after('frontend_link_color')->comment('Cor dos links ao passar mouse');
            
            // Cores de Modais
            $table->string('frontend_modal_bg', 7)->default('#ffffff')->after('frontend_link_hover')->comment('Cor de fundo dos modais');
            $table->string('frontend_modal_header_bg', 7)->default('#29B6F6')->after('frontend_modal_bg')->comment('Cor de fundo do cabeçalho do modal');
            $table->string('frontend_modal_header_text', 7)->default('#ffffff')->after('frontend_modal_header_bg')->comment('Cor do texto do cabeçalho do modal');
            $table->string('frontend_modal_overlay', 7)->default('#00000080')->after('frontend_modal_header_text')->comment('Cor do overlay do modal (com transparência)');
            
            // Cores de Bordas
            $table->string('frontend_border_color', 7)->default('#dee2e6')->after('frontend_modal_overlay')->comment('Cor de bordas gerais');
            $table->string('frontend_border_radius', 3)->default('8')->after('frontend_border_color')->comment('Raio de borda em pixels (0-99)');
            
            // Cores de Seção Hero (Banner principal)
            $table->string('frontend_hero_bg', 7)->default('#29B6F6')->after('frontend_border_radius')->comment('Cor de fundo da seção hero');
            $table->string('frontend_hero_text', 7)->default('#ffffff')->after('frontend_hero_bg')->comment('Cor do texto da seção hero');
            $table->string('frontend_hero_overlay', 7)->default('#00000040')->after('frontend_hero_text')->comment('Cor do overlay da seção hero');
            
            // Cores de Features/Destaques
            $table->string('frontend_feature_bg', 7)->default('#f8f9fa')->after('frontend_hero_overlay')->comment('Cor de fundo das features');
            $table->string('frontend_feature_icon', 7)->default('#29B6F6')->after('frontend_feature_bg')->comment('Cor dos ícones das features');
            $table->string('frontend_feature_border', 7)->default('#dee2e6')->after('frontend_feature_icon')->comment('Cor da borda das features');
        });
        
        // Atualizar registro existente com valores padrão
        DB::table('theme_settings')->update([
            'frontend_btn_primary' => '#29B6F6',
            'frontend_btn_primary_hover' => '#0288D1',
            'frontend_btn_secondary' => '#6c757d',
            'frontend_btn_secondary_hover' => '#5a6268',
            'frontend_btn_text' => '#ffffff',
            
            'frontend_header_bg' => '#ffffff',
            'frontend_header_text' => '#212529',
            'frontend_header_link' => '#29B6F6',
            'frontend_header_link_hover' => '#0288D1',
            
            'frontend_footer_bg' => '#212529',
            'frontend_footer_text' => '#ffffff',
            'frontend_footer_link' => '#29B6F6',
            'frontend_footer_link_hover' => '#0288D1',
            
            'frontend_bg_color' => '#ffffff',
            'frontend_bg_gradient_start' => '#29B6F6',
            'frontend_bg_gradient_end' => '#0288D1',
            'frontend_use_gradient' => false,
            
            'frontend_card_bg' => '#ffffff',
            'frontend_card_border' => '#dee2e6',
            'frontend_card_shadow' => '#00000020',
            
            'frontend_text_primary' => '#212529',
            'frontend_text_secondary' => '#6c757d',
            'frontend_heading_color' => '#212529',
            
            'frontend_link_color' => '#29B6F6',
            'frontend_link_hover' => '#0288D1',
            
            'frontend_modal_bg' => '#ffffff',
            'frontend_modal_header_bg' => '#29B6F6',
            'frontend_modal_header_text' => '#ffffff',
            'frontend_modal_overlay' => '#00000080',
            
            'frontend_border_color' => '#dee2e6',
            'frontend_border_radius' => '8',
            
            'frontend_hero_bg' => '#29B6F6',
            'frontend_hero_text' => '#ffffff',
            'frontend_hero_overlay' => '#00000040',
            
            'frontend_feature_bg' => '#f8f9fa',
            'frontend_feature_icon' => '#29B6F6',
            'frontend_feature_border' => '#dee2e6',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->dropColumn([
                'frontend_btn_primary',
                'frontend_btn_primary_hover',
                'frontend_btn_secondary',
                'frontend_btn_secondary_hover',
                'frontend_btn_text',
                'frontend_header_bg',
                'frontend_header_text',
                'frontend_header_link',
                'frontend_header_link_hover',
                'frontend_footer_bg',
                'frontend_footer_text',
                'frontend_footer_link',
                'frontend_footer_link_hover',
                'frontend_bg_color',
                'frontend_bg_gradient_start',
                'frontend_bg_gradient_end',
                'frontend_use_gradient',
                'frontend_card_bg',
                'frontend_card_border',
                'frontend_card_shadow',
                'frontend_text_primary',
                'frontend_text_secondary',
                'frontend_heading_color',
                'frontend_link_color',
                'frontend_link_hover',
                'frontend_modal_bg',
                'frontend_modal_header_bg',
                'frontend_modal_header_text',
                'frontend_modal_overlay',
                'frontend_border_color',
                'frontend_border_radius',
                'frontend_hero_bg',
                'frontend_hero_text',
                'frontend_hero_overlay',
                'frontend_feature_bg',
                'frontend_feature_icon',
                'frontend_feature_border',
            ]);
        });
    }
};
