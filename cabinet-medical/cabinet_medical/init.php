<?php include("config.php"); ?>


<?php
// Vérifier si la base de données existe
try {
    $db = new PDO(
        "mysql:host=" . DB_HOST,
        DB_USER,
        DB_PASS
    );
    
    // Créer la base de données si elle n'existe pas
    $db->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $db->exec("USE " . DB_NAME);
    
    // Importer le schéma
    $schema = file_get_contents('config/schema.sql');
    $db->exec($schema);
    
    // Insérer des données de test
    $sql = "INSERT IGNORE INTO medecins (nom, specialite, email) VALUES 
            ('Dr. Dupont', 'Généraliste', 'dupont@cabinet.fr'),
            ('Dr. Martin', 'Cardiologue', 'martin@cabinet.fr'),
            ('Dr. Durand', 'Pédiatre', 'durand@cabinet.fr')";
    $db->exec($sql);
    
    echo "Installation terminée avec succès !";
    
} catch(PDOException $e) {
    die("Erreur d'installation : " . $e->getMessage());
}