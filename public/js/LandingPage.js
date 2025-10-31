document.addEventListener('DOMContentLoaded', () => {
    // ------------------------------------
    // 1. Logika Navbar Responsif (Mobile Menu)
    // ------------------------------------
    const mobileMenu = document.getElementById('mobileMenu');
    const navLinks = document.getElementById('navLinks');

    mobileMenu.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        // Tambahkan logika untuk mengubah ikon menu jika perlu (misal: X)
    });

    // ------------------------------------
    // 2. Logika Slider Gambar Aplikasi
    // ------------------------------------
    const slider = document.getElementById('appSlider');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const dotsContainer = document.getElementById('sliderDots');

    let currentIndex = 0;
    const totalSlides = slides.length;

    // Fungsi untuk memindahkan slider
    function goToSlide(index) {
        slider.style.transform = `translateX(${-index * 100}%)`;
        currentIndex = index;
        updateDots();
    }

    // Fungsi untuk pindah ke slide berikutnya
    function nextSlide() {
        currentIndex = (currentIndex === totalSlides - 1) ? 0 : currentIndex + 1;
        goToSlide(currentIndex);
    }

    // Fungsi untuk pindah ke slide sebelumnya
    function prevSlide() {
        currentIndex = (currentIndex === 0) ? totalSlides - 1 : currentIndex - 1;
        goToSlide(currentIndex);
    }

    // Event listeners untuk tombol
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    // Fungsi untuk membuat dan mengupdate dots
    function createDots() {
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            dot.setAttribute('data-index', i);
            dot.addEventListener('click', () => {
                goToSlide(i);
            });
            dotsContainer.appendChild(dot);
        }
    }

    function updateDots() {
        document.querySelectorAll('.dot').forEach(dot => {
            dot.classList.remove('active');
        });
        document.querySelector(`.dot[data-index="${currentIndex}"]`).classList.add('active');
    }

    // Inisialisasi Slider
    createDots();
    updateDots();

    // Opsional: Auto-play slider setiap 5 detik
    setInterval(nextSlide, 5000);
});