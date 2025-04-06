<?php include("config.php"); ?>

<?php
class Document {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajouterDocument($id_patient, $type, $nom_fichier, $description) {
        $sql = "INSERT INTO documents (id_patient, type, nom_fichier, description, date_upload) 
                VALUES (:id_patient, :type, :nom_fichier, :description, NOW())";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_patient' => $id_patient,
            ':type' => $type,
            ':nom_fichier' => $nom_fichier,
            ':description' => $description
        ]);
    }

    public function getDocumentsPatient($id_patient) {
        $sql = "SELECT * FROM documents 
                WHERE id_patient = :id_patient 
                ORDER BY date_upload DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_patient' => $id_patient]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function supprimerDocument($id_document, $id_patient) {
        $sql = "DELETE FROM documents 
                WHERE id_document = :id_document 
                AND id_patient = :id_patient";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_document' => $id_document,
            ':id_patient' => $id_patient
        ]);
    }
}