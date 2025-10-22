-- ================================================
-- 🚀 CONFIGURAÇÃO COMPLETA - EXECUTE TUDO DE UMA VEZ
-- ================================================
-- Copie TODO este bloco e cole no Railway Query
-- ================================================

-- Resetar senha do admin para: admin
UPDATE admins 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    updated_at = NOW()
WHERE id = 1;

-- Ativar Português Brasil
UPDATE languages SET is_default = 0, updated_at = NOW();
UPDATE languages SET is_default = 1, updated_at = NOW() WHERE code = 'pt';

-- Aplicar cor do robô azul
UPDATE general_settings 
SET base_color = '29B6F6',
    updated_at = NOW()
WHERE id = 1;

-- ================================================
-- ✅ VERIFICAÇÃO
-- ================================================

SELECT '========================================' as '';
SELECT '✅ CONFIGURAÇÃO APLICADA!' as 'STATUS';
SELECT '========================================' as '';

SELECT 
    '🔐 ADMIN' as 'Configuração',
    username as 'Usuário',
    email as 'Email',
    'Senha: admin' as 'Nova Senha'
FROM admins WHERE id = 1;

SELECT 
    '🌍 IDIOMA' as 'Configuração',
    name as 'Nome',
    code as 'Código',
    CASE WHEN is_default = 1 THEN '✅ ATIVO' ELSE '⚪ Inativo' END as 'Status'
FROM languages 
ORDER BY is_default DESC
LIMIT 5;

SELECT 
    '🎨 COR' as 'Configuração',
    site_name as 'Site',
    CONCAT('#', base_color) as 'Cor',
    '🤖 Azul Robô' as 'Tema'
FROM general_settings WHERE id = 1;

SELECT '========================================' as '';
SELECT 'Acesse: https://inteligenciamax.com.br/admin' as 'PRÓXIMO PASSO';
SELECT 'Usuário: admin | Senha: admin' as 'CREDENCIAIS';
SELECT '========================================' as '';
