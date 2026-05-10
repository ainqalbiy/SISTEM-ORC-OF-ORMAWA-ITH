/* ========================================
   main.js — Global JavaScript
   ORC ORMAWA ITH
======================================== */

document.addEventListener('DOMContentLoaded', function () {

    /* ----------------------------------------
       HAMBURGER / MOBILE NAV TOGGLE
    ---------------------------------------- */
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const navLinks     = document.getElementById('navLinks');

    if (hamburgerBtn && navLinks) {
        hamburgerBtn.addEventListener('click', function () {
            navLinks.classList.toggle('open');
            const isOpen = navLinks.classList.contains('open');
            hamburgerBtn.setAttribute('aria-expanded', isOpen);
            // Animate bars
            const bars = hamburgerBtn.querySelectorAll('span');
            if (isOpen) {
                bars[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                bars[1].style.opacity = '0';
                bars[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
            } else {
                bars[0].style.transform = '';
                bars[1].style.opacity = '';
                bars[2].style.transform = '';
            }
        });

        // Close nav on outside click
        document.addEventListener('click', function (e) {
            if (!hamburgerBtn.contains(e.target) && !navLinks.contains(e.target)) {
                navLinks.classList.remove('open');
                const bars = hamburgerBtn.querySelectorAll('span');
                bars[0].style.transform = '';
                bars[1].style.opacity = '';
                bars[2].style.transform = '';
            }
        });
    }

    /* ----------------------------------------
       SIDEBAR TOGGLE
    ---------------------------------------- */
    const sidebar        = document.getElementById('sidebar');
    const sidebarClose   = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        if (sidebar)        sidebar.classList.add('open');
        if (sidebarOverlay) sidebarOverlay.classList.add('visible');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        if (sidebar)        sidebar.classList.remove('open');
        if (sidebarOverlay) sidebarOverlay.classList.remove('visible');
        document.body.style.overflow = '';
    }

    if (sidebarClose)   sidebarClose.addEventListener('click', closeSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

    // Expose for use in page-specific scripts
    window.openSidebar  = openSidebar;
    window.closeSidebar = closeSidebar;

    /* ----------------------------------------
       SCROLL REVEAL (Intersection Observer)
    ---------------------------------------- */
    const revealEls = document.querySelectorAll('[data-reveal]');
    if (revealEls.length && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        revealEls.forEach(function (el) {
            el.classList.add('reveal-ready');
            revealObserver.observe(el);
        });
    }

    /* ----------------------------------------
       SMOOTH ACTIVE NAV LINK (hash-based)
    ---------------------------------------- */
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-links a').forEach(function (link) {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

});