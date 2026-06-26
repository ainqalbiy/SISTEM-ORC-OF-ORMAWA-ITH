<?php
// proccess/signup_process.php
// Registrasi mandiri telah dinonaktifkan.
// Akun hanya dapat dibuat oleh Super Admin melalui halaman Manajemen Akun.
require_once '../config/connection.php';

header('Location: ' . BASE_URL . 'pages/login/login.php?info=reg_disabled');
exit;
