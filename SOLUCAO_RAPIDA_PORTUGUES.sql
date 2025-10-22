-- ============================================================
-- 🇧🇷 SCRIPT PARA ATIVAR PORTUGUÊS BRASIL - MÉTODO DIRETO
-- ============================================================
-- Execute este script no Railway MySQL Query
-- 
-- PASSO A PASSO:
-- 1. Acesse Railway Dashboard
-- 2. Clique no serviço MySQL
-- 3. Vá na aba "Query" ou "Data"
-- 4. Cole TODO este script
-- 5. Clique em "Execute" ou "Run"
-- ============================================================

-- PASSO 1: Verificar idiomas existentes
SELECT 'PASSO 1: Idiomas existentes antes da alteração' AS Acao;
SELECT id, name, code, is_default FROM languages;

-- PASSO 2: Remover idioma PT se já existir (para evitar duplicação)
SELECT 'PASSO 2: Removendo idioma PT antigo (se existir)' AS Acao;
DELETE FROM languages WHERE code = 'pt';

-- PASSO 3: Inserir Português Brasil como novo idioma
SELECT 'PASSO 3: Inserindo Português Brasil' AS Acao;
INSERT INTO languages (
    name, 
    code, 
    info, 
    image, 
    is_default, 
    created_at, 
    updated_at
) VALUES (
    'Português Brasil',
    'pt',
    'Idioma oficial do Brasil, falada por milhões de usuários. Língua rica em cultura e expressão.',
    'pt.png',
    1,
    NOW(),
    NOW()
);

-- PASSO 4: Desativar TODOS os outros idiomas
SELECT 'PASSO 4: Desativando outros idiomas' AS Acao;
UPDATE languages SET is_default = 0 WHERE code != 'pt';

-- PASSO 5: Garantir que PT seja o único padrão
SELECT 'PASSO 5: Ativando Português Brasil como padrão' AS Acao;
UPDATE languages SET is_default = 1 WHERE code = 'pt';

-- PASSO 6: Verificar resultado final
SELECT 'PASSO 6: RESULTADO FINAL - Idiomas após alteração' AS Acao;
SELECT 
    id, 
    name, 
    code, 
    is_default,
    CASE 
        WHEN is_default = 1 THEN '✅ ATIVO (PADRÃO)'
        ELSE '⚪ Inativo'
    END AS Status
FROM languages 
ORDER BY is_default DESC, name ASC;

-- PASSO 7: Confirmar que apenas PT está ativo
SELECT 'PASSO 7: CONFIRMAÇÃO - Apenas 1 idioma deve estar ativo' AS Acao;
SELECT 
    COUNT(*) as Total_Idiomas,
    SUM(is_default) as Idiomas_Ativos,
    CASE 
        WHEN SUM(is_default) = 1 THEN '✅ CONFIGURAÇÃO CORRETA!'
        ELSE '❌ ERRO: Mais de um idioma está ativo'
    END AS Verificacao
FROM languages;

-- ============================================================
-- ✅ FIM DO SCRIPT
-- ============================================================
-- Após executar, faça:
-- 1. Logout da plataforma
-- 2. Limpe o cache do navegador (Ctrl+Shift+Del)
-- 3. Faça login novamente
-- 4. A plataforma estará em PORTUGUÊS BRASIL! 🇧🇷
-- ============================================================
