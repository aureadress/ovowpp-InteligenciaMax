-- ================================================================================
-- 🚀 EXECUTAR ESTE SCRIPT NO RAILWAY MYSQL - URGENTE
-- ================================================================================
-- Este script reverte a cor base para VERDE original (#25d466)
-- A dashboard usará verde, landing page e login usarão azul via CSS
-- ================================================================================

-- 1. Verificar cor atual
SELECT 
    id,
    site_name,
    CONCAT('#', base_color) as cor_antes,
    'Esta cor será alterada para #25d466 (VERDE)' as acao
FROM general_settings 
WHERE id = 1;

-- 2. Atualizar para VERDE (cor original da dashboard)
UPDATE general_settings 
SET base_color = '25d466' 
WHERE id = 1;

-- 3. Verificar se a alteração foi aplicada
SELECT 
    id,
    site_name,
    CONCAT('#', base_color) as cor_depois,
    CASE 
        WHEN base_color = '25d466' THEN '✅ CORRETO - Dashboard agora está VERDE'
        ELSE '❌ ERRO - Cor não foi alterada'
    END as status
FROM general_settings 
WHERE id = 1;

-- ================================================================================
-- 📋 RESULTADO ESPERADO:
-- - Dashboard (user/dashboard): VERDE #25d466 ✅
-- - Landing page (/): AZUL #29B6F6 (via CSS) ✅
-- - Login (/user/login): AZUL #29B6F6 (via CSS) ✅
-- ================================================================================
