-- ================================================================================
-- REVERTER COR DA DASHBOARD PARA VERDE ORIGINAL
-- ================================================================================
-- Este script reverte a cor base para o verde original (#25d466)
-- A dashboard do usuário usará essas cores
-- As páginas de landing e login terão cores azuis aplicadas via CSS
-- ================================================================================

-- Atualizar cor base para VERDE ORIGINAL da OvoWpp
UPDATE general_settings SET base_color = '25d466' WHERE id = 1;

-- Verificar alteração
SELECT 
    id, 
    site_name, 
    CONCAT('#', base_color) as cor_atual,
    'Dashboard agora usará VERDE' as observacao
FROM general_settings 
WHERE id = 1;

-- IMPORTANTE:
-- - Dashboard do usuário: VERDE (#25d466) - cor original
-- - Landing page: AZUL (#29B6F6) - via CSS custom
-- - Login page: AZUL (#29B6F6) - via CSS custom
