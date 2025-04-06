<?php include("config.php"); ?>

<?php
if (!isLoggedIn()) {
    redirect('connexion');
}

$documentModel = new Document($db);

// Traitement de l'upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $file = $_FILES['document'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    
    // Vérification du type de fichier
    $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (in_array($ext, $allowed)) {
        $nom_fichier = uniqid() . '.' . $ext;
        $destination = 'uploads/' . $nom_fichier;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $documentModel->ajouterDocument($_SESSION['patient_id'], $type, $nom_fichier, $description);
            $message = ['success' => true, 'text' => 'Document ajouté avec succès'];
        }
    } else {
        $message = ['success' => false, 'text' => 'Type de fichier non autorisé'];
    }
}

// Récupération des documents
$documents = $documentModel->getDocumentsPatient($_SESSION['patient_id']);
?>

<div class="container">
    <h2 class="mb-4">Mes documents médicaux</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-<?= $message['success'] ? 'success' : 'danger' ?>">
            <?= $message['text'] ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'upload -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Ajouter un document</h3>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="document" class="form-label">Fichier</label>
                    <input type="file" class="form-control" id="document" name="document" required>
                    <small class="text-muted">Formats acceptés : PDF, JPG, PNG</small>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type de document</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="ordonnance">Ordonnance</option>
                        <option value="analyse">Résultat d'analyse</option>
                        <option value="radio">Radiographie</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Ajouter le document</button>
            </form>
        </div>
    </div>

    <!-- Liste des documents -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mes documents</h3>
        </div>
        <div class="card-body">
            <?php if (empty($documents)): ?>
                <p class="text-muted">Aucun document disponible</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Date d'ajout</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($documents as $doc): ?>
                                <tr>
                                    <td><?= htmlspecialchars($doc['type']) ?></td>
                                    <td><?= htmlspecialchars($doc['description']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($doc['date_upload'])) ?></td>
                                    <td>
                                        <a href="uploads/<?= $doc['nom_fichier'] ?>" 
                                           class="btn btn-sm btn-primary" 
                                           target="_blank">Voir</a>
                                        <button class="btn btn-sm btn-danger"
                                                onclick="supprimerDocument(<?= $doc['id_document'] ?>)">
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function supprimerDocument(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
        fetch('api/documents.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id_document: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de la suppression');
            }
        });
    }
}
</script>