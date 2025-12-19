// src/animations.js

document.addEventListener('DOMContentLoaded', () => {
  initNavbarScroll();
  initHeroAnimation();
  initOptimizedParallax();
  initStaticElementsObserver();
  initDynamicContentObserver();
});

/**
 * 1. Navbar Scroll (Fixed Logic for Smooth Reverse)
 */
function initNavbarScroll() {
  // Target HEADER karena elemen ini yang lebarnya full-screen
  const header = document.querySelector('header');
  let ticking = false;

  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        // Jika scroll lebih dari 10px, tambahkan class
        if (window.scrollY > 10) {
          header.classList.add('nav-scrolled');
        } else {
          // Saat kembali ke atas (scroll < 10), hapus class.
          // Karena di CSS 'header' sudah punya properti 'transition',
          // perubahan warna akan memudar (fade out) secara halus.
          header.classList.remove('nav-scrolled');
        }
        ticking = false;
      });
      ticking = true;
    }
  });
}

/**
 * 2. Parallax Logic
 */
function initOptimizedParallax() {
  const heroImg = document.getElementById('hero-image');
  if (!heroImg) return;

  let ticking = false;
  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        if (window.scrollY < window.innerHeight) {
          heroImg.style.transform = `translate3d(0, ${window.scrollY * 0.3}px, 0)`;
        }
        ticking = false;
      });
      ticking = true;
    }
  });
}

/**
 * 3. Hero Animation
 */
function initHeroAnimation() {
  const elements = [document.querySelector('h1.hotel-name'), document.getElementById('hero-tagline'), document.querySelector('#hero-section a')];

  elements.forEach((el, index) => {
    if (el) {
      el.classList.add('hero-text-animate');
      el.style.animationDelay = `${index * 200}ms`;
    }
  });
}

/**
 * 4. Global Observer Factory
 */
const globalObserver = new IntersectionObserver(
  (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        // Gunakan requestAnimationFrame untuk performa
        window.requestAnimationFrame(() => {
          entry.target.classList.add('is-visible');
        });
        observer.unobserve(entry.target);
      }
    });
  },
  {
    root: null,
    rootMargin: '0px 0px -50px 0px',
    threshold: 0.1,
  }
);

/**
 * 5. Observe Static Elements (FOOTER FIX)
 */
function initStaticElementsObserver() {
  // Target elemen statis umum
  const staticTargets = document.querySelectorAll('h2, #about-description, .hotel-name:not(h1), #booking-section form, #booking-section img');

  staticTargets.forEach((el) => {
    el.classList.add('reveal-on-scroll');
    globalObserver.observe(el);
  });

  // --- FOOTER FIX ---
  // Kita target langsung anak-anak DIV di dalam Grid Footer
  const footerCols = document.querySelectorAll('footer .grid > div');

  footerCols.forEach((col, index) => {
    // Pastikan class animasi ditambahkan
    col.classList.add('reveal-on-scroll');
    // Stagger delay: 0ms, 150ms, 300ms, 450ms
    col.style.transitionDelay = `${index * 150}ms`;
    globalObserver.observe(col);
  });

  // Copyright section
  const copyright = document.querySelector('footer .border-t');
  if (copyright) {
    copyright.classList.add('reveal-on-scroll');
    copyright.style.transitionDelay = '600ms';
    globalObserver.observe(copyright);
  }
}

/**
 * 6. Observe Dynamic Elements
 */
function initDynamicContentObserver() {
  const containers = ['rooms-container', 'facilities-container', 'promotions-container', 'testimonials-container', 'key-highlights-list'];

  const mutationCallback = (mutationsList) => {
    for (const mutation of mutationsList) {
      if (mutation.type === 'childList') {
        mutation.addedNodes.forEach((node) => {
          if (node.nodeType === 1 && node.matches('.room-card, .promo-card, .testimonial-card, .highlight-item, .facility-category')) {
            node.classList.add('reveal-on-scroll');
            const index = Array.from(node.parentNode.children).indexOf(node);
            const delay = index < 5 ? index * 150 : 150;
            node.style.transitionDelay = `${delay}ms`;
            globalObserver.observe(node);
          }
        });
      }
    }
  };

  const domObserver = new MutationObserver(mutationCallback);
  containers.forEach((id) => {
    const container = document.getElementById(id);
    if (container) domObserver.observe(container, { childList: true });
  });
}
