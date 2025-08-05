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