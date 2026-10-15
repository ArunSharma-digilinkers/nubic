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

    const btn = document.querySelector('.back-to-top');
    if (btn) {
        const toggle = () => btn.classList.toggle('show', window.scrollY > 500);
        window.addEventListener('scroll', toggle, { passive: true });
        btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        toggle();
    }
});
