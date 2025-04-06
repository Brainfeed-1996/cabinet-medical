<?php include("config.php"); ?>

<?php
class RendezVous {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function creerRendezVous($id_patient, $id_medecin, $date_rdv, $motif, $premier_rdv) {
        $sql = "INSERT INTO rendez_vous (id_patient, id_medecin, date_rdv, motif, premier_rdv) 
                VALUES (:id_patient, :id_medecin, :date_rdv, :motif, :premier_rdv)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_patient' => $id_patient,
            ':id_medecin' => $id_medecin,
            ':date_rdv' => $date_rdv,
            ':motif' => $motif,
            ':premier_rdv' => $premier_rdv
        ]);
    }

    public function getCreneauxDisponibles($id_medecin, $date) {
        // Heures de consultation (8h-18h)
        $heures_travail = range(8, 17);
        
        // Récupérer les créneaux déjà réservés
        $sql = "SELECT HOUR(date_rdv) as heure 
                FROM rendez_vous 
                WHERE id_medecin = :id_medecin 
                AND DATE(date_rdv) = :date 
                AND statut != 'annule'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_medecin' => $id_medecin,
            ':date' => $date
        ]);
        
        $creneaux_reserves = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return array_diff($heures_travail, $creneaux_reserves);
    }

    public function isCreneauDisponible($id_medecin, $date_rdv) {
        $sql = "SELECT COUNT(*) FROM rendez_vous 
                WHERE id_medecin = :id_medecin 
                AND date_rdv = :date_rdv 
                AND statut != 'annule'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_medecin' => $id_medecin,
            ':date_rdv' => $date_rdv
        ]);
        
        return $stmt->fetchColumn() == 0;
    }

    public function annulerRendezVous($id_rdv, $id_patient) {
        $sql = "UPDATE rendez_vous 
                SET statut = 'annule' 
                WHERE id_rdv = :id_rdv 
                AND id_patient = :id_patient";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_rdv' => $id_rdv,
            ':id_patient' => $id_patient
        ]);
    }

    public function getRendezVousPatient($id_patient) {
        $sql = "SELECT r.*, m.nom as nom_medecin, m.specialite 
                FROM rendez_vous r 
                JOIN medecins m ON r.id_medecin = m.id_medecin 
                WHERE r.id_patient = :id_patient 
                ORDER BY r.date_rdv DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_patient' => $id_patient]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}