// src/splash.js

/**
 * Fungsi untuk menghilangkan Splash Screen dengan efek fade-out yang halus.
 * Dipanggil saat data selesai dimuat.
 */
export function hideSplashScreen() {
    const splash = document.getElementById('splash-screen');
    
    if (splash) {
        // 1. Tambahkan class opacity-0 untuk memicu transisi CSS
        splash.classList.add('opacity-0');
        
        // 2. Tambahkan pointer-events-none agar user bisa langsung klik elemen di belakangnya 
        // meskipun animasi fade-out belum 100% selesai
        splash.classList.add('pointer-events-none');

        // 3. Hapus elemen dari DOM setelah transisi selesai (700ms sesuai class duration-700 di HTML)
        setTimeout(() => {
            splash.remove();
            
            // Opsional: Memicu animasi elemen lain (jika ada di animations.js)
            // document.dispatchEvent(new Event('splashHidden')); 
        }, 800); // Beri sedikit buffer waktu (800ms)
    }
}