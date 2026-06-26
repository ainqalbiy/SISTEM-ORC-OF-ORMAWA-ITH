<?php
// proccess/superadmin_process.php
// Seluruh aksi manajemen akun oleh Super Admin
require_once '../config/connection.php';
require_super_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('pages/dashboard/dashboard.php', ['tab' => 'superadmin']);
}

$action  = trim($_POST['action'] ?? '');
$back    = BASE_URL . 'pages/dashboard/dashboard.php?tab=superadmin';
$pk      = get_user_pk($conn);

// ── Buat Akun Baru ────────────────────────────────────────────────
if ($action === 'buat_akun') {
    $nama       = trim($_POST['nama']       ?? '');
    $nim        = trim($_POST['nim']        ?? '');
    $email      = trim($_POST['email']      ?? '');
    $username   = trim($_POST['username']   ?? '');
    $no_hp      = trim($_POST['no_hp']      ?? '');
    $password   = trim($_POST['password']   ?? '');
    $jabatan    = trim($_POST['jabatan']    ?? 'Anggota');
    $organisasi = trim($_POST['organisasi'] ?? '');
    $angkatan   = trim($_POST['angkatan']   ?? '');
    $status     = trim($_POST['status']     ?? 'Aktif');
    $created_by = (int)$_SESSION['user_id'];

    if (empty($nama) || empty($email) || empty($password)) {
        header('Location: ' . $back . '&error=' . urlencode('Nama, email, dan password wajib diisi.'));
        exit;
    }
    if (strlen($password) < 6) {
        header('Location: ' . $back . '&error=' . urlencode('Password minimal 6 karakter.'));
        exit;
    }
    // Validasi jabatan
    $valid_jabatan = ['Anggota', 'Pengurus', 'Admin', 'Super Admin'];
    if (!in_array($jabatan, $valid_jabatan)) $jabatan = 'Anggota';

    // Cek duplikasi email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        header('Location: ' . $back . '&error=' . urlencode('Email sudah terdaftar.'));
        exit;
    }
    $stmt->close();

    // Cek duplikasi NIM
    if (!empty($nim)) {
        $stmt2 = $conn->prepare("SELECT id FROM users WHERE nim = ? LIMIT 1");
        $stmt2->bind_param('s', $nim);
        $stmt2->execute();
        $stmt2->store_result();
        if ($stmt2->num_rows > 0) {
            $stmt2->close();
            header('Location: ' . $back . '&error=' . urlencode('NIM sudah terdaftar.'));
            exit;
        }
        $stmt2->close();
    }

    // Cek duplikasi username
    if (!empty($username)) {
        $stmt3 = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt3->bind_param('s', $username);
        $stmt3->execute();
        $stmt3->store_result();
        if ($stmt3->num_rows > 0) {
            $stmt3->close();
            header('Location: ' . $back . '&error=' . urlencode('Username sudah digunakan.'));
            exit;
        }
        $stmt3->close();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $nim_val      = $nim      ?: null;
    $username_val = $username ?: null;
    $no_hp_val    = $no_hp    ?: null;
    $org_val      = $organisasi ?: null;
    $angk_val     = $angkatan  ?: null;

    // Gunakan kolom yang tersedia
    $has_username   = user_col_exists($conn, 'username');
    $has_created_by = user_col_exists($conn, 'created_by');

    if ($has_username && $has_created_by) {
        $stmt = $conn->prepare("INSERT INTO users (nama,nim,email,username,no_hp,password,jabatan,organisasi,angkatan,status,created_by) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssssssi', $nama,$nim_val,$email,$username_val,$no_hp_val,$hash,$jabatan,$org_val,$angk_val,$status,$created_by);
    } elseif ($has_username) {
        $stmt = $conn->prepare("INSERT INTO users (nama,nim,email,username,no_hp,password,jabatan,organisasi,angkatan,status) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssssss', $nama,$nim_val,$email,$username_val,$no_hp_val,$hash,$jabatan,$org_val,$angk_val,$status);
    } else {
        $stmt = $conn->prepare("INSERT INTO users (nama,nim,email,no_hp,password,jabatan,organisasi,angkatan,status) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssss', $nama,$nim_val,$email,$no_hp_val,$hash,$jabatan,$org_val,$angk_val,$status);
    }

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ' . $back . '&success=' . urlencode('Akun ' . $nama . ' berhasil dibuat.'));
    } else {
        $err = $conn->error;
        $stmt->close();
        header('Location: ' . $back . '&error=' . urlencode('Gagal membuat akun: ' . $err));
    }
    exit;
}

// ── Update Data Akun ──────────────────────────────────────────────
if ($action === 'update_akun') {
    $target_id  = (int)($_POST['target_id'] ?? 0);
    $nama       = trim($_POST['nama']       ?? '');
    $nim        = trim($_POST['nim']        ?? '');
    $email      = trim($_POST['email']      ?? '');
    $username   = trim($_POST['username']   ?? '');
    $no_hp      = trim($_POST['no_hp']      ?? '');
    $jabatan    = trim($_POST['jabatan']    ?? 'Anggota');
    $organisasi = trim($_POST['organisasi'] ?? '');
    $angkatan   = trim($_POST['angkatan']   ?? '');
    $status     = trim($_POST['status']     ?? 'Aktif');

    if (!$target_id || empty($nama) || empty($email)) {
        header('Location: ' . $back . '&error=' . urlencode('Data tidak lengkap.'));
        exit;
    }

    $valid_jabatan = ['Anggota', 'Pengurus', 'Admin', 'Super Admin'];
    if (!in_array($jabatan, $valid_jabatan)) $jabatan = 'Anggota';

    $nim_val      = $nim      ?: null;
    $username_val = $username ?: null;
    $no_hp_val    = $no_hp    ?: null;
    $org_val      = $organisasi ?: null;
    $angk_val     = $angkatan  ?: null;

    $has_username = user_col_exists($conn, 'username');
    if ($has_username) {
        $stmt = $conn->prepare("UPDATE users SET nama=?,nim=?,email=?,username=?,no_hp=?,jabatan=?,organisasi=?,angkatan=?,status=? WHERE id=?");
        $stmt->bind_param('sssssssssi', $nama,$nim_val,$email,$username_val,$no_hp_val,$jabatan,$org_val,$angk_val,$status,$target_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET nama=?,nim=?,email=?,no_hp=?,jabatan=?,organisasi=?,angkatan=?,status=? WHERE id=?");
        $stmt->bind_param('ssssssssi', $nama,$nim_val,$email,$no_hp_val,$jabatan,$org_val,$angk_val,$status,$target_id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ' . $back . '&success=' . urlencode('Data akun berhasil diperbarui.'));
    } else {
        $err = $conn->error;
        $stmt->close();
        header('Location: ' . $back . '&error=' . urlencode('Gagal memperbarui: ' . $err));
    }
    exit;
}

// ── Toggle Status Akun (Aktif / Nonaktif) ────────────────────────
if ($action === 'toggle_status_akun') {
    $target_id  = (int)($_POST['target_id'] ?? 0);
    $new_status = trim($_POST['new_status'] ?? '');

    if (!$target_id || !in_array($new_status, ['Aktif','Nonaktif'])) {
        header('Location: ' . $back . '&error=' . urlencode('Parameter tidak valid.'));
        exit;
    }
    // Cegah Super Admin menonaktifkan dirinya sendiri
    if ($target_id === (int)$_SESSION['user_id']) {
        header('Location: ' . $back . '&error=' . urlencode('Tidak dapat mengubah status akun Anda sendiri.'));
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET status=? WHERE id=?");
    $stmt->bind_param('si', $new_status, $target_id);
    $msg = $new_status === 'Aktif' ? 'Akun berhasil diaktifkan.' : 'Akun berhasil dinonaktifkan.';
    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ' . $back . '&success=' . urlencode($msg));
    } else {
        $err = $conn->error;
        $stmt->close();
        header('Location: ' . $back . '&error=' . urlencode('Gagal mengubah status: ' . $err));
    }
    exit;
}

// ── Reset Password ────────────────────────────────────────────────
if ($action === 'reset_password') {
    $target_id    = (int)($_POST['target_id']    ?? 0);
    $new_password = trim($_POST['new_password']  ?? '');

    if (!$target_id || strlen($new_password) < 6) {
        header('Location: ' . $back . '&error=' . urlencode('Password baru minimal 6 karakter.'));
        exit;
    }

    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param('si', $hash, $target_id);

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ' . $back . '&success=' . urlencode('Password berhasil direset.'));
    } else {
        $err = $conn->error;
        $stmt->close();
        header('Location: ' . $back . '&error=' . urlencode('Gagal reset password: ' . $err));
    }
    exit;
}

// Aksi tidak dikenal
header('Location: ' . $back . '&error=' . urlencode('Aksi tidak dikenal.'));
exit;
