import './bootstrap';

const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false;
document.documentElement.classList.add('js');

function initRevealOnScroll() {
    const items = Array.from(document.querySelectorAll('.reveal'));
    if (!items.length) return;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) continue;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        },
        { threshold: 0.15 },
    );

    items.forEach((el) => observer.observe(el));
}

function initMagneticHover() {
    const finePointer = window.matchMedia?.('(pointer: fine)')?.matches ?? false;
    if (!finePointer || prefersReducedMotion) return;

    const elements = Array.from(document.querySelectorAll('[data-magnetic], .btn, .brand, .nav-links a'));
    if (!elements.length) return;

    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));

    const active = [];

    for (const el of elements) {
        if (!(el instanceof HTMLElement)) continue;
        el.classList.add('magnetic');

        let rect = null;

        const updateRect = () => {
            rect = el.getBoundingClientRect();
        };

        const onMove = (event) => {
            if (!rect) updateRect();
            if (!rect) return;

            const relX = (event.clientX - (rect.left + rect.width / 2)) / rect.width;
            const relY = (event.clientY - (rect.top + rect.height / 2)) / rect.height;

            const max = el.matches('.btn') ? 14 : 10;
            const strength = el.matches('.btn') ? 0.9 : 0.75;

            const tx = clamp(relX * max, -max, max) * strength;
            const ty = clamp(relY * max, -max, max) * strength;

            el.style.setProperty('--mx', `${tx}px`);
            el.style.setProperty('--my', `${ty}px`);
        };

        const reset = () => {
            el.style.setProperty('--mx', '0px');
            el.style.setProperty('--my', '0px');
        };

        el.addEventListener('mouseenter', updateRect, { passive: true });
        el.addEventListener('mousemove', onMove, { passive: true });
        el.addEventListener('mouseleave', () => {
            rect = null;
            reset();
        });

        active.push(() => (rect = null));
    }

    const invalidateAll = () => {
        for (const invalidate of active) invalidate();
    };

    window.addEventListener('scroll', invalidateAll, { passive: true });
    window.addEventListener('resize', invalidateAll, { passive: true });
}

function initHeroTilt() {
    const finePointer = window.matchMedia?.('(pointer: fine)')?.matches ?? false;
    if (!finePointer || prefersReducedMotion) return;

    const hero = document.querySelector('.hero-visual');
    if (!(hero instanceof HTMLElement)) return;

    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));

    const update = (event) => {
        const rect = hero.getBoundingClientRect();
        const x = (event.clientX - rect.left) / rect.width;
        const y = (event.clientY - rect.top) / rect.height;

        const tiltX = clamp((x - 0.5) * 10, -6, 6);
        const tiltY = clamp((0.5 - y) * 10, -6, 6);

        hero.style.setProperty('--tilt-x', `${tiltX}deg`);
        hero.style.setProperty('--tilt-y', `${tiltY}deg`);
        hero.style.setProperty('--spot-x', `${Math.round(x * 100)}%`);
        hero.style.setProperty('--spot-y', `${Math.round(y * 100)}%`);
    };

    hero.addEventListener('mouseenter', () => hero.classList.add('is-interactive'), { passive: true });
    hero.addEventListener('mousemove', update, { passive: true });
    hero.addEventListener('mouseleave', () => {
        hero.classList.remove('is-interactive');
        hero.style.setProperty('--tilt-x', '0deg');
        hero.style.setProperty('--tilt-y', '0deg');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initRevealOnScroll();
    initMagneticHover();
    initHeroTilt();
});
