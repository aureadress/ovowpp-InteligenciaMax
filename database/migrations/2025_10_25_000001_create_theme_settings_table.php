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
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            
            // Cores do Admin Dashboard
            $table->string('admin_primary_color', 7)->default('#29B6F6')->comment('Cor primária do painel admin');
            $table->string('admin_secondary_color', 7)->default('#004AAD')->comment('Cor secundária do painel admin');
            $table->string('admin_accent_color', 7)->default('#FF6600')->comment('Cor de destaque do painel admin');
            $table->string('admin_sidebar_bg', 7)->default('#1a1d29')->comment('Cor de fundo da sidebar admin');
            $table->string('admin_sidebar_text', 7)->default('#ffffff')->comment('Cor do texto da sidebar admin');
            
            // Cores do User Dashboard
            $table->string('user_primary_color', 7)->default('#00BCD4')->comment('Cor primária do dashboard user');
            $table->string('user_secondary_color', 7)->default('#0097A7')->comment('Cor secundária do dashboard user');
            $table->string('user_accent_color', 7)->default('#FF5722')->comment('Cor de destaque do dashboard user');
            $table->string('user_sidebar_bg', 7)->default('#263238')->comment('Cor de fundo da sidebar user');
            $table->string('user_sidebar_text', 7)->default('#ffffff')->comment('Cor do texto da sidebar user');
            
            // Cores do Chat/Inbox
            $table->string('chat_primary_color', 7)->default('#4CAF50')->comment('Cor primária do chat');
            $table->string('chat_secondary_color', 7)->default('#388E3C')->comment('Cor secundária do chat');
            $table->string('chat_bubble_sent', 7)->default('#DCF8C6')->comment('Cor das mensagens enviadas');
            $table->string('chat_bubble_received', 7)->default('#FFFFFF')->comment('Cor das mensagens recebidas');
            $table->string('chat_header_bg', 7)->default('#075E54')->comment('Cor do cabeçalho do chat');
            
            // Cores Globais (Status, Alertas, etc)
            $table->string('success_color', 7)->default('#28a745')->comment('Cor de sucesso');
            $table->string('warning_color', 7)->default('#ffc107')->comment('Cor de aviso');
            $table->string('danger_color', 7)->default('#dc3545')->comment('Cor de erro');
            $table->string('info_color', 7)->default('#17a2b8')->comment('Cor de informação');
            
            // Metadados
            $table->boolean('is_active')->default(true)->comment('Se o tema está ativo');
            $table->string('theme_name')->default('Default')->comment('Nome do esquema de cores');
            
            $table->timestamps();
        });
        
        // Inserir configuração padrão
        DB::table('theme_settings')->insert([
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
            
            'is_active' => true,
            'theme_name' => 'Default',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
