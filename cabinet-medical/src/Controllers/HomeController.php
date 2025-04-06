<?php include("config.php"); ?>

<?php
namespace App\Controllers;

class HomeController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        return 'home.php';
    }
} 