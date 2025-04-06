<?php include("config.php"); ?>

<?php
class Message {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function envoyerMessage($expediteur, $destinataire, $sujet, $contenu, $type_exp, $type_dest) {
        $sql = "INSERT INTO messages (id_expediteur, id_destinataire, sujet, contenu, 
                type_expediteur, type_destinataire) 
                VALUES (:expediteur, :destinataire, :sujet, :contenu, :type_exp, :type_dest)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':expediteur' => $expediteur,
            ':destinataire' => $destinataire,
            ':sujet' => $sujet,
            ':contenu' => $contenu,
            ':type_exp' => $type_exp,
            ':type_dest' => $type_dest
        ]);
    }

    public function getMessagesRecus($id_destinataire, $type_dest) {
        $sql = "SELECT m.*, 
                CASE 
                    WHEN m.type_expediteur = 'patient' THEN p.nom
                    ELSE med.nom
                END as nom_expediteur
                FROM messages m
                LEFT JOIN patients p ON m.id_expediteur = p.id_patient AND m.type_expediteur = 'patient'
                LEFT JOIN medecins med ON m.id_expediteur = med.id_medecin AND m.type_expediteur = 'medecin'
                WHERE m.id_destinataire = :id_destinataire 
                AND m.type_destinataire = :type_dest
                ORDER BY m.date_envoi DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_destinataire' => $id_destinataire,
            ':type_dest' => $type_dest
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessagesEnvoyes($id_expediteur, $type_exp) {
        $sql = "SELECT m.*, 
                CASE 
                    WHEN m.type_destinataire = 'patient' THEN p.nom
                    ELSE med.nom
                END as nom_destinataire
                FROM messages m
                LEFT JOIN patients p ON m.id_destinataire = p.id_patient AND m.type_destinataire = 'patient'
                LEFT JOIN medecins med ON m.id_destinataire = med.id_medecin AND m.type_destinataire = 'medecin'
                WHERE m.id_expediteur = :id_expediteur 
                AND m.type_expediteur = :type_exp
                ORDER BY m.date_envoi DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_expediteur' => $id_expediteur,
            ':type_exp' => $type_exp
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function marquerCommeLu($id_message, $id_destinataire) {
        $sql = "UPDATE messages 
                SET lu = TRUE 
                WHERE id_message = :id_message 
                AND id_destinataire = :id_destinataire";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_message' => $id_message,
            ':id_destinataire' => $id_destinataire
        ]);
    }

    public function getNombreMessagesNonLus($id_destinataire, $type_dest) {
        $sql = "SELECT COUNT(*) FROM messages 
                WHERE id_destinataire = :id_destinataire 
                AND type_destinataire = :type_dest 
                AND lu = FALSE";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_destinataire' => $id_destinataire,
            ':type_dest' => $type_dest
        ]);
        return $stmt->fetchColumn();
    }
}