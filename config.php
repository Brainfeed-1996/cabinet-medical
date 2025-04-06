<?php include("config.php"); ?>

<?php
$host = "ftp.infinityfree.net"; // Change avec ton vrai serveur SQL
$user = "epiz_if0_38687649"; // Ton identifiant MySQL trouvé sur InfinityFree
$password = "Zinkrobin1"; // Ton mot de passe MySQL
$dbname = "if0_38687649_cabinetmed"; // Nom de ta base MySQL

// Connexion à la base
$conn = new mysqli($host, $user, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
