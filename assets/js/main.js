/**
 * main.js
 * Global initializations for AOS and common UI elements.
 */
document.addEventListener('DOMContentLoaded', () => {
    // AOS (Animate On Scroll) Initialization
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    }
});
