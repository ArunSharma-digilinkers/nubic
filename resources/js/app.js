import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

// friendly extras: scroll reveal + back-to-top
document.documentElement.classList.add('js');

document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('in');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });
        items.forEach((el) => io.observe(el));
    } else {
        items.forEach((el) => el.classList.add('in'));
    }

    // product page: rating chips swap the code, pack, MRP and highlighted table row
    document.querySelectorAll('[data-variant-picker]').forEach((group) => {
        group.addEventListener('click', (e) => {
            const chip = e.target.closest('[data-variant]');
            if (!chip) return;
            group.querySelectorAll('[data-variant]').forEach((c) => c.setAttribute('aria-checked', String(c === chip)));
            document.querySelectorAll('[data-v]').forEach((el) => {
                const value = chip.dataset[el.dataset.v];
                if (value !== undefined) el.textContent = value;
            });
            document.querySelectorAll('[data-variant-row]').forEach((row) => {
                row.classList.toggle('is-selected', row.dataset.variantRow === chip.dataset.variant);
            });
        });
    });

    // products mega menu: hovering / focusing a category shows its subcategories
    document.querySelectorAll('[data-mega]').forEach((mega) => {
        const show = (id) => {
            mega.querySelectorAll('[data-mega-tab]').forEach((t) => t.classList.toggle('is-active', t.dataset.megaTab === id));
            mega.querySelectorAll('[data-mega-pane]').forEach((p) => p.classList.toggle('is-active', p.dataset.megaPane === id));
        };
        mega.querySelectorAll('[data-mega-tab]').forEach((tab) => {
            ['mouseenter', 'focus'].forEach((ev) => tab.addEventListener(ev, () => show(tab.dataset.megaTab)));
        });
    });

    const btn = document.querySelector('.back-to-top');
    if (btn) {
        const toggle = () => btn.classList.toggle('show', window.scrollY > 500);
        window.addEventListener('scroll', toggle, { passive: true });
        btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        toggle();
    }
});
