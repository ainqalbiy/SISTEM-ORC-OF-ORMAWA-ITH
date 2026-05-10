<?php
// proccess/logout.php
session_start();
require_once '../config/connection.php';

session_destroy();
header('Location: ' . BASE_URL . 'pages/login/login.php');
exit;
