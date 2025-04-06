CREATE TABLE messages (
    id_message INT PRIMARY KEY AUTO_INCREMENT,
    id_expediteur INT NOT NULL,
    id_destinataire INT NOT NULL,
    sujet VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lu BOOLEAN DEFAULT FALSE,
    type_expediteur ENUM('patient', 'medecin') NOT NULL,
    type_destinataire ENUM('patient', 'medecin') NOT NULL
);

CREATE TABLE disponibilites (
    id_disponibilite INT PRIMARY KEY AUTO_INCREMENT,
    id_medecin INT NOT NULL,
    jour_semaine INT NOT NULL, -- 1 (Lundi) à 7 (Dimanche)
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    FOREIGN KEY (id_medecin) REFERENCES medecins(id_medecin),
    UNIQUE KEY unique_dispo (id_medecin, jour_semaine)
);

CREATE TABLE exceptions_disponibilites (
    id_exception INT PRIMARY KEY AUTO_INCREMENT,
    id_medecin INT NOT NULL,
    date_exception DATE NOT NULL,
    est_disponible BOOLEAN DEFAULT FALSE,
    heure_debut TIME,
    heure_fin TIME,
    FOREIGN KEY (id_medecin) REFERENCES medecins(id_medecin)
);