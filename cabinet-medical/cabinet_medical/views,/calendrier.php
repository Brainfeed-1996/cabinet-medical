<?php include("config.php"); ?>

<?php
$disponibiliteModel = new Disponibilite($db);
$medecinModel = new Medecin($db);

$medecins = $medecinModel->getAllMedecins();
$id_medecin = $_GET['medecin'] ?? null;

if ($id_medecin) {
    $creneaux = $disponibiliteModel->getCreneauxDisponibles($id_medecin, date('Y-m-d'));
    $medecin = $medecinModel->getMedecinById($id_medecin);
}
?>

<div class="container">
    <h2 class="mb-4">Calendrier des disponibilités</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Sélectionner un médecin</h3>
                </div>
                <div class="card-body">
                    <select class="form-select" id="selectMedecin">
                        <option value="">Choisir un médecin</option>
                        <?php foreach ($medecins as $med): ?>
                            <option value="<?= $med['id_medecin'] ?>" 
                                    <?= $id_medecin == $med['id_medecin'] ? 'selected' : '' ?>>
                                Dr. <?= htmlspecialchars($med['nom']) ?> - <?= htmlspecialchars($med['specialite']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if ($id_medecin): ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Créneaux disponibles</h3>
                    </div>
                    <div class="card-body">
                        <div id="creneauxList">
                            <?php if (empty($creneaux)): ?>
                                <p class="text-muted">Aucun créneau disponible pour cette date</p>
                            <?php else: ?>
                                <?php foreach ($creneaux as $creneau): ?>
                                    <button class="btn btn-outline-primary mb-2 me-2">
                                        <?= $creneau ?>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendrier</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        select: function(info) {
            if (document.getElementById('selectMedecin').value) {
                chargerCreneaux(info.startStr);
            }
        }
    });
    calendar.render();

    document.getElementById('selectMedecin').addEventListener('change', function() {
        const medecin = this.value;
        if (medecin) {
            window.location.href = `index.php?page=calendrier&medecin=${medecin}`;
        }
    });
});

function chargerCreneaux(date) {
    const medecin = document.getElementById('selectMedecin').value;
    fetch(`api/creneaux.php?medecin=${medecin}&date=${date}`)
        .then(response => response.json())
        .then(creneaux => {
            const container = document.getElementById('creneauxList');
            container.innerHTML = '';
            
            if (creneaux.length === 0) {
                container.innerHTML = '<p class="text-muted">Aucun créneau disponible pour cette date</p>';
                return;
            }

            creneaux.forEach(creneau => {
                const btn = document.createElement('button');
                btn.className = 'btn btn-outline-primary mb-2 me-2';
                btn.textContent = creneau;
                btn.onclick = () => prendreRendezVous(medecin, date, creneau);
                container.appendChild(btn);
            });
        });
}

function prendreRendezVous(medecin, date, heure) {
    if (confirm(`Confirmer le rendez-vous pour le ${date} à ${heure} ?`)) {
        window.location.href = `index.php?page=rendez-vous&medecin=${medecin}&date=${date}&heure=${heure}`;
    }
}
</script>