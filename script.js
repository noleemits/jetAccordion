document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.wpe-accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const isOpen = content.classList.contains('open');

            // Toggle current content
            header.setAttribute('aria-expanded', !isOpen);
            content.classList.toggle('open');

            // Rotate toggle icon
            const toggleIcon = header.querySelector('.wpe-toggle-icon');
            toggleIcon.classList.toggle('rotate');
        });
    });

    document.querySelectorAll('.wpe-accordion-header').forEach(header => {
        header.addEventListener('keydown', event => {
            if (event.key === 'Enter' || event.key === ' ') {
                header.click();
            }
        });
    });
});