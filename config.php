<?php
// Configuration MySQL (port 3306 par défaut, pas besoin de le spécifier généralement)
$host = "sql108.infinityfree.com";  // Serveur MySQL d'InfinityFree (remplacez XXX)
$user = "if0_38687649";      // Identifiant MySQL
$password = "Zinkrobin1";    // Mot de passe MySQL
$dbname = "if0_38687649_cabinetmedical"; // Nom de la base

// Connexion à la base
$conn = new mysqli($host, $user, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>