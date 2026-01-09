<?php
// config/database.php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Ganti dengan password MySQL kamu
define('DB_NAME', 'motor_sales');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error reporting untuk development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>