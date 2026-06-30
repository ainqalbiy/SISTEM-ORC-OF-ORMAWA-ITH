<?php
// pages/organisasi/aratta.php — ARATTA ITH
$current_page  = 'aratta';
$page_title    = 'ARATTA ITH — UKM Seni Art & Talent';

$org_slug      = 'ARATTA';
$org_name      = 'ARATTA ITH';
$org_full      = 'UKM Seni Art & Talent';
$org_year      = '2026';
$org_tagline   = 'Seni, Bakat &<br>Kreativitas ITH';
$org_about_1   = 'UKM Seni Art & Talent (ARATTA) adalah unit kegiatan mahasiswa yang menjadi wadah pengembangan minat, kreativitas, dan bakat mahasiswa Institut Teknologi Habibie di bidang seni dan hiburan.';
$org_about_2   = 'ARATTA hadir untuk memfasilitasi ekspresi kreatif mahasiswa — dari teater, musik, tari, hingga seni visual — menciptakan ruang berkarya yang menginspirasi dan mempererat persatuan kampus.';
$org_tags      = ['Seni Pertunjukan','Musik','Tari','Teater','Seni Visual','Kreativitas'];

$org_vision    = '"ARATTA ITH adalah <em>panggung kreativitas</em> mahasiswa — tempat di mana bakat diasah, karya dilahirkan, dan jiwa seni tumbuh bersama semangat kolaborasi yang hangat.\"';
$org_logo_fallback = 'ARATTA';

$hero_grad_l   = '#3E1A47';
$hero_grad_r   = '#C96511';

$poster_l_grad = 'linear-gradient(160deg,#3E1A47,#7B2D8B)';
$poster_l_label = 'FESTIVAL SENI<br>ITH 2026';
$poster_r_grad = 'linear-gradient(160deg,#C96511,#5C2E0A)';
$poster_r_label = 'ARATTA ITH 2026';

$org_collage = [
    ['class'=>'tall','img'=>'assets/img/aratta/festival_seni.jpeg','grad'=>'linear-gradient(160deg,#3E1A47,#7B2D8B)','icon'=>'🎭','label'=>'Festival Seni'],
    ['class'=>'',    'img'=>'assets/img/aratta/pentas_musik.jpeg','grad'=>'linear-gradient(160deg,#C96511,#5C2E0A)','icon'=>'🎵','label'=>'Pentas Musik'],
    ['class'=>'',    'img'=>'assets/img/aratta/pameran_karya.jpeg','grad'=>'linear-gradient(160deg,#7B2D8B,#3E1A47)','icon'=>'🎨','label'=>'Pameran Karya'],
];

$org_posters = [
    ['grad'=>'linear-gradient(160deg,#3E1A47,#7B2D8B)','icon'=>'🎭','title'=>'FESTIVAL SENI ITH 2026','tag'=>'Festival Seni','subtitle'=>'Festival Seni Tahunan ARATTA ITH'],
    ['grad'=>'linear-gradient(160deg,#C96511,#5C2E0A)','icon'=>'🎵','title'=>'PENTAS SENI & MUSIK','tag'=>'Pertunjukan','subtitle'=>'Pentas Seni & Musik Kampus ITH'],
    ['grad'=>'linear-gradient(160deg,#7B2D8B,#C96511)','icon'=>'🎯','title'=>'OPEN RECRUITMENT ARATTA','tag'=>'Rekrutmen Anggota','subtitle'=>'Open Recruitment ARATTA ITH 2026'],
];

$programs = [
    ['cat'=>'Festival Tahunan','title'=>'Festival Seni ITH','desc'=>'Festival seni tahunan yang menampilkan pertunjukan teater, musik, tari tradisional dan modern, serta pameran karya visual mahasiswa.','icon'=>'🎭','color'=>'linear-gradient(135deg,#3E1A47,#7B2D8B)'],
    ['cat'=>'Pertunjukan Musik','title'=>'Pentas Musik Kampus','desc'=>'Konser dan pentas musik rutin yang memberikan panggung bagi mahasiswa berbakat untuk tampil dan berkolaborasi bersama.','icon'=>'🎵','color'=>'linear-gradient(135deg,#C96511,#5C2E0A)'],
    ['cat'=>'Seni Visual','title'=>'Pameran Karya Visual','desc'=>'Pameran karya seni visual mahasiswa — fotografi, ilustrasi, desain grafis, dan instalasi seni yang dipamerkan untuk civitas kampus.','icon'=>'🎨','color'=>'linear-gradient(135deg,#7B2D8B,#3E1A47)'],
];

$contact_email = 'aratta@ith.ac.id';

require '_org_template.php';