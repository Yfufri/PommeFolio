<?php

class AuthController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function loginForm(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('/admin');
        }

        $this->render('auth/login', [
            'error' => $_GET['error'] ?? null,
        ]);
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->redirect('/login?error=Champs%20obligatoires');
        }

        $user = $this->userModel->findByUsername($username);

        if (!$user) {
            $this->redirect('/login?error=Identifiant%20ou%20mot%20de%20passe%20incorrect');
        }

        // Version ultra simple (mot de passe en clair) :
        // if ($password !== $user['password']) { ... }

        // Version un peu plus propre si tu stockes un hash :
        if (!password_verify($password, $user['password'])) {
            $this->redirect('/login?error=Identifiant%20ou%20mot%20de%20passe%20incorrect');
        }

        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];

        $this->redirect('/admin');
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();

        $this->redirect('/home');
    }
}
