<?php
// index.php - Landing/Redirect

require_once 'config/database.php';
require_once 'classes/Database.php';
require_once 'classes/User.php';

// Jika sudah login, redirect ke dashboard
if (User::isLoggedIn()) {
    header('Location: pages/dashboard.php');
} else {
    // Jika belum login, redirect ke login
    header('Location: auth/login.php');
}
exit;
?>