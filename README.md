Creer bdd :

CREATE DATABASE radio4you CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'radio'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON radio4you.* TO 'radio'@'localhost';
FLUSH PRIVILEGES;
