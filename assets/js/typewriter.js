/**
 * typewriter.js
 * Reusable typewriter effect. Requires an element with id="typeText" 
 * and a global variable "TYPEWRITER_TEXT".
 */
document.addEventListener('DOMContentLoaded', () => {
    let i = 0;
    const speed = 25;
    const text = typeof TYPEWRITER_TEXT !== 'undefined' ? TYPEWRITER_TEXT : '';
    const typeTarget = document.getElementById("typeText");

    function typeWriter() {
        if (i < text.length && typeTarget) {
            typeTarget.innerHTML += text.charAt(i);
            i++;
            setTimeout(typeWriter, speed);
        }
    }

    if (text && typeTarget) {
        typeWriter();
    }
});
