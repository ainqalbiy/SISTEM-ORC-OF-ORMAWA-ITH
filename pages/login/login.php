<?php
// pages/login/login.php
require_once '../../config/connection.php';

// Jika sudah login, redirect ke profile
if (!empty($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'pages/profile/profile.php');
    exit;
}

$error = $_GET['error'] ?? '';
$error_msg = '';
if ($error === 'invalid') {
    $error_msg = 'Email/NIM atau password salah. Silakan coba lagi.';
} elseif ($error === 'empty') {
    $error_msg = 'Harap isi semua kolom.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>Login – ORC ORMAWA ITH</title>
  <style>
    body { font-family: 'Poppins', sans-serif; }
    .bg-soft-cream { background-color: #fff7ed; }
    .py-4\.5 { padding-top: 1.125rem; padding-bottom: 1.125rem; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

  <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-[40px] overflow-hidden shadow-2xl min-h-[620px]">

    <!-- Panel Kiri -->
    <div class="w-full md:w-5/12 bg-gradient-to-br from-orange-500 to-orange-700 p-12 flex flex-col items-center justify-center text-white relative">
      <div class="mb-8 relative">
        <div class="w-44 h-36 border-4 border-orange-200/50 rounded-xl flex items-center justify-center bg-white/10 backdrop-blur-sm">
          <i class="fas fa-book-open text-7xl"></i>
        </div>
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-orange-200">
          <i class="fas fa-seedling text-5xl"></i>
        </div>
      </div>
      <div class="text-center">
        <h1 class="text-5xl font-extralight tracking-[0.6em] mb-2 ml-4">ORC</h1>
        <p class="text-[11px] tracking-[0.3em] uppercase opacity-80 mb-16 font-medium">Organization Resource Center</p>
        <div class="relative px-10 italic text-lg font-light max-w-xs mx-auto">
          <i class="fas fa-quote-left absolute -top-4 left-0 opacity-40"></i>
          <p>Grow your knowledge with ORC</p>
          <i class="fas fa-quote-right absolute -bottom-4 right-0 opacity-40"></i>
        </div>
      </div>
    </div>

    <!-- Panel Kanan -->
    <div class="w-full md:w-7/12 bg-soft-cream p-8 md:p-16 flex flex-col justify-center">
      <div class="max-w-md mx-auto w-full text-center">
        <h2 class="text-4xl font-bold text-orange-800 mb-2 tracking-tight">MASUK</h2>
        <p class="text-gray-500 mb-6 font-medium">Selamat datang kembali di ORC</p>
        <div class="w-16 h-[1.5px] bg-gray-300 mx-auto mb-8"></div>

        <?php if ($error_msg): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            <?= e($error_msg) ?>
          </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>proccess/login_process.php" method="POST" class="space-y-5" id="loginForm">

          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="far fa-envelope"></i>
            </span>
            <input type="text" name="email" id="emailInput" required placeholder="Email atau NIM"
                   class="w-full pl-14 pr-4 py-4 rounded-full bg-white border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm text-gray-700">
          </div>

          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="fas fa-lock"></i>
            </span>
            <input type="password" name="password" id="password" required placeholder="Password"
                   class="w-full pl-14 pr-14 py-4 rounded-full bg-white border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm text-gray-700">
            <button type="button" id="togglePass" class="absolute inset-y-0 right-0 pr-5 flex items-center text-gray-400 hover:text-orange-600 transition">
              <i class="far fa-eye-slash" id="eyeIcon"></i>
            </button>
          </div>

          <div class="flex items-center justify-between px-2">
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
              <input type="checkbox" name="remember" class="w-4 h-4 rounded text-orange-600 focus:ring-orange-500 border-gray-300">
              Ingat saya
            </label>
          </div>

          <button type="submit" id="btnSubmit"
                  class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 rounded-full shadow-lg shadow-orange-200 transition duration-300 active:scale-95 tracking-wider">
            MASUK
          </button>
        </form>

        <div class="flex items-center my-8">
          <div class="flex-grow border-t border-gray-200"></div>
          <span class="px-4 text-xs text-gray-400 font-medium uppercase tracking-widest">atau</span>
          <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <p class="text-sm text-gray-600">
          Belum punya akun?
          <a href="<?= BASE_URL ?>pages/signin.php" class="text-orange-700 font-bold hover:underline">Daftar Sekarang</a>
        </p>
      </div>
    </div>

  </div>

  <script>
    // Toggle password visibility
    document.getElementById('togglePass').addEventListener('click', function () {
      const pw = document.getElementById('password');
      const icon = document.getElementById('eyeIcon');
      if (pw.type === 'password') {
        pw.type = 'text';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      } else {
        pw.type = 'password';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      }
    });
  </script>
</body>
</html>
