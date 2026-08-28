import './bootstrap';

const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false;

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initScrollReveal();
    initQuoteForms();
});

function initMobileMenu() {
    const menu = document.querySelector('[data-mobile-menu]');
    const open = document.querySelector('[data-mobile-open]');
    const closers = document.querySelectorAll('[data-mobile-close]');

    if (!menu) return;

    const setOpen = (isOpen) => {
        menu.classList.toggle('is-open', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
    };

    open?.addEventListener('click', () => setOpen(true));
    closers.forEach((el) => el.addEventListener('click', () => setOpen(false)));

    menu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setOpen(false);
    });
}

function initScrollReveal() {
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
        { threshold: 0.12 },
    );

    items.forEach((el) => observer.observe(el));
}

function initQuoteForms() {
    document.querySelectorAll('form[data-quote-form]').forEach((form) => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');
            if (!button) return;

            button.disabled = true;
            button.setAttribute('aria-busy', 'true');
            const original = button.innerHTML;
            button.innerHTML = 'Sending…';

            window.setTimeout(() => {
                button.disabled = false;
                button.removeAttribute('aria-busy');
                button.innerHTML = original;
            }, 8000);
        });
    });
}
