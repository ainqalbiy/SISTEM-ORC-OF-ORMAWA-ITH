/* =======================================
   ORC ORMAWA ITH — Main JavaScript
======================================= */

document.addEventListener('DOMContentLoaded', () => {

  /* ----------------------------------------
     1. HAMBURGER / MOBILE NAV
  ---------------------------------------- */
  const hamburger = document.getElementById('hamburger');
  const mobileNav = document.getElementById('mobileNav');

  if (hamburger && mobileNav) {
    hamburger.addEventListener('click', () => {
      mobileNav.classList.toggle('open');
      // Animate hamburger icon
      const spans = hamburger.querySelectorAll('span');
      if (mobileNav.classList.contains('open')) {
        spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
        spans[1].style.opacity = '0';
        spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
      } else {
        spans[0].style.transform = '';
        spans[1].style.opacity = '';
        spans[2].style.transform = '';
      }
    });

    // Close mobile nav on link click
    mobileNav.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileNav.classList.remove('open');
        hamburger.querySelectorAll('span').forEach(s => {
          s.style.transform = '';
          s.style.opacity = '';
        });
      });
    });
  }


  /* ----------------------------------------
     2. HORIZONTAL CARD SLIDER
  ---------------------------------------- */
  const track = document.getElementById('sliderTrack');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const dotsContainer = document.getElementById('sliderDots');

  if (!track || !prevBtn || !nextBtn) return;

  const cards = track.querySelectorAll('.org-card');
  const totalCards = cards.length;
  let currentIndex = 0;

  // How many cards visible per view (responsive)
  function getVisibleCount() {
    const width = window.innerWidth;
    if (width >= 1200) return 3;
    if (width >= 860) return 2;
    return 1;
  }

  // Get card width + gap dynamically
  function getCardWidth() {
    if (cards.length === 0) return 0;
    const card = cards[0];
    const style = window.getComputedStyle(track);
    const gap = parseInt(style.gap) || 24;
    return card.offsetWidth + gap;
  }

  // Total steps possible
  function getMaxIndex() {
    return Math.max(0, totalCards - getVisibleCount());
  }

  // Build dots
  function buildDots() {
    dotsContainer.innerHTML = '';
    const max = getMaxIndex();
    for (let i = 0; i <= max; i++) {
      const dot = document.createElement('button');
      dot.className = 'slider-dot' + (i === currentIndex ? ' active' : '');
      dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
      dot.addEventListener('click', () => goTo(i));
      dotsContainer.appendChild(dot);
    }
  }

  function updateDots() {
    const dots = dotsContainer.querySelectorAll('.slider-dot');
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === currentIndex);
    });
  }

  function updateButtons() {
    prevBtn.disabled = currentIndex === 0;
    nextBtn.disabled = currentIndex >= getMaxIndex();
  }

  function goTo(index) {
    const max = getMaxIndex();
    currentIndex = Math.max(0, Math.min(index, max));
    const offset = currentIndex * getCardWidth();
    track.style.transform = `translateX(-${offset}px)`;
    updateButtons();
    updateDots();
  }

  prevBtn.addEventListener('click', () => goTo(currentIndex - 1));
  nextBtn.addEventListener('click', () => goTo(currentIndex + 1));

  // Touch/swipe support
  let touchStartX = 0;
  let touchEndX = 0;

  track.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].clientX;
  }, { passive: true });

  track.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].clientX;
    const diff = touchStartX - touchEndX;
    if (Math.abs(diff) > 40) {
      if (diff > 0) goTo(currentIndex + 1);
      else goTo(currentIndex - 1);
    }
  }, { passive: true });

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') goTo(currentIndex - 1);
    if (e.key === 'ArrowRight') goTo(currentIndex + 1);
  });

  // Auto-play slider
  let autoPlay = setInterval(() => {
    if (currentIndex >= getMaxIndex()) {
      goTo(0);
    } else {
      goTo(currentIndex + 1);
    }
  }, 4000);

  // Pause auto-play on hover
  track.addEventListener('mouseenter', () => clearInterval(autoPlay));
  track.addEventListener('mouseleave', () => {
    autoPlay = setInterval(() => {
      if (currentIndex >= getMaxIndex()) {
        goTo(0);
      } else {
        goTo(currentIndex + 1);
      }
    }, 4000);
  });

  // Rebuild on resize
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      goTo(Math.min(currentIndex, getMaxIndex()));
      buildDots();
    }, 200);
  });

  // Init
  buildDots();
  updateButtons();


  /* ----------------------------------------
     3. SCROLL REVEAL ANIMATIONS
  ---------------------------------------- */
  const revealEls = document.querySelectorAll(
    '.org-card, .testi-card, .stat-card, .temukan-container, .search-container'
  );

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  revealEls.forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(28px)';
    el.style.transition = `opacity 0.55s ease ${i * 0.07}s, transform 0.55s ease ${i * 0.07}s`;
    observer.observe(el);
  });


  /* ----------------------------------------
     4. ACTIVE NAV LINK (scroll spy lite)
  ---------------------------------------- */
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', function () {
      navLinks.forEach(l => l.classList.remove('active'));
      this.classList.add('active');
    });
  });


  /* ----------------------------------------
     5. SEARCH BUTTON — simple filter feedback
  ---------------------------------------- */
  const exploreBtn = document.querySelector('.btn-explore');
  const searchInput = document.querySelector('.search-input');

  if (exploreBtn && searchInput) {
    exploreBtn.addEventListener('click', () => {
      const query = searchInput.value.trim();
      if (query) {
        exploreBtn.textContent = 'Mencari...';
        exploreBtn.style.opacity = '0.75';
        setTimeout(() => {
          exploreBtn.textContent = 'Explore';
          exploreBtn.style.opacity = '1';
          // Scroll to org section
          document.querySelector('.orgs-section')?.scrollIntoView({ behavior: 'smooth' });
        }, 800);
      } else {
        document.querySelector('.orgs-section')?.scrollIntoView({ behavior: 'smooth' });
      }
    });

    searchInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') exploreBtn.click();
    });
  }


  /* ----------------------------------------
     6. NAVBAR SHADOW ON SCROLL
  ---------------------------------------- */
  const navbar = document.querySelector('.navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
      navbar.style.boxShadow = '0 4px 24px rgba(0,0,0,0.13)';
    } else {
      navbar.style.boxShadow = '0 2px 16px rgba(0,0,0,0.08)';
    }
  });

});