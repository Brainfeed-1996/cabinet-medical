<?php include("config.php"); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Bienvenue au Cabinet Médical</h1>
            <p class="lead">
                Notre équipe de professionnels de santé est là pour prendre soin de vous.
            </p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Prise de rendez-vous</h5>
                    <p class="card-text">Prenez rendez-vous en ligne avec nos médecins.</p>
                    <?php if (isLoggedIn()): ?>
                        <a href="index.php?page=rendez-vous" class="btn btn-primary">Prendre rendez-vous</a>
                    <?php else: ?>
                        <a href="index.php?page=connexion" class="btn btn-primary">Connectez-vous</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nos médecins</h5>
                    <p class="card-text">Découvrez notre équipe de professionnels de santé.</p>
                    <a href="index.php?page=medecins" class="btn btn-primary">Voir les médecins</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contact</h5>
                    <p class="card-text">Une question ? Contactez-nous directement.</p>
                    <a href="index.php?page=contact" class="btn btn-primary">Nous contacter</a>
                </div>
            </div>
        </div>
    </div>
</div>