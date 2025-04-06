<?php include("config.php"); ?>

<?php
if (!isLoggedIn()) {
    redirect('connexion');
}

$messageModel = new Message($db);
$medecinModel = new Medecin($db);

$type_utilisateur = isset($_SESSION['medecin_id']) ? 'medecin' : 'patient';
$id_utilisateur = isset($_SESSION['medecin_id']) ? $_SESSION['medecin_id'] : $_SESSION['patient_id'];

// Traitement de l'envoi de message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinataire = $_POST['destinataire'];
    $sujet = $_POST['sujet'];
    $contenu = $_POST['contenu'];
    $type_dest = $_POST['type_destinataire'];

    if ($messageModel->envoyerMessage(
        $id_utilisateur,
        $destinataire,
        $sujet,
        $contenu,
        $type_utilisateur,
        $type_dest
    )) {
        $message = ['success' => true, 'text' => 'Message envoyé avec succès'];
    } else {
        $message = ['success' => false, 'text' => 'Erreur lors de l\'envoi du message'];
    }
}

// Récupération des messages
$messages_recus = $messageModel->getMessagesRecus($id_utilisateur, $type_utilisateur);
$messages_envoyes = $messageModel->getMessagesEnvoyes($id_utilisateur, $type_utilisateur);

// Liste des médecins pour le formulaire
$medecins = $medecinModel->getAllMedecins();
?>

<div class="container">
    <h2 class="mb-4">Messagerie</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-<?= $message['success'] ? 'success' : 'danger' ?>">
            <?= $message['text'] ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulaire d'envoi -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nouveau message</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="destinataire" class="form-label">Destinataire</label>
                            <select class="form-select" id="destinataire" name="destinataire" required>
                                <option value="">Choisir un destinataire</option>
                                <?php foreach ($medecins as $medecin): ?>
                                    <option value="<?= $medecin['id_medecin'] ?>">
                                        Dr. <?= htmlspecialchars($medecin['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="type_destinataire" value="medecin">
                        </div>

                        <div class="mb-3">
                            <label for="sujet" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="sujet" name="sujet" required>
                        </div>

                        <div class="mb-3">
                            <label for="contenu" class="form-label">Message</label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Messages reçus et envoyés -->
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="messagesTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="recus-tab" data-bs-toggle="tab" href="#recus">
                        Messages reçus
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="envoyes-tab" data-bs-toggle="tab" href="#envoyes">
                        Messages envoyés
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="messagesContent">
                <!-- Messages reçus -->
                <div class="tab-pane fade show active" id="recus">
                    <?php if (empty($messages_recus)): ?>
                        <p class="text-muted p-3">Aucun message reçu</p>
                    <?php else: ?>
                        <?php foreach ($messages_recus as $msg): ?>
                            <div class="card mb-2 <?= !$msg['lu'] ? 'border-primary' : '' ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>De :</strong> <?= htmlspecialchars($msg['nom_expediteur']) ?>
                                        <br>
                                        <strong>Sujet :</strong> <?= htmlspecialchars($msg['sujet']) ?>
                                    </div>
                                    <small><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?></small>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Messages envoyés -->
                <div class="tab-pane fade" id="envoyes">
                    <?php if (empty($messages_envoyes)): ?>
                        <p class="text-muted p-3">Aucun message envoyé</p>
                    <?php else: ?>
                        <?php foreach ($messages_envoyes as $msg): ?>
                            <div class="card mb-2">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>À :</strong> <?= htmlspecialchars($msg['nom_destinataire']) ?>
                                        <br>
                                        <strong>Sujet :</strong> <?= htmlspecialchars($msg['sujet']) ?>
                                    </div>
                                    <small><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?></small>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Marquer un message comme lu quand il est ouvert
document.querySelectorAll('.message-card').forEach(card => {
    card.addEventListener('click', function() {
        const messageId = this.dataset.messageId;
        fetch('api/messages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'marquer_lu',
                id_message: messageId
            })
        });
    });
});
</script>