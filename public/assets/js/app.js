// public/assets/js/app.js

// Petites animations d’apparition sur les cartes
document.addEventListener('DOMContentLoaded', () => {
    const animatedCards = document.querySelectorAll(
        '.card, .card-big, .culture-card, .ac-card, .admin-card'
    );

    animatedCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(12px)';
        card.style.transition = 'opacity 0.4s cubic-bezier(0.22, 1, 0.36, 1), ' +
            'transform 0.4s cubic-bezier(0.22, 1, 0.36, 1)';

        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 80 + index * 70);
    });

    // Effet parallax très léger sur le hero
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', () => {
            const offset = window.scrollY;
            hero.style.transform = `translateY(${offset * 0.08}px)`;
        });
    }
});
