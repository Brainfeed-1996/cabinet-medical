<?php include("config.php"); ?>

<?php
class AuthController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'role' => $user['role']
                ];
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Connexion réussie'
                ];
                header('Location: /');
                exit;
            }

            $error = 'Identifiants incorrects';
        }

        return [
            'template' => 'auth/login',
            'data' => [
                'title' => 'Connexion',
                'error' => $error ?? null
            ]
        ];
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING),
                'prenom' => filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'password' => $_POST['password']
            ];

            if ($this->userModel->create($data)) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Inscription réussie. Vous pouvez maintenant vous connecter.'
                ];
                header('Location: /login');
                exit;
            }

            $error = 'Erreur lors de l\'inscription';
        }

        return [
            'template' => 'auth/register',
            'data' => [
                'title' => 'Inscription',
                'error' => $error ?? null
            ]
        ];
    }

    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}