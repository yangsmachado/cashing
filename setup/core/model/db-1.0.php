<?php 

// SQL utilizado para instalar as tabelas do banco de dados do mini-app 
$sqlDatabase = "CREATE DATABASE IF NOT EXISTS " . $this->app['db'] . " DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE " . $this->app['db'] . ";


CREATE TABLE IF NOT EXISTS usergroups(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `group` VARCHAR(20) NOT NULL,
    permission INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;


CREATE TABLE IF NOT EXISTS users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    usergroup_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_users_usergroups_id FOREIGN KEY(usergroup_id) REFERENCES usergroups(id) 
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;


CREATE TABLE IF NOT EXISTS emails(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    email VARCHAR(255) NOT NULL,
    is_principal BOOLEAN NOT NULL,
    CONSTRAINT fk_emails_users__user_id FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;


CREATE TABLE IF NOT EXISTS expenses(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;


CREATE TABLE IF NOT EXISTS users__expenses (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    expense_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    `year` INT(4) UNSIGNED NOT NULL,
    `month` INT(2) UNSIGNED NOT NULL,
    `value` DECIMAL(10, 2) NOT NULL, 
    CONSTRAINT fk_users__expenses_expenses_id FOREIGN KEY(expense_id) REFERENCES expenses(id),
    CONSTRAINT fk_users__expenses_users_id FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;


CREATE TABLE IF NOT EXISTS incomes (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;


CREATE TABLE IF NOT EXISTS users__incomes (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    income_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    `year` INT(4) UNSIGNED NOT NULL,
    `month` INT(2) UNSIGNED NOT NULL,
    `value` DECIMAL(10, 2) NOT NULL,
    CONSTRAINT `fk_users__incomes_incomes_id` FOREIGN KEY(income_id) REFERENCES incomes(id),
    CONSTRAINT fk_users__incomes_users_id FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;


INSERT INTO usergroups(id, `group`, permission) VALUES
(NULL, 'Admin', 10);


INSERT INTO users(id, name, password, usergroup_id) VALUES
(NULL, 'Yan Gabriel', AES_ENCRYPT('123', '" . $this->encryptionKeys['db'] . "'), 1);


INSERT INTO emails(id, user_id, email, is_principal) VALUES
(NULL, 1, 'yangsmachado@gmail.com', TRUE);


INSERT INTO incomes(id, name, description) VALUES
(NULL, 'Salário Líquido', 'Pelas horas de trabalho na empresa Negócios.com'),
(NULL, 'Aluguel', 'Aluguel do Apartamento Situado à Rua Fulano de Tal, 00');


INSERT INTO users__incomes(id, income_id, user_id, `year`, `month`, `value`) VALUES
(NULL, 1, 1, 2015, 11, 1500.00),
(NULL, 1, 1, 2015, 12, 1500.00),
(NULL, 1, 1, 2016, 1, 2000.00),
(NULL, 1, 1, 2016, 2, 2000.00),
(NULL, 2, 1, 2016, 1, 1000.00),
(NULL, 2, 1, 2016, 2, 1000.00);


INSERT INTO expenses(id, name, description) VALUES
(NULL, 'Conta d\'Água', ''),
(NULL, 'Conta de Luz', ''),
(NULL, 'Conta de Telefone', 'Conta referente ao Plano de Assinatura de Internet Móvel +Internet');


INSERT INTO users__expenses(id, expense_id, user_id, `year`, `month`, `value`) VALUES
(NULL, 1, 1, 2015, 11, 100.35),
(NULL, 1, 1, 2015, 12, 98.75),
(NULL, 1, 1, 2016, 1, 127.52),
(NULL, 1, 1, 2016, 2, 200.00),
(NULL, 2, 1, 2016, 1, 170.93),
(NULL, 2, 1, 2016, 2, 85.67),
(NULL, 3, 1, 2016, 2, 50.00),
(NULL, 3, 1, 2016, 2, 50.00);";