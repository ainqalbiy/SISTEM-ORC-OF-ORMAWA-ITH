<?php
// proccess/update_profile.php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'pages/login/login.php');
    exit;
}

// Proses update (kembangkan sesuai kebutuhan)
header('Location: ' . BASE_URL . 'pages/profile/profile.php');
exit;
