<?php
require_once '../../config/connection.php';

$page_title   = 'Daftar Organisasi';
$page_css     = ['homepage.css'];
$current_page = '';

$q        = trim($_GET['q']        ?? '');
$kategori = trim($_GET['kategori'] ?? '');

$semua_organisasi = [];
$use_db = false;
$org_tbl = $conn->query("SHOW TABLES LIKE 'organisasi'");
if ($org_tbl && $org_tbl->num_rows > 0) {
    $rows = $conn->query("SELECT * FROM organisasi WHERE status='aktif' ORDER BY id ASC")?->fetch_all(MYSQLI_ASSOC) ?? [];
    if (!empty($rows)) {
        $use_db = true;
        foreach ($rows as $row) {
            $semua_organisasi[] = [
                'nama'     => $row['nama'],
                'deskripsi'=> $row['deskripsi'] ?? '',
                'logo'     => BASE_URL . ($row['logo'] ?? 'assets/img/logo/header-logo.jpeg'),
                'slug'     => $row['slug'],
                'kategori' => $row['kategori'] ?? 'ukm',
            ];
        }
    }
}

// Fallback ke hardcoded jika DB kosong atau tabel belum ada
if (!$use_db) {
    $semua_organisasi = [
        [
            'nama'     => 'Badan Eksekutif Mahasiswa (BEM) – ITH',
            'deskripsi'=> 'Wadah aspirasi, koordinasi kegiatan kampus, serta pengembangan kepemimpinan mahasiswa ITH.',
            'logo'     => BASE_URL . 'assets/img/logo/logo-bem.jpeg',
            'slug'     => 'bem',
            'kategori' => 'bem',
        ],
        [
            'nama'     => 'Habibie Engineering Robotic of Organization (HERO) – ITH',
            'deskripsi'=> 'Berfokus pada pengembangan teknologi robotika, IoT, dan inovasi di bidang engineering.',
            'logo'     => BASE_URL . 'assets/img/logo/logo-hero.png',
            'slug'     => 'hero',
            'kategori' => 'ukm',
        ],
        [
            'nama'     => 'Habibie Coding Club (HCC) – ITH',
            'deskripsi'=> 'Di bidang pemrograman dan teknologi, mendukung skill coding, software, dan digital creativity.',
            'logo'     => BASE_URL . 'assets/img/logo/logo-hcc.png',
            'slug'     => 'hcc',
            'kategori' => 'ukm',
        ],
        [
            'nama'     => 'UKM Seni Art & Talent (ARATTA) – ITH',
            'deskripsi'=> 'Wadah pengembangan minat, kreativitas, dan bakat mahasiswa di bidang seni dan hiburan.',
            'logo'     => BASE_URL . 'assets/img/logo/logo-aratta.png',
            'slug'     => 'aratta',
            'kategori' => 'ukm',
        ],
        [
            'nama'     => 'Wirausaha (WITH) – ITH',
            'deskripsi'=> 'Berfokus pada pengembangan jiwa kewirausahaan, kreativitas bisnis, dan inovasi usaha mahasiswa.',
            'logo'     => BASE_URL . 'assets/img/logo/logo-with.png',
            'slug'     => 'wirausaha',
            'kategori' => 'ukm',
        ],
    ];
}

// Filter berdasarkan search
$hasil = array_filter($semua_organisasi, function($org) use ($q, $kategori) {
    $cocokNama     = $q === '' || stripos($org['nama'], $q) !== false || stripos($org['deskripsi'], $q) !== false;
    $cocokKategori = $kategori === '' || $org['kategori'] === $kategori;
    return $cocokNama && $cocokKategori;
});

require_once '../../components/header.php';
require_once '../../components/navbar.php';
?>

