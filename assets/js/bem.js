// NAVBAR SCROLL
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 60);
  updateActiveNav();
});

// HAMBURGER
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');
hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('open');
  navLinks.classList.toggle('open');
});
navLinks.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('click', () => {
    hamburger.classList.remove('open');
    navLinks.classList.remove('open');
  });
});

// ACTIVE NAV
function updateActiveNav() {
  const sections = document.querySelectorAll('section[id]');
  const scrollPos = window.scrollY + 120;
  sections.forEach(section => {
    const link = document.querySelector('.nav-link[href="#' + section.id + '"]');
    if (link) {
      const inView = scrollPos >= section.offsetTop && scrollPos < section.offsetTop + section.offsetHeight;
      link.classList.toggle('active', inView);
    }
  });
}

// PARTICLES
(function createParticles() {
  const container = document.getElementById('particles');
  if (!container) return;
  for (let i = 0; i < 22; i++) {
    const p = document.createElement('div');
    p.className = 'particle';
    const size = Math.random() * 6 + 3;
    p.style.cssText = `
      width:${size}px; height:${size}px;
      left:${Math.random()*100}%;
      top:${Math.random()*100}%;
      --dur:${Math.random()*8+5}s;
      --delay:${Math.random()*8}s;
      animation-delay:${Math.random()*8}s;
    `;
    container.appendChild(p);
  }
})();

// SCROLL ANIMATIONS
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const delay = parseInt(entry.target.dataset.delay || 0);
      setTimeout(() => entry.target.classList.add('animated'), delay);
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));

// CONTACT FORM
document.getElementById('sendBtn').addEventListener('click', () => {
  const name = document.getElementById('fullName').value.trim();
  const email = document.getElementById('emailAddr').value.trim();
  const msg = document.getElementById('message').value.trim();
  const btn = document.getElementById('sendBtn');
  const success = document.getElementById('formSuccess');

  if (!name || !email || !msg) {
    alert('Mohon isi nama, email, dan pesan terlebih dahulu.');
    return;
  }

  btn.textContent = 'Mengirim...';
  btn.disabled = true;
  setTimeout(() => {
    btn.textContent = 'SEND A MESSAGE';
    btn.disabled = false;
    success.classList.add('show');
    ['fullName','emailAddr','phone','subject','message'].forEach(id => {
      document.getElementById(id).value = '';
    });
    setTimeout(() => success.classList.remove('show'), 5000);
  }, 1500);
});