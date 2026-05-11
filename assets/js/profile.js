// MENU ACTIVE
const menuItems = document.querySelectorAll(".menu li");

menuItems.forEach(item => {
    item.addEventListener("click", () => {

        menuItems.forEach(i => {
            i.classList.remove("active");
        });

        item.classList.add("active");

    });
});

// BUTTON EDIT
const editBtn = document.querySelector(".edit-btn");

editBtn.addEventListener("click", () => {
    alert("Menu Edit Profil");
});

// BUTTON PASSWORD
const passBtn = document.querySelector(".pass-btn");

passBtn.addEventListener("click", () => {
    alert("Menu Ganti Password");
});

// LOGOUT
const logoutBtn = document.querySelector(".logout-btn");

logoutBtn.addEventListener("click", () => {

    let konfirmasi = confirm("Yakin ingin logout?");

    if(konfirmasi){
        window.location.href = "logout.php";
    }

});