# Chemin vers le répertoire d'installation de XAMPP
$xamppPath = "C:\xampp"

# Chemin vers le fichier SQL de création de la base de données
$sqlFilePath = "$xamppPath\mysql\bin\setup.sql"

# Commandes SQL pour créer la base de données et les tables
$sqlCommands = @"
CREATE DATABASE IF NOT EXISTS medical_cabinet;

USE medical_cabinet;

CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialty VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    date DATE NOT NULL,
    time TIME NOT NULL,
    reason TEXT,
    status ENUM('scheduled', 'cancelled') DEFAULT 'scheduled',
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);
"@

# Écrire les commandes SQL dans un fichier temporaire
$sqlCommands | Out-File -FilePath $sqlFilePath

# Exécuter les commandes SQL avec MySQL
Start-Process -FilePath "$xamppPath\mysql\bin\mysql.exe" -ArgumentList "-u root", "--password=", "-e `"source $sqlFilePath`""

Write-Host "La base de données a été configurée avec succès."