<section class="search-section">
    <form class="search-bar" id="searchForm" role="search" action="" method="GET">
        <div class="search-left">
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="q" class="search-input" placeholder="Cari Organisasi"
                   value="<?= htmlspecialchars($q) ?>" aria-label="Cari">
        </div>
        <div class="search-divider"></div>
        <!-- Pilih Organisasi — dropdown menurun -->
        <div class="search-middle" style="position:relative;">
            <div id="orgDropdownBtn" onclick="toggleOrgDropdown()" style="display:flex;align-items:center;gap:6px;cursor:pointer;min-width:180px;padding:0 4px;">
                <span id="orgDropdownLabel" style="flex:1;font-size:.85rem;color:var(--text-dark)">Pilih Organisasi</span>
                <i class="bi bi-chevron-down select-arrow" id="orgDropdownArrow"></i>
            </div>
            <div id="orgDropdownList" style="display:none;position:absolute;top:calc(100% + 10px);left:0;background:#fff;border:1.5px solid var(--border);border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.12);min-width:240px;z-index:200;overflow:hidden;">
                <div onclick="selectOrg('','Pilih Organisasi')" style="padding:10px 16px;font-size:.83rem;color:var(--text-muted);cursor:pointer;border-bottom:1px solid var(--border)" onmouseover="this.style.background='#fff7ed'" onmouseout="this.style.background='#fff'">Semua Organisasi</div>
                <?php foreach ($semua_organisasi as $org): ?>
                <div onclick="selectOrg('<?= htmlspecialchars($org['slug']) ?>','<?= htmlspecialchars($org['nama']) ?>')"
                     style="padding:10px 16px;font-size:.83rem;color:var(--text-dark);cursor:pointer;display:flex;align-items:center;gap:10px;"
                     onmouseover="this.style.background='#fff7ed'" onmouseout="this.style.background='#fff'">
                    <img src="<?= htmlspecialchars($org['logo']) ?>" alt="" style="width:22px;height:22px;object-fit:contain;border-radius:4px;" onerror="this.style.display='none'">
                    <?= htmlspecialchars($org['nama']) ?>
                </div>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="org" id="orgHidden" value="">
        </div>
        <div class="search-divider"></div>
        <!-- Pilih Kategori -->
        <div class="search-middle">
            <select name="kategori" class="search-select">
                <option value="">Pilih Kategori Organisasi</option>
                <option value="bem"      <?= $kategori === 'bem'      ? 'selected' : '' ?>>BEM</option>
                <option value="ukm"      <?= $kategori === 'ukm'      ? 'selected' : '' ?>>UKM</option>
                <option value="himpunan" <?= $kategori === 'himpunan' ? 'selected' : '' ?>>Himpunan Mahasiswa</option>
            </select>
            <i class="bi bi-chevron-down select-arrow"></i>
        </div>
        <button type="submit" class="btn-search">Cari</button>
    </form>
</section>

<script>
function toggleOrgDropdown() {
    const list = document.getElementById('orgDropdownList');
    const arrow = document.getElementById('orgDropdownArrow');
    const open = list.style.display === 'block';
    list.style.display = open ? 'none' : 'block';
    arrow.style.transform = open ? '' : 'rotate(180deg)';
}
function selectOrg(slug, nama) {
    document.getElementById('orgHidden').value = slug;
    document.getElementById('orgDropdownLabel').textContent = nama;
    document.getElementById('orgDropdownList').style.display = 'none';
    document.getElementById('orgDropdownArrow').style.transform = '';
    if (slug) {
        window.location.href = '<?= BASE_URL ?>pages/organisasi/' + slug + '.php';
    }
}
// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const btn = document.getElementById('orgDropdownBtn');
    const list = document.getElementById('orgDropdownList');
    if (btn && list && !btn.contains(e.target) && !list.contains(e.target)) {
        list.style.display = 'none';
        document.getElementById('orgDropdownArrow').style.transform = '';
    }
});
</script>

<section class="orgs-section" style="padding:40px 0 60px;">
    <div class="orgs-section-header">
        <h2>
            <?= ($q || $kategori) ? 'Hasil Pencarian' : 'Semua Organisasi' ?>
            <?php if ($q): ?><small style="font-size:1rem;color:#8a6a45;"> — "<?= htmlspecialchars($q) ?>"</small><?php endif; ?>
        </h2>
    </div>

    <div style="display:flex;flex-wrap:wrap;gap:24px;padding:0 24px;max-width:1200px;margin:0 auto;">
        <?php if (empty($hasil)): ?>
            <p style="color:#8a6a45;padding:20px;">Tidak ada organisasi yang cocok dengan pencarian.</p>
        <?php else: ?>
            <?php foreach ($hasil as $org): ?>
            <div class="org-card" style="flex:0 0 280px;">
                <!-- Logo/foto organisasi — ganti src untuk mengubah gambar -->
                <div class="org-card-logo">
                    <img src="<?= htmlspecialchars($org['logo']) ?>"
                         alt="Logo <?= htmlspecialchars($org['nama']) ?>"
                         loading="lazy"
                         onerror="this.src='<?= BASE_URL ?>assets/img/logo/header-logo.jpeg'">
                </div>
                <div class="org-card-body">
                    <h3><?= htmlspecialchars($org['nama']) ?></h3>
                    <p><?= htmlspecialchars($org['deskripsi']) ?></p>
                </div>
                <a href="<?= BASE_URL ?>pages/organisasi/<?= urlencode($org['slug']) ?>.php" class="btn-explore">
                    Explore Organisasi
                </a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../../components/footer.php'; ?>