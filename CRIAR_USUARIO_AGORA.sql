-- ========================================
-- 🤖 CRIAR USUÁRIO DE TESTE - OvoWpp
-- ========================================
-- Execute este SQL no Railway MySQL!
-- ========================================

-- 1️⃣ DELETAR usuário se já existir (para evitar erro)
DELETE FROM users WHERE username = 'cliente' OR email = 'cliente@teste.com';

-- 2️⃣ CRIAR novo usuário
INSERT INTO users (
    username,
    email,
    password,
    firstname,
    lastname,
    country_code,
    mobile,
    status,
    ev,
    sv,
    ts,
    tv,
    created_at,
    updated_at
) VALUES (
    'cliente',                                                                      -- Usuário
    'cliente@teste.com',                                                           -- Email
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',              -- Senha: admin
    'Cliente',                                                                      -- Nome
    'Teste',                                                                        -- Sobrenome
    'BR',                                                                           -- País
    '11999999999',                                                                  -- Telefone
    1,                                                                              -- Status: Ativo
    1,                                                                              -- Email verificado
    1,                                                                              -- SMS verificado
    0,                                                                              -- 2FA desativado
    1,                                                                              -- 2FA verificado
    NOW(),                                                                          -- Data criação
    NOW()                                                                           -- Data atualização
);

-- 3️⃣ VERIFICAR se foi criado
SELECT 
    id,
    username,
    email,
    firstname,
    lastname,
    status,
    ev,
    sv,
    created_at
FROM users 
WHERE username = 'cliente';

-- ========================================
-- ✅ CREDENCIAIS CRIADAS:
-- ========================================
-- URL:      https://inteligenciamax.com.br/user/login
-- Usuário:  cliente
-- Email:    cliente@teste.com  
-- Senha:    admin
-- ========================================
