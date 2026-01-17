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

function initCursor() {
    const finePointer = window.matchMedia?.('(pointer: fine)')?.matches ?? false;
    if (!finePointer || prefersReducedMotion) return;

    const cursor = document.createElement('div');
    cursor.className = 'cursor';

    const ring = document.createElement('div');
    ring.className = 'cursor-ring';

    const label = document.createElement('div');
    label.className = 'cursor-label';

    document.body.append(cursor, ring, label);
    document.body.classList.add('has-cursor');

    let targetX = -100;
    let targetY = -100;
    let dotX = targetX;
    let dotY = targetY;
    let ringX = targetX;
    let ringY = targetY;

    const dotOffset = 5;
    const ringOffset = 23;

    const setPos = () => {
        dotX += (targetX - dotX) * 0.25;
        dotY += (targetY - dotY) * 0.25;
        ringX += (targetX - ringX) * 0.14;
        ringY += (targetY - ringY) * 0.14;

        cursor.style.setProperty('--cx', `${dotX - dotOffset}px`);
        cursor.style.setProperty('--cy', `${dotY - dotOffset}px`);
        ring.style.setProperty('--cx', `${ringX - ringOffset}px`);
        ring.style.setProperty('--cy', `${ringY - ringOffset}px`);
        label.style.setProperty('--lx', `${ringX + 18}px`);
        label.style.setProperty('--ly', `${ringY + 18}px`);

        requestAnimationFrame(setPos);
    };

    requestAnimationFrame(setPos);

    window.addEventListener(
        'mousemove',
        (event) => {
            targetX = event.clientX;
            targetY = event.clientY;
        },
        { passive: true },
    );

    document.addEventListener(
        'mouseout',
        (event) => {
            if (event.relatedTarget) return;
            document.body.classList.remove('has-cursor', 'cursor-active');
        },
        { passive: true },
    );

    document.addEventListener(
        'mouseover',
        () => {
            document.body.classList.add('has-cursor');
        },
        { passive: true },
    );

    const interactiveSelector = 'a, button, [role="button"], input, textarea, select, .btn';

    const getLabel = (element) => {
        if (element.dataset.cursor) return element.dataset.cursor;
        if (element.matches('input, textarea, select')) return 'Type';

        const aria = element.getAttribute('aria-label');
        if (aria) return aria;

        const text = (element.textContent ?? '').trim().replace(/\s+/g, ' ');
        if (text) return text.split(' ').slice(0, 2).join(' ');

        return element.matches('a') ? 'Open' : 'Go';
    };

    document.addEventListener(
        'pointerover',
        (event) => {
            if (event.pointerType && event.pointerType !== 'mouse') return;
            const target = event.target instanceof Element ? event.target.closest(interactiveSelector) : null;
            if (!target) return;
            label.textContent = getLabel(target);
            document.body.classList.add('cursor-active');
        },
        true,
    );

    document.addEventListener(
        'pointerout',
        (event) => {
            if (event.pointerType && event.pointerType !== 'mouse') return;
            const from = event.target instanceof Element ? event.target.closest(interactiveSelector) : null;
            if (!from) return;
            const to = event.relatedTarget instanceof Element ? event.relatedTarget.closest(interactiveSelector) : null;
            if (to) return;
            document.body.classList.remove('cursor-active');
        },
        true,
    );
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
    initCursor();
    initMagneticHover();
    initHeroTilt();
});
