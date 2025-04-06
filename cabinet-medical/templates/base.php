<?php include("config.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        pre { background: #f4f4f4; padding: 15px; border-radius: 5px; }
        .debug-info { margin-bottom: 30px; border: 2px dashed #ccc; padding: 15px; }
        .error { color: #d9534f; background-color: #f8d7da; padding: 15px; border: 1px solid #d9534f; margin: 15px 0; }
    </style>
</head>
<body>
    <?php
    // =============================================
    // ZONE DE DÉBOGAGE (à supprimer en production)
    // =============================================
    echo '<div class="debug-info">';
    echo '<h3>Debug Information</h3>';
    echo '<pre>Route: ';
    print_r($route ?? 'NON DÉFINIE');
    echo '</pre>';
    
    echo '<pre>Template path: ' . ($templatePath ?? 'NON DÉFINIE') . '</pre>';
    
    echo '<pre>Variables disponibles: ';
    print_r(get_defined_vars());
    echo '</pre>';
    echo '</div>';
    // =============================================

    // Vérification finale avant inclusion
    if (!isset($templatePath)) {
        echo '<div class="error">ERREUR CRITIQUE: $templatePath non défini</div>';
        exit;
    }

    if (!file_exists($templatePath)) {
        echo '<div class="error">ERREUR: Fichier template introuvable à l\'emplacement:<br>'
             . htmlspecialchars($templatePath) . '</div>';
        exit;
    }

    // Inclusion du template principal
    require $templatePath;
    ?>
</body>
</html>