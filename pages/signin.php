<?php
// pages/signin.php — Halaman Pendaftaran Akun Baru
require_once '../config/connection.php';

// Jika sudah login, langsung ke profile
if (!empty($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php');
    exit;
}

$error = $_GET['error'] ?? '';
$error_msg = '';
switch ($error) {
    case 'empty':    $error_msg = 'Harap isi semua kolom yang wajib diisi.'; break;
    case 'exists':   $error_msg = 'Email atau NIM sudah terdaftar. Silakan masuk.'; break;
    case 'failed':   $error_msg = 'Pendaftaran gagal. Silakan coba lagi.'; break;
    case 'short':    $error_msg = 'Password minimal 6 karakter.'; break;
    case 'mismatch': $error_msg = 'Konfirmasi password tidak cocok.'; break;
}
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>Daftar Akun – ORC ORMAWA ITH</title>
  <style>
    body { font-family: 'Poppins', sans-serif; }
    .bg-soft-cream { background-color: #fff7ed; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

  <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-[40px] overflow-hidden shadow-2xl">

    <!-- Panel Kiri -->
    <div class="w-full md:w-5/12 bg-gradient-to-br from-orange-500 to-orange-700 p-12 flex flex-col items-center justify-center text-white relative">
      <div class="mb-8 relative">
        <div class="w-44 h-36 border-4 border-orange-200/50 rounded-xl flex items-center justify-center bg-white/10 backdrop-blur-sm">
          <i class="fas fa-user-plus text-7xl"></i>
        </div>
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-orange-200">
          <i class="fas fa-star text-4xl"></i>
        </div>
      </div>
      <div class="text-center">
        <h1 class="text-5xl font-extralight tracking-[0.6em] mb-2 ml-4">ORC</h1>
        <p class="text-[11px] tracking-[0.3em] uppercase opacity-80 mb-10 font-medium">Organization Resource Center</p>
        <div class="space-y-3 text-sm opacity-90">
          <div class="flex items-center gap-3"><i class="fas fa-check-circle text-orange-200"></i><span>Akses semua organisasi ITH</span></div>
          <div class="flex items-center gap-3"><i class="fas fa-check-circle text-orange-200"></i><span>Simpan & kelola dokumen</span></div>
          <div class="flex items-center gap-3"><i class="fas fa-check-circle text-orange-200"></i><span>Pantau kegiatan ORMAWA</span></div>
        </div>
      </div>
    </div>

    <!-- Panel Kanan -->
    <div class="w-full md:w-7/12 bg-soft-cream p-8 md:p-14 flex flex-col justify-center">
      <div class="max-w-md mx-auto w-full text-center">
        <h2 class="text-4xl font-bold text-orange-800 mb-2 tracking-tight">DAFTAR</h2>
        <p class="text-gray-500 mb-5 font-medium">Buat akunmu dan bergabung dengan ORC</p>
        <div class="w-16 h-[1.5px] bg-gray-300 mx-auto mb-6"></div>

        <?php if ($error_msg): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i> <?= e($error_msg) ?>
          </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>proccess/signin_process.php" method="POST" class="space-y-4 text-left" id="signInForm">

          <!-- Nama Lengkap -->
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="fas fa-user"></i>
            </span>
            <input type="text" name="nama" required placeholder="Nama Lengkap"
                   class="w-full pl-14 pr-4 py-3.5 rounded-full bg-white border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm text-gray-700">
          </div>

          <!-- NIM -->
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="fas fa-id-card"></i>
            </span>
            <input type="text" name="nim" required placeholder="NIM (Nomor Induk Mahasiswa)"
                   class="w-full pl-14 pr-4 py-3.5 rounded-full bg-white border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm text-gray-700">
          </div>

          <!-- Email -->
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="far fa-envelope"></i>
            </span>
            <input type="email" name="email" required placeholder="Alamat Email"
                   class="w-full pl-14 pr-4 py-3.5 rounded-full bg-white border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm text-gray-700">
          </div>

          <!-- Password -->
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="fas fa-lock"></i>
            </span>
            <input type="password" name="password" id="passwordField" required placeholder="Password (min. 6 karakter)"
                   class="w-full pl-14 pr-14 py-3.5 rounded-full bg-white border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm text-gray-700">
            <button type="button" id="togglePass" class="absolute inset-y-0 right-0 pr-5 flex items-center text-gray-400 hover:text-orange-600 transition">
              <i class="far fa-eye-slash" id="eyeIcon"></i>
            </button>
          </div>

          <!-- Konfirmasi Password -->
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="fas fa-shield-alt"></i>
            </span>
            <input type="password" name="confirm_password" id="confirmPassword" required placeholder="Konfirmasi Password"
                   class="w-full pl-14 pr-4 py-3.5 rounded-full bg-white border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm text-gray-700">
          </div>
          <p id="matchMsg" class="text-xs text-red-500 hidden pl-4">Password tidak cocok!</p>

          <button type="submit" id="btnDaftar"
                  class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 rounded-full shadow-lg shadow-orange-200 transition duration-300 active:scale-95 tracking-wider mt-2">
            DAFTAR SEKARANG
          </button>
        </form>

        <p class="text-sm text-gray-600 mt-6">
          Sudah punya akun?
          <a href="<?= BASE_URL ?>pages/login/login.php" class="text-orange-700 font-bold hover:underline">Masuk</a>
        </p>
      </div>
    </div>

  </div>

  <script>
    // Toggle password visibility
    document.getElementById('togglePass').addEventListener('click', function () {
      const pw = document.getElementById('passwordField');
      const icon = document.getElementById('eyeIcon');
      if (pw.type === 'password') {
        pw.type = 'text';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      } else {
        pw.type = 'password';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      }
    });

    // Cek kecocokan password real-time
    document.getElementById('confirmPassword').addEventListener('input', function () {
      const pw = document.getElementById('passwordField').value;
      const msg = document.getElementById('matchMsg');
      if (this.value && this.value !== pw) {
        msg.classList.remove('hidden');
      } else {
        msg.classList.add('hidden');
      }
    });

    // Validasi sebelum submit
    document.getElementById('signInForm').addEventListener('submit', function (e) {
      const pw = document.getElementById('passwordField').value;
      const cpw = document.getElementById('confirmPassword').value;
      if (pw !== cpw) {
        e.preventDefault();
        document.getElementById('matchMsg').classList.remove('hidden');
      }
    });
  </script>
</body>
</html>
