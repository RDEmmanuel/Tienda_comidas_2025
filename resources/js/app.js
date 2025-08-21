import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;
    const toggleBtn = document.getElementById('toggle-theme');

    // Leer tema guardado
    const theme = localStorage.getItem('theme');

    // ✅ Forzar light por defecto si no hay nada guardado
    if (theme === 'dark') {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light'); // guarda light por defecto
    }

    // Alternar tema manualmente
    toggleBtn?.addEventListener('click', () => {
        const isDark = html.classList.contains('dark');
        if (isDark) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    });
});
