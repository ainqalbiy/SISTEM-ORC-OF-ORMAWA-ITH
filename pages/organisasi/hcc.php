<?php
$current_page  = 'hcc';
$page_title    = 'HCC ITH — Habibie Coding Club';

$org_slug      = 'HCC';
$org_name      = 'HCC ITH';
$org_full      = 'Habibie Coding Club';
$org_year      = '2026';
$org_tagline   = 'Coding, Software &<br>Digital Creativity';
$org_about_1   = 'Habibie Coding Club (HCC) adalah organisasi mahasiswa di bidang pemrograman dan teknologi yang mendukung pengembangan skill coding, software development, dan digital creativity di Institut Teknologi Habibie.';
$org_about_2   = 'HCC hadir sebagai komunitas belajar yang aktif — mengadakan workshop, hackathon, dan project kolaboratif yang mempersiapkan mahasiswa untuk karir di dunia teknologi digital.';
$org_tags      = ['Coding','Software Dev','Web Dev','Mobile Dev','Hackathon','Digital Creative'];

$org_vision    = '"HCC ITH adalah <em>inkubator digital</em> yang melahirkan developer, designer, dan innovator berbakat — siap menghadapi tantangan era transformasi digital dengan skill dan kolaborasi.\"';
$org_logo_fallback = 'HCC';

$hero_grad_l   = '#0A1628';
$hero_grad_r   = '#1565C0';

$poster_l_grad = 'linear-gradient(160deg,#0A1628,#1565C0)';
$poster_l_label = 'HCC x COC<br>ITH 2026';
$poster_l_img  = 'assets/img/hcc/HCC. EVENT KAMPUS.jpeg';
$poster_r_grad = 'linear-gradient(160deg,#1565C0,#0D47A1)';
$poster_r_label = 'HCC ITH 2026';
$poster_r_img  = 'assets/img/hcc/HCC ITH 2026.jpeg';

$org_collage = [
    ['class'=>'tall','grad'=>'linear-gradient(160deg,#0A1628,#1565C0)','icon'=>'💻','label'=>'TETTONG DIGITAL ITH',    'img'=>'assets/img/hcc/HCC x COC KOLABORASI PROJECT.jpeg'],
    ['class'=>'',    'grad'=>'linear-gradient(160deg,#1565C0,#0D47A1)','icon'=>'🌐','label'=>'HCC x COC',               'img'=>'assets/img/hcc/HCC x COC.jpeg'],
    ['class'=>'',    'grad'=>'linear-gradient(160deg,#0D47A1,#0A1628)','icon'=>'📱','label'=>'Mobile Apps HCC',         'img'=>'assets/img/hcc/MOBILE APPS HCC.jpeg'],
];

$org_posters = [
    ['grad'=>'linear-gradient(160deg,#0A1628,#1565C0)','icon'=>'💻','title'=>'HCC CERDAS',           'tag'=>'Kompetisi Coding',          'subtitle'=>'HCC Cerdas SMAN 1 Parepare',          'img'=>'assets/img/hcc/HCC CERDAS SMAN 1.jpeg'],
    ['grad'=>'linear-gradient(160deg,#1565C0,#0D47A1)','icon'=>'🌐','title'=>'BYTE',                 'tag'=>'Seminar & Workshop Coding',  'subtitle'=>'BYTE: Building Your Yech Expertise',  'img'=>'assets/img/hcc/BYTE.jpeg'],
    ['grad'=>'linear-gradient(160deg,#0D47A1,#1565C0)','icon'=>'🎯','title'=>'OPEN RECRUITMENT HCC', 'tag'=>'Rekrutmen Anggota',          'subtitle'=>'Open Recruitment HCC ITH 2026',       'img'=>'assets/img/hcc/OPEN RECRUITMENT.jpeg'],
];

$programs = [
    ['cat'=>'kolaborasi Project',    'title'=>'HCC x COC',              'desc'=>'Kolaborai dengan Coconut Computer Club Makassar untuk mengadakan seminar bertujuan memperluas jaringan dan keterampilan teknologi antar komunitas.', 'icon'=>'💻','color'=>'linear-gradient(135deg,#0A1628,#1565C0)','img'=>'assets/img/hcc/HCC x COC KOLABORASI PROJECT.jpeg'],
    ['cat'=>'Pengembangan Skill',    'title'=>'HCC Cerdas SMAN 1 PArepare','desc'=>'Program ini fokus pada pengembangan keterampilan teknologi siswa SMAN 1 Parepare melalui pelatihan software dasar, meningkatkan pemahaman coding, dan mendukung incovasi di kalangan pelajar.','icon'=>'🌐','color'=>'linear-gradient(135deg,#1565C0,#0D47A1)','img'=>'assets/img/hcc/HCC CERDAS SMAN 1.jpeg'],
    ['cat'=>'Kompetisi Coding',      'title'=>'Tudang Sikoding',         'desc'=>'Hasckathon ekslusif untuk mahasiswa Institut Teknologi Bacharuddin Jusuf Habibie, menantang peserta membangun solusi teknologi inovatif dalam waktu terbatas.',               'icon'=>'🚀','color'=>'linear-gradient(135deg,#0D47A1,#0A1628)','img'=>'assets/img/hcc/TUDANG SIKODING.jpeg'],
];

$contact_email = 'hcc@ith.ac.id';

require '_org_template.php';