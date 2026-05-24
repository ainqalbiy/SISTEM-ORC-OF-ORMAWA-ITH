<?php
// test_connection.php — hapus file ini setelah testing!
require_once 'config/connection.php';

echo "<pre style='font-family:monospace;padding:20px'>";
echo "<h2>🔍 ORC Debug Info</h2>\n\n";

echo "BASE_URL    : " . BASE_URL . "\n";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "SCRIPT_NAME : " . $_SERVER['SCRIPT_NAME'] . "\n\n";

// Test koneksi DB
echo "DB Connection: ";
if ($conn->connect_error) {
    echo "❌ GAGAL — " . $conn->connect_error . "\n";
} else {
    echo "✅ OK\n";
}

// Test tabel users
$r = $conn->query("SELECT COUNT(*) AS c FROM users");
if ($r) {
    echo "Tabel users : ✅ OK — " . $r->fetch_assoc()['c'] . " user\n";
} else {
    echo "Tabel users : ❌ TIDAK ADA — jalankan db_orc.sql dulu!\n";
}

// Session
echo "\nSession data:\n";
print_r($_SESSION);

echo "\n\n<a href='" . BASE_URL . "pages/login/login.php'>→ Ke halaman Login</a>";
echo "</pre>";
