CREATE DATABASE IF NOT EXISTS cabinet_medical;
USE cabinet_medical;

CREATE TABLE IF NOT EXISTS patients (
    id_patient INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telephone VARCHAR(20) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    token_validation VARCHAR(255),
    est_valide BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS medecins (
    id_medecin INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    specialite VARCHAR(100),
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS rendez_vous (
    id_rdv INT PRIMARY KEY AUTO_INCREMENT,
    id_patient INT,
    id_medecin INT,
    date_rdv DATETIME NOT NULL,
    motif TEXT,
    premier_rdv BOOLEAN DEFAULT TRUE,
    statut ENUM('en_attente', 'confirme', 'annule') DEFAULT 'en_attente',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_patient) REFERENCES patients(id_patient),
    FOREIGN KEY (id_medecin) REFERENCES medecins(id_medecin)
);