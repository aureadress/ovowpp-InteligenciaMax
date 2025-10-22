-- ================================================
-- 🔍 VERIFICAR CONFIGURAÇÕES ATUAIS
-- ================================================

-- Ver idioma padrão atual
SELECT 
    id,
    name as 'Nome do Idioma',
    code as 'Código',
    is_default as 'É Padrão? (1=Sim, 0=Não)',
    CASE 
        WHEN is_default = 1 THEN '✅ ATIVO'
        ELSE '⚪ Inativo'
    END as 'Status'
FROM languages
ORDER BY is_default DESC, name ASC;

-- Ver cor atual
SELECT 
    id,
    site_name as 'Nome do Site',
    base_color as 'Código da Cor (sem #)',
    CONCAT('#', base_color) as 'Cor Completa'
FROM general_settings
WHERE id = 1;
