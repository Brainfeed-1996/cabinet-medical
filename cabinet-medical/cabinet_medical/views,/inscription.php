<?php include("config.php"); ?>

<?php
$auth = new AuthController($db);
$result = $auth->handleInscription();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Inscription</h2>
                </div>
                <div class="card-body">
                    <?php if ($result): ?>
                        <div class="alert alert-<?= $result['success'] ? 'success' : 'danger' ?>">
                            <?= $result['message'] ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?page=inscription">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone" required>
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Déjà inscrit ? <a href="index.php?page=connexion">Connectez-vous</a></p>
                </div>
            </div>
        </div>
    </div>
</div>