-- Procedure para criar pessoa e usuário juntos de forma transacional
DROP PROCEDURE IF EXISTS create_user_with_person;
DELIMITER $$

CREATE PROCEDURE create_user_with_person(
    IN p_name VARCHAR(64),
    IN p_email VARCHAR(128),
    IN p_phone BIGINT,
    IN u_login VARCHAR(64),
    IN u_password_hash VARCHAR(256),
    IN u_is_admin TINYINT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Failed to create user with person';
    END;

    START TRANSACTION;

    INSERT INTO persons (`name`, `email`, `phone`, `created_at`, `updated_at`)
    VALUES (p_name, p_email, p_phone, NOW(), NOW());

    SET @person_id = LAST_INSERT_ID();

    INSERT INTO users (`person_id`, `login`, `password_hash`, `is_admin`, `created_at`, `updated_at`)
    VALUES (@person_id, u_login, u_password_hash, u_is_admin, NOW(), NOW());

    COMMIT;
END$$

DELIMITER ;

-- Procedure para atualizar pessoa e usuário juntos de forma transacional
DROP PROCEDURE IF EXISTS update_user_with_person;
DELIMITER $$

CREATE PROCEDURE update_user_with_person(
    IN p_person_id BIGINT,
    IN p_name VARCHAR(64),
    IN p_email VARCHAR(128),
    IN p_phone BIGINT,
    IN u_login VARCHAR(64),
    IN u_password_hash VARCHAR(256),
    IN u_is_admin TINYINT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Failed to update user with person';
    END;

    START TRANSACTION;

    UPDATE persons
    SET `name` = p_name,
        `email` = p_email,
        `phone` = p_phone,
        `updated_at` = NOW()
    WHERE id = p_person_id;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No person found with provided ID';
    END IF;

    UPDATE users
    SET `login` = u_login,
        `password_hash` = u_password_hash,
        `is_admin` = u_is_admin,
        `updated_at` = NOW()
    WHERE person_id = p_person_id;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No user found for provided person ID';
    END IF;

    COMMIT;
END$$

DELIMITER ;

-- Procedure para deletar usuário e pessoa juntos de forma transacional
DROP PROCEDURE IF EXISTS delete_user_with_person;
DELIMITER $$

CREATE PROCEDURE delete_user_with_person(
    IN p_person_id BIGINT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Failed to delete user with person';
    END;

    START TRANSACTION;

    -- Verifica dependências em users
    SELECT id INTO @user_id FROM users WHERE person_id = p_person_id LIMIT 1;
    IF @user_id IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No user found for provided person ID';
    END IF;

    -- Verifica dependências em orders
    IF EXISTS (SELECT 1 FROM orders WHERE user_id = @user_id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete: user has orders.';
    END IF;

    -- Verifica dependências em carts
    IF EXISTS (SELECT 1 FROM carts WHERE user_id = @user_id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete: user has carts.';
    END IF;

    -- Verifica dependências em users_logs
    IF EXISTS (SELECT 1 FROM users_logs WHERE user_id = @user_id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete: user has logs.';
    END IF;

    -- Verifica dependências em users_passwords_recoveries
    IF EXISTS (SELECT 1 FROM users_passwords_recoveries WHERE user_id = @user_id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete: user has password recoveries.';
    END IF;

    -- Deleta sessões do usuário
    DELETE FROM sessions WHERE user_id = @user_id;

    -- Deleta endereços vinculados à pessoa (não são críticos)
    DELETE FROM addresses WHERE person_id = p_person_id;

    -- Deleta usuário vinculado à pessoa
    DELETE FROM users WHERE person_id = p_person_id;

    -- Deleta a pessoa
    DELETE FROM persons WHERE id = p_person_id;
    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No person found with provided ID';
    END IF;

    COMMIT;
END$$

DELIMITER ;

-- ...existing code...

-- Procedure para criar produto de forma transacional
DROP PROCEDURE IF EXISTS create_product;
DELIMITER $$

CREATE PROCEDURE create_product(
    IN p_product VARCHAR(128),
    IN p_price DECIMAL(10,2),
    IN p_width DECIMAL(10,2),
    IN p_height DECIMAL(10,2),
    IN p_length DECIMAL(10,2),
    IN p_weight DECIMAL(10,3),
    IN p_url VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Failed to create product';
    END;

    START TRANSACTION;

    -- Verifica unicidade do nome do produto
    IF EXISTS (SELECT 1 FROM products WHERE product = p_product) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Product with this name already exists';
    END IF;

    INSERT INTO products (`product`, `price`, `width`, `height`, `length`, `weight`, `url`, `created_at`, `updated_at`)
    VALUES (p_product, p_price, p_width, p_height, p_length, p_weight, p_url, NOW(), NOW());

    COMMIT;
END$$

DELIMITER ;

-- Procedure para atualizar produto de forma transacional
DROP PROCEDURE IF EXISTS update_product;
DELIMITER $$

CREATE PROCEDURE update_product(
    IN p_id BIGINT,
    IN p_product VARCHAR(128),
    IN p_price DECIMAL(10,2),
    IN p_width DECIMAL(10,2),
    IN p_height DECIMAL(10,2),
    IN p_length DECIMAL(10,2),
    IN p_weight DECIMAL(10,3),
    IN p_url VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Failed to update product';
    END;

    START TRANSACTION;

    -- Verifica se o produto existe
    IF NOT EXISTS (SELECT 1 FROM products WHERE id = p_id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No product found with provided ID';
    END IF;

    -- Verifica unicidade do nome do produto (excluindo o próprio)
    IF EXISTS (SELECT 1 FROM products WHERE product = p_product AND id <> p_id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Another product with this name already exists';
    END IF;

    UPDATE products
    SET `product` = p_product,
        `price` = p_price,
        `width` = p_width,
        `height` = p_height,
        `length` = p_length,
        `weight` = p_weight,
        `url` = p_url,
        `updated_at` = NOW()
    WHERE id = p_id;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No product found with provided ID';
    END IF;

    COMMIT;
END$$

DELIMITER ;

-- Procedure para deletar produto de forma transacional
DROP PROCEDURE IF EXISTS delete_product;
DELIMITER $$

CREATE PROCEDURE delete_product(
    IN p_id BIGINT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Failed to delete product';
    END;

    START TRANSACTION;

    -- Verifica existência
    IF NOT EXISTS (SELECT 1 FROM products WHERE id = p_id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No product found with provided ID';
    END IF;

    -- A remoção falhará automaticamente se houver FKs dependentes
    DELETE FROM products WHERE id = p_id;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No product found with provided ID';
    END IF;

    COMMIT;
END$$

DELIMITER ;