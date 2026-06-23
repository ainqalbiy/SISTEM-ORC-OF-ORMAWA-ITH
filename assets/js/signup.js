document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const passwordInput = document.getElementById('password');
    const togglePass = document.getElementById('togglePass');

    // --- 1. TOGGLE PASSWORD VISIBILITY ---
    togglePass.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        
        // Ganti Icon
        const icon = togglePass.querySelector('i');
        icon.classList.toggle('fa-eye-slash');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('text-rose-600');
    });

    // --- 2. AJAX LOGIN (Tanpa Reload Halaman) ---
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault(); // Stop form dari reload halaman

        // Beri efek loading pada tombol
        const originalText = btnSubmit.innerHTML;
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `<i class="fas fa-spinner animate-spin mr-2"></i> AUTHENTICATING...`;

        // Ambil data dari form
        const formData = new FormData(loginForm);

        try {
            // Simulasi pengiriman data ke server (PHP)
            // Ganti 'login_process.php' dengan file backend kamu
            const response = await fetch('login_process.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                // Jika berhasil, arahkan ke dashboard
                window.location.href = 'dashboard.php';
            } else {
                // Jika gagal, tampilkan pesan error dengan animasi
                showError(result.message || 'Login Gagal! Cek kembali akunmu.');
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalText;
            }
        } catch (error) {
            // Fallback jika belum ada backend/koneksi putus
            setTimeout(() => {
                alert('Fitur login sedang disiapkan! (Mockup Mode)');
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalText;
            }, 1500);
        }
    });

    // --- 3. FUNGSI ALERT CUSTOM ---
    function showError(msg) {
        const alertBox = document.createElement('div');
        alertBox.className = 'fixed top-5 right-5 bg-red-600 text-white px-6 py-3 rounded-lg shadow-2xl transform transition-all duration-500 translate-x-full';
        alertBox.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i> ${msg}`;
        
        document.body.appendChild(alertBox);

        // Animasi muncul
        setTimeout(() => alertBox.classList.remove('translate-x-full'), 100);
        
        // Hilang otomatis setelah 3 detik
        setTimeout(() => {
            alertBox.classList.add('translate-x-full');
            setTimeout(() => alertBox.remove(), 500);
        }, 3000);
    }
});