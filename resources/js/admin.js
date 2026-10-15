import * as bootstrap from 'bootstrap';
import Quill from 'quill';

window.bootstrap = bootstrap;

// Mobile sidebar toggle
document.querySelectorAll('[data-sidebar-toggle]').forEach((btn) =>
    btn.addEventListener('click', () => document.querySelector('.admin-sidebar').classList.toggle('open'))
);

// Rich text editors: <textarea class="js-editor">
document.querySelectorAll('textarea.js-editor').forEach((ta) => {
    const wrap = document.createElement('div');
    wrap.className = 'editor-wrap';
    const holder = document.createElement('div');
    holder.innerHTML = ta.value;
    wrap.appendChild(holder);
    ta.style.display = 'none';
    ta.parentNode.insertBefore(wrap, ta);

    const quill = new Quill(holder, {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [2, 3, 4, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'blockquote'],
                ['clean'],
            ],
        },
    });
    ta.form.addEventListener('submit', () => {
        ta.value = quill.getText().trim() === '' ? '' : quill.root.innerHTML;
    });
});

// Image preview on file select
document.querySelectorAll('input[type=file][data-preview]').forEach((input) => {
    input.addEventListener('change', () => {
        const img = document.querySelector(input.dataset.preview);
        if (img && input.files[0]) {
            img.src = URL.createObjectURL(input.files[0]);
            img.classList.remove('d-none');
        }
    });
});

// Variants repeater (product form)
const body = document.getElementById('variants-body');
if (body) {
    const tpl = document.getElementById('variant-row-tpl').innerHTML;
    let idx = body.querySelectorAll('tr').length;
    document.getElementById('add-variant').addEventListener('click', () => {
        body.insertAdjacentHTML('beforeend', tpl.replace(/__i__/g, idx++));
    });
    body.addEventListener('click', (e) => {
        const btn = e.target.closest('.remove-variant');
        if (btn) btn.closest('tr').remove();
    });
}

// Confirm delete
document.querySelectorAll('form[data-confirm]').forEach((f) =>
    f.addEventListener('submit', (e) => {
        if (!confirm(f.dataset.confirm)) e.preventDefault();
    })
);
