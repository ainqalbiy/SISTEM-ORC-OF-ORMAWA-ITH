<?php
?>
<div class="section-header">
    <h2><i class="bi bi-gear" style="color:var(--orange)"></i> Pengaturan Akun</h2>
</div>

<div class="settings-grid">

    <!-- ── Keamanan ── -->
    <div class="settings-card">
        <div class="settings-card-header">
            <div class="settings-card-icon"><i class="bi bi-shield-lock"></i></div>
            <div>
                <div class="settings-card-title">Keamanan</div>
                <div class="settings-card-desc">Password dan proteksi akun</div>
            </div>
        </div>
        <div class="settings-card-body">
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Password</div>
                    <div class="settings-row-sub">Ganti password akun Anda secara berkala</div>
                </div>
                <button class="btn-sm-outline"
                        onclick="document.getElementById('modalPassword').classList.add('open')">
                    <i class="bi bi-lock"></i> Ganti
                </button>
            </div>
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Status Akun</div>
                    <div class="settings-row-sub">Kondisi aktif/nonaktif akun Anda</div>
                </div>
                <span class="info-badge green"><i class="bi bi-circle-fill" style="font-size:.5rem"></i> Aktif</span>
            </div>
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Role / Jabatan</div>
                    <div class="settings-row-sub">Hak akses Anda dalam sistem</div>
                </div>
                <?php
                $role_badge_class = [
                    'Super Admin' => 'purple',
                    'Admin'       => 'blue',
                    'Pengurus'    => 'orange',
                    'Anggota'     => 'green',
                ];
                $badge_cls = $role_badge_class[$jabatan] ?? '';
                ?>
                <span class="info-badge <?= $badge_cls ?>"><i class="bi bi-person-badge"></i> <?= e($jabatan) ?></span>
            </div>
        </div>
    </div>

    <!-- ── Info Akun ── -->
    <div class="settings-card">
        <div class="settings-card-header">
            <div class="settings-card-icon"><i class="bi bi-person-circle"></i></div>
            <div>
                <div class="settings-card-title">Info Akun</div>
                <div class="settings-card-desc">Data identitas terdaftar</div>
            </div>
        </div>
        <div class="settings-card-body">
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Username / NIM</div>
                    <div class="settings-row-sub"><?= e($user['nim'] ?? '—') ?></div>
                </div>
                <span class="info-badge"><i class="bi bi-hash"></i> ID Login</span>
            </div>
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Email</div>
                    <div class="settings-row-sub"><?= e($user['email']) ?></div>
                </div>
                <span class="info-badge blue"><i class="bi bi-envelope"></i> Terdaftar</span>
            </div>
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Organisasi</div>
                    <div class="settings-row-sub"><?= e($user['organisasi'] ?? '—') ?></div>
                </div>
            </div>
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Angkatan</div>
                    <div class="settings-row-sub"><?= e($user['angkatan'] ?? '—') ?></div>
                </div>
            </div>
            <a href="?tab=profil" class="btn-sm-outline" style="margin-top:4px;width:fit-content">
                <i class="bi bi-pencil"></i> Edit Data Profil
            </a>
        </div>
    </div>

    <!-- ── Sesi Aktif ── -->
    <div class="settings-card">
        <div class="settings-card-header">
            <div class="settings-card-icon"><i class="bi bi-display"></i></div>
            <div>
                <div class="settings-card-title">Sesi Aktif</div>
                <div class="settings-card-desc">Perangkat yang sedang login</div>
            </div>
        </div>
        <div class="settings-card-body">
            <!-- Sesi saat ini (info dari server-side basic) -->
            <div class="session-item">
                <div class="session-icon"><i class="bi bi-laptop"></i></div>
                <div>
                    <div class="session-name">Browser Saat Ini</div>
                    <div class="session-detail">
                        <?php
                        $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
                        // Simple detection
                        if (stripos($ua, 'Mobile') !== false) {
                            $dev = 'Mobile';
                            $ico = 'bi-phone';
                        } elseif (stripos($ua, 'Tablet') !== false) {
                            $dev = 'Tablet';
                            $ico = 'bi-tablet';
                        } else {
                            $dev = 'Desktop';
                            $ico = 'bi-laptop';
                        }
                        // Browser hint
                        $browser = 'Browser';
                        if (stripos($ua, 'Chrome') !== false) $browser = 'Chrome';
                        elseif (stripos($ua, 'Firefox') !== false) $browser = 'Firefox';
                        elseif (stripos($ua, 'Safari') !== false) $browser = 'Safari';
                        elseif (stripos($ua, 'Edge') !== false) $browser = 'Edge';
                        ?>
                        <?= e($browser) ?> · <?= e($dev) ?>
                    </div>
                </div>
                <span class="session-current">Aktif</span>
            </div>
            <div style="font-size:.72rem;color:var(--text-muted);line-height:1.6;margin-top:4px">
                <i class="bi bi-info-circle"></i>
                Sistem menggunakan session PHP standar. Untuk keluar dari semua perangkat, gunakan tombol Keluar di bawah.
            </div>
            <a href="<?= BASE_URL ?>proccess/logout.php"
               onclick="return confirm('Yakin ingin keluar dari semua sesi?')"
               class="btn-danger" style="width:fit-content;margin-top:6px;display:inline-flex;gap:7px;align-items:center;padding:8px 16px">
                <i class="bi bi-box-arrow-right"></i> Keluar Sekarang
            </a>
        </div>
    </div>

    <!-- ── Preferensi Tampilan ── -->
    <div class="settings-card">
        <div class="settings-card-header">
            <div class="settings-card-icon"><i class="bi bi-palette"></i></div>
            <div>
                <div class="settings-card-title">Preferensi Tampilan</div>
                <div class="settings-card-desc">Pengaturan antarmuka lokal</div>
            </div>
        </div>
        <div class="settings-card-body">
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Tampilan Kartu Organisasi</div>
                    <div class="settings-row-sub">Gunakan tampilan kartu (grid) di Manajemen Org.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="toggleOrgCard"
                           onchange="localStorage.setItem('orc_org_view', this.checked ? 'card' : 'table')"
                           checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="settings-row">
                <div>
                    <div class="settings-row-label">Flash Message Auto-hide</div>
                    <div class="settings-row-sub">Sembunyikan pesan sukses otomatis setelah 4 detik</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="toggleFlashAuto"
                           onchange="localStorage.setItem('orc_flash_auto', this.checked ? '1' : '0')" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div style="font-size:.71rem;color:var(--text-muted);margin-top:2px;line-height:1.6">
                <i class="bi bi-info-circle"></i> Preferensi disimpan di browser lokal Anda (localStorage).
            </div>
        </div>
    </div>

    <?php if ($is_super_admin): ?>
    <!-- ── Informasi Sistem (Super Admin) ── -->
    <div class="settings-card" style="grid-column: 1 / -1">
        <div class="settings-card-header">
            <div class="settings-card-icon" style="background:#f3f0ff;color:#5e35b1"><i class="bi bi-server"></i></div>
            <div>
                <div class="settings-card-title">Informasi Sistem</div>
                <div class="settings-card-desc">Detail teknis platform (Super Admin only)</div>
            </div>
        </div>
        <div class="settings-card-body" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px">
            <?php
            $sys_info = [
                ['label'=>'PHP Version',   'val'=>PHP_VERSION,              'icon'=>'bi-code-slash',     'cls'=>'blue'],
                ['label'=>'Server',         'val'=>$_SERVER['SERVER_SOFTWARE'] ?? 'Apache/PHP',           'icon'=>'bi-hdd-rack',       'cls'=>''],
                ['label'=>'Database',       'val'=>'MySQL / MariaDB',        'icon'=>'bi-database',       'cls'=>'green'],
                ['label'=>'Session Driver', 'val'=>'PHP Session (files)',     'icon'=>'bi-file-lock',      'cls'=>'orange'],
                ['label'=>'BASE_URL',       'val'=>BASE_URL,                 'icon'=>'bi-link-45deg',     'cls'=>''],
                ['label'=>'Tanggal Server', 'val'=>date('d M Y H:i'),        'icon'=>'bi-clock',          'cls'=>''],
            ];
            foreach ($sys_info as $si): ?>
            <div style="background:var(--cream);border:1px solid var(--border);border-radius:var(--r-sm);padding:12px 14px">
                <div style="font-size:.68rem;font-weight:700;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.06em">
                    <i class="bi <?= $si['icon'] ?>"></i> <?= e($si['label']) ?>
                </div>
                <div style="font-size:.8rem;font-weight:700;color:var(--text-dark);word-break:break-all;line-height:1.4">
                    <?= e($si['val']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
// Restore toggle states dari localStorage
(function() {
    const orgCard = document.getElementById('toggleOrgCard');
    if (orgCard) {
        const pref = localStorage.getItem('orc_org_view');
        orgCard.checked = pref !== 'table';
    }
    const flashAuto = document.getElementById('toggleFlashAuto');
    if (flashAuto) {
        const pref = localStorage.getItem('orc_flash_auto');
        flashAuto.checked = pref !== '0';
    }
})();
</script>
