<?php
// classes/User.php

class User {
    private $db;
    
    public $id;
    public $username;
    public $password;
    public $role;

    public function __construct() {
        $this->db = new Database();
    }

    // Login method
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $user = $this->db->single($sql, [':username' => $username]);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            return true;
        }
        
        return false;
    }

    // Check if user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    // Check if user is admin
    public static function isAdmin() {
        return self::isLoggedIn() && $_SESSION['role'] === 'admin';
    }

    // Logout method
    public static function logout() {
        session_unset();
        session_destroy();
    }

    // Get current user info
    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'role' => $_SESSION['role']
            ];
        }
        return null;
    }

    // Require login - redirect jika belum login
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ../auth/login.php');
            exit;
        }
    }

    // Require admin - redirect jika bukan admin
    public static function requireAdmin() {
        self::requireLogin();
        if (!self::isAdmin()) {
            header('Location: ../pages/dashboard.php');
            exit;
        }
    }
}
?>