<?php include("config.php"); ?>

<?php
if (!isLoggedIn()) {
    redirect('connexion');
}

$appointmentController = new AppointmentController($db);
$result = $appointmentController->handlePriseRendezVous();

// Récupérer la liste des médecins
$medecinModel = new Medecin($db);
$medecins = $medecinModel->getAllMedecins();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Prise de rendez-vous</h2>
                </div>
                <div class="card-body">
                    <?php if ($result): ?>
                        <div class="alert alert-<?= $result['success'] ? 'success' : 'danger' ?>">
                            <?= $result['message'] ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?page=rendez-vous" id="rdvForm">
                        <div class="mb-3">
                            <label for="id_medecin" class="form-label">Médecin</label>
                            <select class="form-select" id="id_medecin" name="id_medecin" required>
                                <option value="">Choisir un médecin</option>
                                <?php foreach ($medecins as $medecin): ?>
                                    <option value="<?= $medecin['id_medecin'] ?>">
                                        Dr. <?= htmlspecialchars($medecin['nom']) ?> - <?= htmlspecialchars($medecin['specialite']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   min="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="heure" class="form-label">Heure</label>
                            <select class="form-select" id="heure" name="heure" required>
                                <option value="">Sélectionnez d'abord une date</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="motif" class="form-label">Motif de la consultation</label>
                            <textarea class="form-control" id="motif" name="motif" rows="3" required></textarea>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="premier_rdv" name="premier_rdv">
                            <label class="form-check-label" for="premier_rdv">Premier rendez-vous</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Confirmer le rendez-vous</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('date').addEventListener('change', function() {
    const medecinId = document.getElementById('id_medecin').value;
    const date = this.value;
    
    if (medecinId && date) {
        fetch(`api/creneaux.php?medecin=${medecinId}&date=${date}`)
            .then(response => response.json())
            .then(creneaux => {
                const select = document.getElementById('heure');
                select.innerHTML = '<option value="">Choisir une heure</option>';
                
                creneaux.forEach(creneau => {
                    const option = document.createElement('option');
                    option.value = creneau;
                    option.textContent = `${creneau}:00`;
                    select.appendChild(option);
                });
            });
    }
});
</script>