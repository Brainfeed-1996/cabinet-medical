<?php include("config.php"); ?>

<?php
class Disponibilite {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDisponibilitesMedecin($id_medecin) {
        $sql = "SELECT * FROM disponibilites 
                WHERE id_medecin = :id_medecin 
                ORDER BY jour_semaine, heure_debut";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_medecin' => $id_medecin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterDisponibilite($id_medecin, $jour_semaine, $heure_debut, $heure_fin) {
        $sql = "INSERT INTO disponibilites (id_medecin, jour_semaine, heure_debut, heure_fin) 
                VALUES (:id_medecin, :jour_semaine, :heure_debut, :heure_fin)
                ON DUPLICATE KEY UPDATE 
                heure_debut = :heure_debut, 
                heure_fin = :heure_fin";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_medecin' => $id_medecin,
            ':jour_semaine' => $jour_semaine,
            ':heure_debut' => $heure_debut,
            ':heure_fin' => $heure_fin
        ]);
    }

    public function ajouterException($id_medecin, $date, $est_disponible, $heure_debut = null, $heure_fin = null) {
        $sql = "INSERT INTO exceptions_disponibilites 
                (id_medecin, date_exception, est_disponible, heure_debut, heure_fin) 
                VALUES (:id_medecin, :date, :est_disponible, :heure_debut, :heure_fin)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_medecin' => $id_medecin,
            ':date' => $date,
            ':est_disponible' => $est_disponible,
            ':heure_debut' => $heure_debut,
            ':heure_fin' => $heure_fin
        ]);
    }

    public function getCreneauxDisponibles($id_medecin, $date) {
        // Récupérer le jour de la semaine (1-7)
        $jour_semaine = date('N', strtotime($date));
        
        // Vérifier s'il y a une exception pour cette date
        $sql_exception = "SELECT * FROM exceptions_disponibilites 
                         WHERE id_medecin = :id_medecin 
                         AND date_exception = :date";
        
        $stmt = $this->db->prepare($sql_exception);
        $stmt->execute([
            ':id_medecin' => $id_medecin,
            ':date' => $date
        ]);
        $exception = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($exception) {
            if (!$exception['est_disponible']) {
                return []; // Jour non disponible
            }
            $heure_debut = $exception['heure_debut'];
            $heure_fin = $exception['heure_fin'];
        } else {
            // Récupérer les horaires normaux
            $sql_normal = "SELECT heure_debut, heure_fin FROM disponibilites 
                          WHERE id_medecin = :id_medecin 
                          AND jour_semaine = :jour_semaine";
            
            $stmt = $this->db->prepare($sql_normal);
            $stmt->execute([
                ':id_medecin' => $id_medecin,
                ':jour_semaine' => $jour_semaine
            ]);
            $dispo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$dispo) {
                return []; // Jour non travaillé
            }
            
            $heure_debut = $dispo['heure_debut'];
            $heure_fin = $dispo['heure_fin'];
        }
        
        // Générer les créneaux disponibles
        $creneaux = [];
        $heure_courante = strtotime($heure_debut);
        $heure_fin = strtotime($heure_fin);
        
        while ($heure_courante < $heure_fin) {
            $creneaux[] = date('H:i', $heure_courante);
            $heure_courante = strtotime('+30 minutes', $heure_courante);
        }
        
        // Retirer les créneaux déjà réservés
        $sql_rdv = "SELECT TIME_FORMAT(date_rdv, '%H:%i') as heure 
                    FROM rendez_vous 
                    WHERE id_medecin = :id_medecin 
                    AND DATE(date_rdv) = :date 
                    AND statut != 'annule'";
        
        $stmt = $this->db->prepare($sql_rdv);
        $stmt->execute([
            ':id_medecin' => $id_medecin,
            ':date' => $date
        ]);
        $rdv = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        return array_diff($creneaux, $rdv);
    }
}