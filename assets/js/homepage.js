// homepage.js — ORC ORMAWA ITH

document.addEventListener('DOMContentLoaded', () => {

    // ── 1. SCROLL REVEAL ──────────────────────────────────────
    const revealEls = document.querySelectorAll('[data-reveal]');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('revealed'), i * 120);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    revealEls.forEach(el => observer.observe(el));

    // ── 2. CAROUSEL SCROLL ────────────────────────────────────
    const scroll    = document.getElementById('orgsScroll');
    const btnLeft   = document.getElementById('scrollBtnLeft');
    const btnRight  = document.getElementById('scrollBtnRight');
    const dots      = document.querySelectorAll('.scroll-dot');
    const STEP      = 284;

    function updateButtons() {
        if (!scroll) return;
        btnLeft.disabled  = scroll.scrollLeft < 10;
        btnRight.disabled = scroll.scrollLeft + scroll.clientWidth >= scroll.scrollWidth - 10;
    }

    function updateDots() {
        if (!scroll || !dots.length) return;
        const idx = Math.round(scroll.scrollLeft / STEP);
        dots.forEach((d, i) => d.classList.toggle('active', i === idx));
    }

    if (btnLeft)  btnLeft.addEventListener('click', () => { scroll.scrollBy({ left: -STEP, behavior: 'smooth' }); });
    if (btnRight) btnRight.addEventListener('click', () => { scroll.scrollBy({ left: STEP,  behavior: 'smooth' }); });
    if (scroll)   scroll.addEventListener('scroll', () => { updateButtons(); updateDots(); });

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            scroll.scrollTo({ left: i * STEP, behavior: 'smooth' });
        });
    });

    updateButtons();

    // ── 3. HAMBURGER ──────────────────────────────────────────
    const ham = document.getElementById('hamburgerBtn');
    const nav = document.getElementById('navLinks');
    if (ham && nav) {
        ham.addEventListener('click', () => {
            const open = nav.classList.toggle('open');
            ham.setAttribute('aria-expanded', open);
        });
    }

    // ── 4. COUNTER ANIMATION ──────────────────────────────────
    function animateCount(el) {
        const target = parseInt(el.dataset.count, 10);
        const suffix = el.dataset.suffix || '';
        const duration = 1200;
        const start = performance.now();
        const update = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(ease * target) + suffix;
            if (progress < 1) requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
    }

    const statNums = document.querySelectorAll('.stat-number[data-count]');
    const statsObs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCount(entry.target);
                statsObs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    statNums.forEach(n => statsObs.observe(n));

    // ── 5. SMOOTH ANCHOR SCROLL ───────────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const id = a.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
