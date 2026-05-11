<?php
// Simulasi penanganan form saat tombol Sign In diklik
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Contoh logika sederhana (Ganti dengan koneksi database Anda)
    if ($email === "admin@orc.com" && $password === "123456") {
        // Redirect jika berhasil
        // header("Location: dashboard.php");
        // exit();
        echo "<script>alert('Login Berhasil!');</script>";
    } else {
        $error_message = "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>ORC Sign In - PHP Version</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    body { font-family: 'Poppins', sans-serif; }
    .bg-soft-cream { background-color: #fff7ed; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

  <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-[40px] overflow-hidden shadow-2xl min-h-[650px]">
    
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
        <p class="text-[11px] tracking-[0.3em] uppercase opacity-80 mb-20 font-medium">Organization Resource Center</p>
        
        <div class="relative px-10 italic text-lg font-light max-w-xs mx-auto">
            <i class="fas fa-quote-left absolute -top-4 left-0 opacity-40"></i>
            <p>Grow your knowledge with ORC</p>
            <i class="fas fa-quote-right absolute -bottom-4 right-0 opacity-40"></i>
        </div>
      </div>
    </div>

    <div class="w-full md:w-7/12 bg-soft-cream p-8 md:p-20 flex flex-col justify-center">
      <div class="max-w-md mx-auto w-full text-center">
        <h2 class="text-5xl font-bold text-orange-800 mb-3 tracking-tight">SIGN IN</h2>
        <p class="text-gray-500 mb-8 font-medium">Welcome back to ORC</p>
        <div class="w-16 h-[1.5px] bg-gray-300 mx-auto mb-12"></div>

        <?php if ($error_message): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg mb-6 text-sm">
            <?php echo $error_message; ?>
          </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="space-y-6">
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="far fa-envelope"></i>
            </span>
            <input type="email" name="email" required placeholder="Email" 
                   class="w-full pl-14 pr-4 py-4.5 rounded-full bg-white border-none focus:ring-2 focus:ring-orange-500 shadow-sm text-gray-700">
          </div>

          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400">
              <i class="fas fa-lock"></i>
            </span>
            <input type="password" name="password" required placeholder="Password" 
                   class="w-full pl-14 pr-14 py-4.5 rounded-full bg-white border-none focus:ring-2 focus:ring-orange-500 shadow-sm text-gray-700">
            <button type="button" class="absolute inset-y-0 right-0 pr-5 flex items-center text-gray-400 hover:text-orange-600 transition">
              <i class="far fa-eye-slash"></i>
            </button>
          </div>

          <div class="flex items-center space-x-3 px-4">
            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded text-orange-600 focus:ring-orange-500 border-gray-300">
            <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">Remender me</label>
          </div>

          <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-4.5 rounded-full shadow-lg shadow-orange-200 transition duration-300 transform active:scale-95 mt-4 tracking-wider">
            SIGN IN
          </button>
        </form>

        <div class="flex items-center my-12">
          <div class="flex-grow border-t border-gray-200"></div>
          <span class="px-5 text-xs text-gray-400 font-medium uppercase tracking-widest bg-soft-cream">or continue with</span>
          <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <div class="flex justify-center mb-12">
          <button class="p-4 bg-white rounded-full shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
            <img src="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png" alt="Google" class="w-6 h-6">
          </button>
        </div>

        <p class="text-sm text-gray-600">
          Don't have an account? <a href="#" class="text-orange-700 font-bold hover:underline">Sign Up</a>
        </p>
      </div>
    </div>

  </div>

</body>
</html>