<?php
// pages/delete_motor.php

require_once '../config/database.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../classes/Motor.php';

// Hanya admin yang bisa akses
User::requireAdmin();

// Get motor ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $motor = new Motor();
    
    if ($motor->delete($id)) {
        $_SESSION['success_message'] = 'Motor berhasil dihapus!';
    } else {
        $_SESSION['error_message'] = 'Gagal menghapus motor!';
    }
}

header('Location: motors.php');
exit;
?>