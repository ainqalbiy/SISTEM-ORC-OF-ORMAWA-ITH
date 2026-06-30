<?php
// pages/organisasi/hero.php — HERO ITH
$current_page  = 'hero';
$page_title    = 'HERO ITH — Habibie Engineering Robotic of Organization';

$org_slug      = 'HERO';
$org_name      = 'HERO ITH';
$org_full      = 'Habibie Engineering Robotic of Organization';
$org_year      = '2026';
$org_tagline   = 'Inovasi Robotika &<br>Teknologi ITH';
$org_about_1   = 'Habibie Engineering Robotic of Organization (HERO) adalah organisasi mahasiswa yang berfokus pada pengembangan teknologi robotika, Internet of Things (IoT), dan inovasi di bidang engineering di lingkungan Institut Teknologi Habibie.';
$org_about_2   = 'HERO berkomitmen mencetak mahasiswa yang kompeten di bidang teknologi, mampu berkompetisi di tingkat nasional, dan berkontribusi nyata dalam perkembangan dunia teknik dan robotika Indonesia.';
$org_tags      = ['Robotika','IoT','Engineering','Kompetisi Nasional','Teknologi','Inovasi'];

$org_vision    = '"HERO ITH adalah <em>laboratorium hidup</em> bagi mahasiswa yang ingin menguasai teknologi robotika, IoT, dan engineering — mencetak inovator yang siap bersaing di era industri 4.0."';
$org_logo_fallback = 'HERO';

$hero_grad_l   = '#0D1B2A';
$hero_grad_r   = '#B85C00';

$poster_l_grad = 'linear-gradient(160deg,#1a3a5c,#0D1B2A)';
$poster_l_label = 'HABIBIE ROBOTIC<br>COMPETITION';
$poster_l_img  = 'assets/img/hero/poster-kiri.jpeg';   // ganti dengan foto Anda
$poster_r_grad = 'linear-gradient(160deg,#B85C00,#5C2E0A)';
$poster_r_label = 'HERO ITH 2026';
$poster_r_img  = 'assets/img/hero/poster-kanan.jpeg';  // ganti dengan foto Anda

$org_collage = [
    ['class'=>'tall','grad'=>'linear-gradient(160deg,#1a3a5c,#0D1B2A)','icon'=>'🤖','label'=>'Robot Competition','img'=>'assets/img/hero/collage-1.jpeg'],
    ['class'=>'',    'grad'=>'linear-gradient(160deg,#B85C00,#5C2E0A)','icon'=>'⚙️','label'=>'Workshop IoT','img'=>'assets/img/hero/collage-2.jpeg'],
    ['class'=>'',    'grad'=>'linear-gradient(160deg,#2d5986,#1a3a5c)','icon'=>'💡','label'=>'Inovasi Teknik','img'=>'assets/img/hero/collage-3.jpeg'],
];

$org_posters = [
    ['grad'=>'linear-gradient(160deg,#0D1B2A,#1a3a5c)','icon'=>'🤖','title'=>'HABIBIE ROBOTIC COMPETITION','tag'=>'Kompetisi Robotik','subtitle'=>'Habibie Robotic Competition 2025','img'=>'assets/img/hero/poster-robotic.jpeg'],
    ['grad'=>'linear-gradient(160deg,#B85C00,#5C2E0A)','icon'=>'⚙️','title'=>'WORKSHOP IOT & PROGRAMMING','tag'=>'Workshop Teknologi','subtitle'=>'Workshop IoT & Programming HERO','img'=>'assets/img/hero/poster-workshop.jpeg'],
    ['grad'=>'linear-gradient(160deg,#1a3a5c,#B85C00)','icon'=>'🎯','title'=>'OPEN RECRUITMENT HERO','tag'=>'Rekrutmen Anggota','subtitle'=>'Open Recruitment HERO ITH 2026','img'=>'assets/img/hero/poster-recruitment.jpeg'],
];

$programs = [
    ['cat'=>'Kompetisi Robotik','title'=>'Habibie Robotic Competition','desc'=>'Kompetisi robotik bergengsi tingkat nasional yang diselenggarakan HERO ITH, mengundang tim dari berbagai universitas.','icon'=>'🤖','color'=>'linear-gradient(135deg,#0D1B2A,#1a3a5c)','img'=>'assets/img/hero/program-robotic.jpeg'],
    ['cat'=>'Pengembangan Skill','title'=>'Workshop IoT & Programming','desc'=>'Workshop intensif pengembangan skill Internet of Things, embedded systems, dan programming untuk mahasiswa teknik.','icon'=>'⚙️','color'=>'linear-gradient(135deg,#B85C00,#5C2E0A)','img'=>'assets/img/hero/program-workshop.jpeg'],
    ['cat'=>'Inovasi Teknologi','title'=>'Pameran Karya Teknologi','desc'=>'Pameran karya inovasi teknologi mahasiswa — menampilkan prototipe robot, smart device, dan solusi IoT terbaik.','icon'=>'💡','color'=>'linear-gradient(135deg,#1a3a5c,#B85C00)','img'=>'assets/img/hero/program-inovasi.jpeg'],
];

$contact_email = 'hero@ith.ac.id';

require '_org_template.php';