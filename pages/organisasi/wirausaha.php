<?php
// pages/organisasi/wirausaha.php — Wirausaha (WITH) ITH
$current_page  = 'wirausaha';
$page_title    = 'Wirausaha ITH — WITH (Wirausaha Institut Teknologi Habibie)';

$org_slug      = 'Wirausaha';
$org_name      = 'WITH ITH';
$org_full      = 'Wirausaha Institut Teknologi Habibie';
$org_year      = '2026';
$org_tagline   = 'Jiwa Wirausaha &<br>Inovasi Bisnis';
$org_about_1   = 'Wirausaha Institut Teknologi Habibie (WITH) adalah organisasi mahasiswa yang berfokus pada pengembangan jiwa kewirausahaan, kreativitas bisnis, dan inovasi usaha mahasiswa di lingkungan kampus ITH.';
$org_about_2   = 'WITH hadir sebagai ekosistem wirausaha kampus — memfasilitasi mahasiswa untuk memulai dan mengembangkan usaha, menghubungkan dengan mentor bisnis, dan menciptakan peluang kolaborasi antar pengusaha muda ITH.';
$org_tags      = ['Kewirausahaan','Bisnis Startup','Inovasi Usaha','Mentorship','Networking','Business Plan'];

$org_vision    = '"WITH ITH adalah <em>inkubator wirausaha</em> yang melahirkan pengusaha muda berkarakter — berani bermimpi besar, berani memulai, dan berani menciptakan dampak nyata bagi masyarakat.\"';
$org_logo_fallback = 'WITH';

$hero_grad_l   = '#1B3A1F';
$hero_grad_r   = '#C96511';

$poster_l_grad = 'linear-gradient(160deg,#1B3A1F,#2E7D32)';
$poster_l_label = 'BUSINESS PLAN<br>COMPETITION';
$poster_l_img  = 'assets/img/with/Business Plan Competition WITH ITH.jpeg';
$poster_r_grad = 'linear-gradient(160deg,#C96511,#5C2E0A)';
$poster_r_label = 'WITH ITH 2026';
$poster_r_img  = 'assets/img/with/Startup Pitching Day WITH ITH 2026.jpeg';

$org_collage = [
    ['class'=>'tall','grad'=>'linear-gradient(160deg,#1B3A1F,#2E7D32)','icon'=>'💼','label'=>'Business Plan','img'=>'assets/img/with/Business Plan Competition WITH ITH.jpeg'],
    ['class'=>'',    'grad'=>'linear-gradient(160deg,#C96511,#5C2E0A)','icon'=>'🚀','label'=>'Startup Pitching','img'=>'assets/img/with/Startup Pitching Day WITH ITH 2026.jpeg'],
    ['class'=>'',    'grad'=>'linear-gradient(160deg,#2E7D32,#1B3A1F)','icon'=>'🤝','label'=>'Networking Event','img'=>'assets/img/with/Open Recruitment  WITH ITH.jpeg'],
];

$org_posters = [
    ['grad'=>'linear-gradient(160deg,#1B3A1F,#2E7D32)','icon'=>'💼','title'=>'BUSINESS PLAN COMPETITION','tag'=>'Kompetisi Bisnis','subtitle'=>'Business Plan Competition WITH ITH','img'=>'assets/img/with/Business Plan Competition WITH ITH.jpeg'],
    ['grad'=>'linear-gradient(160deg,#C96511,#5C2E0A)','icon'=>'🚀','title'=>'STARTUP PITCHING DAY','tag'=>'Pitching Event','subtitle'=>'Startup Pitching Day WITH ITH 2026','img'=>'assets/img/with/Startup Pitching Day WITH ITH 2026.jpeg'],
    ['grad'=>'linear-gradient(160deg,#2E7D32,#C96511)','icon'=>'🎯','title'=>'OPEN RECRUITMENT WITH','tag'=>'Rekrutmen Anggota','subtitle'=>'Open Recruitment WITH ITH 2026','img'=>'assets/img/with/Open Recruitment  WITH ITH.jpeg'],
];

$programs = [
    ['cat'=>'Kompetisi Bisnis','title'=>'Business Plan Competition','desc'=>'Kompetisi business plan antar mahasiswa — mempresentasikan ide bisnis inovatif di hadapan juri dari kalangan pengusaha dan investor.','icon'=>'💼','color'=>'linear-gradient(135deg,#1B3A1F,#2E7D32)','img'=>'assets/img/with/Business Plan Competition WITH ITH.jpeg'],
    ['cat'=>'Inkubasi Usaha','title'=>'Startup Incubator WITH','desc'=>'Program inkubasi usaha mahasiswa — pendampingan intensif dari ideasi hingga produk yang siap dipasarkan ke masyarakat luas.','icon'=>'🚀','color'=>'linear-gradient(135deg,#C96511,#5C2E0A)','img'=>'assets/img/with/Startup Pitching Day WITH ITH 2026.jpeg'],
    ['cat'=>'Networking & Mentorship','title'=>'Wirausaha Networking Day','desc'=>'Event networking dan mentorship bersama pengusaha sukses alumni ITH — membangun koneksi dan mendapat insight dunia bisnis nyata.','icon'=>'🤝','color'=>'linear-gradient(135deg,#2E7D32,#1B3A1F)','img'=>'assets/img/with/with-1.jpeg'],
];

$contact_email = 'wirausaha@ith.ac.id';

require '_org_template.php';