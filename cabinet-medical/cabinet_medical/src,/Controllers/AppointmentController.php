<?php include("config.php"); ?>

<?php
class AppointmentController {
    private $db;
    private $rendezVous;

    public function __construct($db) {
        $this->db = $db;
        $this->rendezVous = new RendezVous($db);
    }

    public function handlePriseRendezVous() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['patient_id'])) {
                return ['success' => false, 'message' => 'Vous devez être connecté'];
            }

            $id_medecin = filter_var($_POST['id_medecin'], FILTER_VALIDATE_INT);
            $date = sanitize($_POST['date']);
            $heure = sanitize($_POST['heure']);
            $motif = sanitize($_POST['motif']);
            $premier_rdv = isset($_POST['premier_rdv']) ? 1 : 0;

            // Validation
            if (!$id_medecin || empty($date) || empty($heure) || empty($motif)) {
                return ['success' => false, 'message' => 'Tous les champs sont obligatoires'];
            }

            // Vérification de la disponibilité
            $date_rdv = $date . ' ' . $heure . ':00';
            if (!$this->rendezVous->isCreneauDisponible($id_medecin, $date_rdv)) {
                return ['success' => false, 'message' => 'Ce créneau n\'est plus disponible'];
            }

            try {
                if ($this->rendezVous->creerRendezVous(
                    $_SESSION['patient_id'],
                    $id_medecin,
                    $date_rdv,
                    $motif,
                    $premier_rdv
                )) {
                    return ['success' => true, 'message' => 'Rendez-vous pris avec succès'];
                }
            } catch (Exception $e) {
                return ['success' => false, 'message' => 'Erreur lors de la prise de rendez-vous'];
            }
        }
        return null;
    }

    public function getCreneauxDisponibles($id_medecin, $date) {
        return $this->rendezVous->getCreneauxDisponibles($id_medecin, $date);
    }

    public function annulerRendezVous($id_rdv) {
        if (!isset($_SESSION['patient_id'])) {
            return ['success' => false, 'message' => 'Vous devez être connecté'];
        }

        try {
            if ($this->rendezVous->annulerRendezVous($id_rdv, $_SESSION['patient_id'])) {
                return ['success' => true, 'message' => 'Rendez-vous annulé avec succès'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de l\'annulation'];
        }
    }
}