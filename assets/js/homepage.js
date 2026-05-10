/* ========================================
   homepage.js — Homepage JavaScript
   ORC ORMAWA ITH
======================================== */

document.addEventListener('DOMContentLoaded', function () {

    /* ----------------------------------------
       HORIZONTAL CARD SCROLL (Drag + Buttons)
    ---------------------------------------- */
    const scrollContainer = document.querySelector('.orgs-scroll-container');
    const btnLeft  = document.querySelector('.scroll-btn.left');
    const btnRight = document.querySelector('.scroll-btn.right');
    const dots     = document.querySelectorAll('.scroll-dot');

    if (scrollContainer) {
        const CARD_WIDTH = 300 + 20; // card min-width + gap

        // Arrow button scroll
        if (btnLeft) {
            btnLeft.addEventListener('click', function () {
                scrollContainer.scrollBy({ left: -CARD_WIDTH, behavior: 'smooth' });
            });
        }
        if (btnRight) {
            btnRight.addEventListener('click', function () {
                scrollContainer.scrollBy({ left: CARD_WIDTH, behavior: 'smooth' });
            });
        }

        // Update dots & button state on scroll
        function updateScrollState() {
            const scrollLeft = scrollContainer.scrollLeft;
            const maxScroll  = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            const progress   = maxScroll > 0 ? scrollLeft / maxScroll : 0;

            if (btnLeft)  btnLeft.disabled  = scrollLeft <= 4;
            if (btnRight) btnRight.disabled = scrollLeft >= maxScroll - 4;

            if (dots.length > 0) {
                const activeIndex = Math.round(progress * (dots.length - 1));
                dots.forEach(function (dot, i) {
                    dot.classList.toggle('active', i === activeIndex);
                });
            }
        }

        scrollContainer.addEventListener('scroll', updateScrollState, { passive: true });
        updateScrollState(); // init

        // Dot click scroll
        dots.forEach(function (dot, i) {
            dot.addEventListener('click', function () {
                const totalCards = scrollContainer.querySelectorAll('.org-card').length;
                const maxScroll  = scrollContainer.scrollWidth - scrollContainer.clientWidth;
                const target     = (i / (dots.length - 1)) * maxScroll;
                scrollContainer.scrollTo({ left: target, behavior: 'smooth' });
            });
        });

        /* ---- DRAG TO SCROLL ---- */
        let isDragging = false;
        let startX;
        let startScrollLeft;

        scrollContainer.addEventListener('mousedown', function (e) {
            isDragging     = true;
            startX         = e.pageX - scrollContainer.offsetLeft;
            startScrollLeft = scrollContainer.scrollLeft;
            scrollContainer.style.userSelect = 'none';
        });

        document.addEventListener('mouseup', function () {
            isDragging = false;
            scrollContainer.style.userSelect = '';
        });

        scrollContainer.addEventListener('mousemove', function (e) {
            if (!isDragging) return;
            e.preventDefault();
            const x    = e.pageX - scrollContainer.offsetLeft;
            const walk = (x - startX) * 1.4;
            scrollContainer.scrollLeft = startScrollLeft - walk;
        });

        /* ---- TOUCH SWIPE ---- */
        let touchStartX    = 0;
        let touchScrollLeft = 0;

        scrollContainer.addEventListener('touchstart', function (e) {
            touchStartX     = e.touches[0].clientX;
            touchScrollLeft = scrollContainer.scrollLeft;
        }, { passive: true });

        scrollContainer.addEventListener('touchmove', function (e) {
            const dx = touchStartX - e.touches[0].clientX;
            scrollContainer.scrollLeft = touchScrollLeft + dx;
        }, { passive: true });
    }

    /* ----------------------------------------
       COUNTER ANIMATION (Stats)
    ---------------------------------------- */
    function animateCounter(el, target, suffix) {
        const duration = 1400;
        const start    = performance.now();
        const from     = 0;

        function step(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased    = 1 - Math.pow(1 - progress, 3); // ease-out cubic
            const value    = Math.round(from + (target - from) * eased);
            el.textContent = value + suffix;
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    const statNumbers = document.querySelectorAll('.stat-number[data-count]');
    if (statNumbers.length && 'IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const el     = entry.target;
                    const target = parseInt(el.dataset.count, 10);
                    const suffix = el.dataset.suffix || '+';
                    animateCounter(el, target, suffix);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(function (el) { counterObserver.observe(el); });
    }

    /* ----------------------------------------
       SEARCH FORM
    ---------------------------------------- */
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const query    = document.getElementById('searchInput').value.trim();
            const category = document.getElementById('categorySelect').value;
            const params   = new URLSearchParams();
            if (query)    params.set('q', query);
            if (category) params.set('kategori', category);
            window.location.href = 'pages/organisasi/organisasi.php?' + params.toString();
        });
    }

});