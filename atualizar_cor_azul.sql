-- Atualizar cor base para Azul Inteligência MAX
UPDATE general_settings SET base_color = '29B6F6' WHERE id = 1;

-- Verificar alteração
SELECT id, site_name, CONCAT('#', base_color) as cor_atual FROM general_settings WHERE id = 1;
