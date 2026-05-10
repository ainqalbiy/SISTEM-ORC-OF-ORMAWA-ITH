// ================================
// ACTIVE MENU SIDEBAR
// ================================

const menus = document.querySelectorAll('.menu');

menus.forEach(menu => {

    menu.addEventListener('click', () => {

        // hapus active sebelumnya
        menus.forEach(item => {
            item.classList.remove('active');
        });

        // tambahkan active baru
        menu.classList.add('active');

    });

});


// ================================
// BUTTON HOVER EFFECT
// ================================

const buttons = document.querySelectorAll('.btn');

buttons.forEach(button => {

    button.addEventListener('mouseenter', () => {

        button.style.transform = 'scale(1.03)';
        button.style.transition = '0.3s ease';

    });

    button.addEventListener('mouseleave', () => {

        button.style.transform = 'scale(1)';

    });

});


// ================================
// CARD HOVER EFFECT
// ================================

const cards = document.querySelectorAll('.card');

cards.forEach(card => {

    card.addEventListener('mouseenter', () => {

        card.style.transform = 'translateY(-5px)';
        card.style.transition = '0.3s ease';
        card.style.boxShadow = '0 8px 20px rgba(0,0,0,0.08)';

    });

    card.addEventListener('mouseleave', () => {

        card.style.transform = 'translateY(0)';
        card.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';

    });

});


// ================================
// SEARCH DOKUMEN
// ================================

const searchInput = document.querySelector('.card-header input');
const tableRows = document.querySelectorAll('tbody tr');

if(searchInput){

    searchInput.addEventListener('keyup', () => {

        let value = searchInput.value.toLowerCase();

        tableRows.forEach(row => {

            let text = row.innerText.toLowerCase();

            if(text.includes(value)){
                row.style.display = '';
            }else{
                row.style.display = 'none';
            }

        });

    });

}


// ================================
// ANIMASI SAAT LOAD
// ================================

window.addEventListener('load', () => {

    const profileCard = document.querySelector('.profile-card');
    const grid = document.querySelector('.grid');

    profileCard.style.opacity = '0';
    profileCard.style.transform = 'translateY(30px)';

    grid.style.opacity = '0';
    grid.style.transform = 'translateY(30px)';

    setTimeout(() => {

        profileCard.style.transition = '0.6s ease';
        profileCard.style.opacity = '1';
        profileCard.style.transform = 'translateY(0)';

    }, 200);

    setTimeout(() => {

        grid.style.transition = '0.8s ease';
        grid.style.opacity = '1';
        grid.style.transform = 'translateY(0)';

    }, 400);

});


// ================================
// CLICK SETTING ITEM
// ================================

const settingItems = document.querySelectorAll('.setting-item');

settingItems.forEach(item => {

    item.addEventListener('click', () => {

        item.style.background = '#f5f5f5';

        setTimeout(() => {
            item.style.background = 'white';
        }, 200);

    });

});


// ================================
// LOGOUT BUTTON EFFECT
// ================================

const logoutBtn = document.querySelector('.logout-btn');

logoutBtn.addEventListener('mouseenter', () => {

    logoutBtn.style.transform = 'translateX(-50%) scale(1.03)';
    logoutBtn.style.transition = '0.3s';

});

logoutBtn.addEventListener('mouseleave', () => {

    logoutBtn.style.transform = 'translateX(-50%) scale(1)';

});


// ================================
// MINI PROFILE DROPDOWN EFFECT
// ================================

const miniProfile = document.querySelector('.mini-profile');

miniProfile.addEventListener('mouseenter', () => {

    miniProfile.style.opacity = '0.8';
    miniProfile.style.transition = '0.3s';

});

miniProfile.addEventListener('mouseleave', () => {

    miniProfile.style.opacity = '1';

});


// ================================
// TABLE ROW HOVER
// ================================

tableRows.forEach(row => {

    row.addEventListener('mouseenter', () => {

        row.style.background = '#fafafa';
        row.style.transition = '0.2s';

    });

    row.addEventListener('mouseleave', () => {

        row.style.background = 'white';

    });

});


// ================================
// RESPONSIVE SIDEBAR AUTO CLOSE
// ================================

function checkScreen(){

    if(window.innerWidth < 768){

        document.querySelector('.sidebar').style.width = '100%';

    }

}

window.addEventListener('resize', checkScreen);

checkScreen();