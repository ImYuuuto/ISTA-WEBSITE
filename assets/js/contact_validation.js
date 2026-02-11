/**
 * contact_validation.js
 * Bootstrap client-side form validation.
 */
(() => {
    "use strict"
    document.addEventListener("DOMContentLoaded", () => {
        const forms = document.querySelectorAll(".needs-validation")
        Array.from(forms).forEach(form => {
            form.addEventListener("submit", event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add("was-validated")
            }, false)
        })
    })
})()
