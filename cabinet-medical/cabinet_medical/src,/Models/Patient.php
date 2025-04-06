<?php include("config.php"); ?>

<?php
class Patient {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function inscription($nom, $prenom, $email, $telephone, $mot_de_passe) {
        $token = bin2hex(random_bytes(32));
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        $sql = "INSERT INTO patients (nom, prenom, email, telephone, mot_de_passe, token_validation) 
                VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe, :token)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':telephone' => $telephone,
            ':mot_de_passe' => $mot_de_passe_hash,
            ':token' => $token
        ]);
    }

    public function connexion($email, $mot_de_passe) {
        $sql = "SELECT * FROM patients WHERE email = :email AND est_valide = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($patient && password_verify($mot_de_passe, $patient['mot_de_passe'])) {
            return $patient;
        }
        return false;
    }

    public function getPatientById($id) {
        $sql = "SELECT * FROM patients WHERE id_patient = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}