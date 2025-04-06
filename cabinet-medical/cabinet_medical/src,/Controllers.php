<?php include("config.php"); ?>

<?php
class HomeController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $medecinModel = new Medecin($this->db);
        $medecins = $medecinModel->getAllMedecins();

        return [
            'template' => 'home',
            'data' => [
                'title' => 'Accueil',
                'medecins' => $medecins
            ]
        ];
    }
}