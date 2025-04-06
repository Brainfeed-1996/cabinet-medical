<?php include("config.php"); ?>

<?php
class Medecin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllMedecins() {
        $sql = "SELECT * FROM medecins ORDER BY nom";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMedecinById($id) {
        $sql = "SELECT * FROM medecins WHERE id_medecin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMedecinsBySpecialite($specialite) {
        $sql = "SELECT * FROM medecins WHERE specialite = :specialite ORDER BY nom";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':specialite' => $specialite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSpecialites() {
        $sql = "SELECT DISTINCT specialite FROM medecins ORDER BY specialite";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}