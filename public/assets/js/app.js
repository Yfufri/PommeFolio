(function () {
    const STORAGE_KEY = 'portfolio-theme';

    function applyTheme(isDark) {
        if (isDark) {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }

        const switchEl = document.querySelector('.darkmode-switch');
        if (switchEl) {
            if (isDark) {
                switchEl.classList.add('is-on');
            } else {
                switchEl.classList.remove('is-on');
            }
        }
    }

    function initDarkMode() {
        const saved = localStorage.getItem(STORAGE_KEY);
        let isDark = saved === 'dark';

        if (saved === null) {
            isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        applyTheme(isDark);

        // On utilise la délégation d'événement pour le switch (plus robuste)
        document.addEventListener('click', (e) => {
            const switchEl = e.target.closest('.darkmode-switch');
            if (switchEl) {
                isDark = !document.body.classList.contains('dark');
                applyTheme(isDark);
                localStorage.setItem(STORAGE_KEY, isDark ? 'dark' : 'light');
            }
        });
    }

    function initLightbox() {
        let overlay = document.querySelector('.lightbox-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.classList.add('lightbox-overlay');
            overlay.innerHTML = '<img src="" alt="Agrandissement">';
            document.body.appendChild(overlay);
        }

        const overlayImg = overlay.querySelector('img');

        document.addEventListener('click', (e) => {
            const img = e.target.closest('.illu-thumb img, .illu-card img, .voyage-paris-item img');
            if (img) {
                overlayImg.src = img.src;
                overlay.classList.add('is-active');
                document.body.style.overflow = 'hidden';
            }
        });

        overlay.addEventListener('click', () => {
            overlay.classList.remove('is-active');
            document.body.style.overflow = '';
        });
    }

    function initCardAnimations() {
        const animatedCards = document.querySelectorAll('.card, .card-big, .culture-card, .ac-card, .admin-card');
        animatedCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(12px)';
            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                setTimeout(() => {
                    card.style.opacity = '';
                    card.style.transform = '';
                    card.style.transition = '';
                }, 500);
            }, 80 + index * 70);
        });
    }

    function initHeroParallax() {
        const hero = document.querySelector('.hero');
        if (!hero) return;
        window.addEventListener('scroll', () => {
            hero.style.transform = `translateY(${window.scrollY * 0.08}px)`;
        });
    }

    function initButExplorerVue() {
        const explorerEl = document.getElementById('but-explorer');
        if (!explorerEl || typeof Vue === 'undefined') return;
        // ... (Ton code VueJS reste identique ici)
    }

    // UN SEUL DOMContentLoaded à la fin
    document.addEventListener('DOMContentLoaded', () => {
        initDarkMode();
        initCardAnimations();
        initHeroParallax();
        initButExplorerVue();
        initLightbox();
    });
})();