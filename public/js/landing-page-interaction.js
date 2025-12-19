document.addEventListener('DOMContentLoaded', () => {
  // Ambil elemen
  const menuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuIcon = document.getElementById('mobile-menu-icon');

  // Cek apakah elemen ada (untuk menghindari error)
  if (menuBtn && mobileMenu && menuIcon) {
    menuBtn.addEventListener('click', () => {
      // 1. Toggle class 'hidden' untuk menampilkan/menyembunyikan menu
      mobileMenu.classList.toggle('hidden');

      // 2. Ganti ikon (Opsional: Menu <-> Silang/X)
      if (mobileMenu.classList.contains('hidden')) {
        // Jika menu tertutup, tampilkan ikon hamburger
        menuIcon.classList.remove('ri-close-line');
        menuIcon.classList.add('ri-menu-line');
      } else {
        // Jika menu terbuka, tampilkan ikon silang (X)
        menuIcon.classList.remove('ri-menu-line');
        menuIcon.classList.add('ri-close-line');
      }
    });
  }
});
