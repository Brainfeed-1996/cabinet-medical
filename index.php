<?php include("config.php"); ?>

<?php
$target = '/htdocs/public/index.php'; // ou '/public/index.php' selon la structure exacte
if (file_exists(__DIR__ . $target)) {
    header("Location: $target", true, 301);
} else {
    die("Erreur : Le fichier /public/index.php est introuvable");
}
exit();
?>