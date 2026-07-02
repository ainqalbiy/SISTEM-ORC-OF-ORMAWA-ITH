<?php
require_once '../config/connection.php';
session_unset();
session_destroy();
header('Location: ' . BASE_URL . 'pages/login/login.php?msg=logout');
exit;
