<?php
require_once '../config/connection.php';
// Hapus semua session data
session_unset();
session_destroy();
// Redirect ke login page
header('Location: ' . BASE_URL . 'pages/login/login.php?msg=logout');
exit;
