<?php
session_start();
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    /**
     * Show login form
     */
    public function showLogin() {
        if ($this->isLoggedIn()) {
            header('Location: /admin/dashboard');
            exit();
        }
        include __DIR__ . '/../views/admin/login.php';
    }

    /**
     * Process login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Email y contraseña son requeridos';
                header('Location: /admin/login');
                exit();
            }

            if ($this->usuario->login($email, $password)) {
                $_SESSION['user_id'] = $this->usuario->id;
                $_SESSION['user_name'] = $this->usuario->nombre;
                $_SESSION['user_email'] = $this->usuario->email;
                $_SESSION['user_type'] = $this->usuario->tipo_usuario;
                $_SESSION['success'] = 'Bienvenido, ' . $this->usuario->nombre;
                
                header('Location: /admin/dashboard');
                exit();
            } else {
                $_SESSION['error'] = 'Credenciales incorrectas';
                header('Location: /admin/login');
                exit();
            }
        }
    }

    /**
     * Logout user
     */
    public function logout() {
        session_destroy();
        header('Location: /admin/login');
        exit();
    }

    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($role) {
        return isset($_SESSION['user_type']) && $_SESSION['user_type'] === $role;
    }

    /**
     * Check if user is admin or validator
     */
    public function canAccessAdmin() {
        return $this->isLoggedIn() && in_array($_SESSION['user_type'], ['administrador', 'validador']);
    }

    /**
     * Require login
     */
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: /admin/login');
            exit();
        }
    }

    /**
     * Require admin access
     */
    public function requireAdmin() {
        $this->requireLogin();
        if (!$this->canAccessAdmin()) {
            $_SESSION['error'] = 'No tienes permisos para acceder a esta sección';
            header('Location: /admin/login');
            exit();
        }
    }
}
?>