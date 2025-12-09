// public/assets/js/darkmode.js

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
            // Préférence système
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            isDark = prefersDark;
        }

        applyTheme(isDark);

        const switchEl = document.querySelector('.darkmode-switch');
        if (switchEl) {
            switchEl.addEventListener('click', () => {
                isDark = !document.body.classList.contains('dark');
                applyTheme(isDark);
                localStorage.setItem(STORAGE_KEY, isDark ? 'dark' : 'light');
            });
        }
    }

    document.addEventListener('DOMContentLoaded', initDarkMode);
})();
