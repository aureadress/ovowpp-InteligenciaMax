-- ================================================
-- 🤖 SCRIPT COMPLETO - CORES DO ROBÔ AZUL
-- ================================================
-- Execute este script no Railway MySQL Query
-- ================================================

-- PASSO 1: Aplicar cor base do robô (azul ciano)
UPDATE general_settings 
SET base_color = '29B6F6' 
WHERE id = 1;

-- PASSO 2: Ativar Português Brasil
UPDATE languages SET is_default = 0;
UPDATE languages SET is_default = 1 WHERE code = 'pt';

-- PASSO 3: Verificar aplicação
SELECT 
    '✅ CONFIGURAÇÃO APLICADA!' as Status,
    '' as Separador;

SELECT 
    '🎨 COR' as Tipo,
    site_name as 'Site',
    CONCAT('#', base_color) as 'Cor Aplicada',
    '🤖 Azul Ciano do Robô' as 'Descrição'
FROM general_settings 
WHERE id = 1;

SELECT 
    '🌍 IDIOMA' as Tipo,
    name as 'Idioma Ativo',
    code as 'Código',
    '🇧🇷 Português Brasil' as 'Descrição'
FROM languages 
WHERE is_default = 1;

-- ================================================
-- ✅ FIM DO SCRIPT
-- ================================================
-- PRÓXIMOS PASSOS:
-- 1. Faça logout da plataforma
-- 2. Limpe o cache do navegador (Ctrl+Shift+Del)
-- 3. Faça login novamente
-- 4. A plataforma estará com as cores do robô! 🤖💙
-- ================================================
