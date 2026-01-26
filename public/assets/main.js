function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
        mobileMenu.style.display = 'block';
    } else {
        mobileMenu.style.display = 'none';
    }
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    const backdrop = document.getElementById('modalBackdrop');

    backdrop.style.display = 'block';
    modal.style.display = 'block';

    setTimeout(() => {
        backdrop.classList.add('active');
        modal.classList.add('active');
    }, 10);

    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu) mobileMenu.style.display = 'none';
}

function closeAllModals() {
    const modals = document.querySelectorAll('.modal');
    const backdrop = document.getElementById('modalBackdrop');

    modals.forEach(m => m.classList.remove('active'));
    backdrop.classList.remove('active');

    setTimeout(() => {
        modals.forEach(m => m.style.display = 'none');
        backdrop.style.display = 'none';
    }, 300);
}

document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        closeAllModals();
    }
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu) {
                mobileMenu.style.display = 'none';
            }
        }
    });
});

let lastScroll = 0;
window.addEventListener('scroll', () => {
    const nav = document.querySelector('nav');
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
        nav.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.15)';
    } else {
        nav.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
    }

    lastScroll = currentScroll;
});

document.addEventListener('livewire:initialized', () => {
    Livewire.on('close-modal', () => {
        closeAllModals();
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem('sky_lang');
    if (savedLang) {
        changeLanguage(savedLang);
    }
});
