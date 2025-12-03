const aside = document.getElementById('sidebar');
const btn = document.getElementById('btn');
const overlay = document.getElementById('overlay');

btn.addEventListener('click', (e) => {
    aside.classList.toggle('show');
    overlay.classList.toggle('hidden');
    e.stopPropagation();
});

overlay.addEventListener('click', () => {
    overlay.classList.toggle('hidden');
});

document.addEventListener('click', (e) => {
    const isClickInsideSidebar = aside.contains(e.target);
    const isClickOnButton = btn.contains(e.target);

    if (!isClickInsideSidebar && !isClickOnButton) {
        aside.classList.remove('show');
    }
});

document.querySelectorAll('.menu-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const targetId = toggle.getAttribute('data-target');
        const iconId = toggle.getAttribute('data-icon');
        const menu = document.getElementById(targetId);
        const icon = document.getElementById(iconId);

        menu.classList.toggle('hidden');
        icon.classList.toggle('active');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal-box');
    const openBtn = document.getElementById('open-modal');
    const closeBtn = document.getElementById('close-modal');
    const toast = document.getElementById('toast-succes');

    if (openBtn) {
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault(); // supaya tombol batal gak submit form
            modal.classList.add('hidden');
        });
    }

    toast.addEventListener('click', () => {
        toast.classList.add('hidden');
    });

    setTimeout(() => {
        toast.classList.add('hidden');
    }, 5000);
});
