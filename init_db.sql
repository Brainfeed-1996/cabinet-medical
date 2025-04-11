-- Création de la base de données
CREATE DATABASE
IF NOT EXISTS cabinetmedical;
USE cabinetmedical;

-- Création des tables (exemple)
CREATE TABLE
IF NOT EXISTS patients
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR
(100) NOT NULL,
    prenom VARCHAR
(100) NOT NULL,
    date_naissance DATE,
    email VARCHAR
(255),
    telephone VARCHAR
(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 