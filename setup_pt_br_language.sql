-- Script para configurar Português Brasil como idioma padrão
-- Execute este script no seu banco de dados MySQL

-- 1. Verificar idiomas existentes
SELECT * FROM languages;

-- 2. Inserir Português Brasil (se não existir)
INSERT INTO languages (name, code, info, image, is_default, created_at, updated_at) 
SELECT 'Português Brasil', 'pt', 'Idioma oficial do Brasil, celebrada por sua riqueza cultural e herança', 'pt_flag.png', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM languages WHERE code = 'pt');

-- 3. Desativar outros idiomas como padrão
UPDATE languages SET is_default = 0 WHERE code != 'pt';

-- 4. Garantir que PT-BR seja o padrão
UPDATE languages SET is_default = 1 WHERE code = 'pt';

-- 5. Verificar resultado final
SELECT id, name, code, is_default FROM languages ORDER BY is_default DESC;
