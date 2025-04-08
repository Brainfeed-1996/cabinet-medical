<?php
// public/error.php
http_response_code(\ = \['code'] ?? 500);

\ = [
    400 => 'Requête incorrecte',
    403 => 'Accès refusé',
    404 => 'Page non trouvée',
    500 => 'Erreur interne du serveur'
];

\ = \[\] ?? 'Erreur inconnue';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur <?= \ ?> | Cabinet Médical</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background: #f8f9fa;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .error-container {
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .error-code {
            color: #dc3545;
            font-size: 3em;
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">Erreur <?= \ ?></div>
        <h1><?= \ ?></h1>
        <p>Une erreur s'est produite lors du traitement de votre requête.</p>
        <a href="/" class="btn">Retour à l'accueil</a>
    </div>
</body>
</html>
