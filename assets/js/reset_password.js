document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('resetPasswordForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const password = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const token = form.querySelector('input[name="token"]').value;
        const errorEl = document.getElementById('resetError');
        const successEl = document.getElementById('resetSuccess');

        errorEl.style.display = 'none';
        successEl.style.display = 'none';

        if (password.length < 8) {
            errorEl.textContent = 'Le mot de passe doit contenir au moins 8 caractères.';
            errorEl.style.display = 'block';
            return;
        }

        if (password !== confirmPassword) {
            errorEl.textContent = 'Les mots de passe ne correspondent pas.';
            errorEl.style.display = 'block';
            return;
        }

        try {
            const response = await fetch('../assets/php/auth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'reset_password',
                    token,
                    password,
                    csrf_token: typeof CSRF_TOKEN !== 'undefined' ? CSRF_TOKEN : ''
                })
            });
            const result = await response.json();

            if (result.status === 'success') {
                successEl.textContent = result.message;
                successEl.style.display = 'block';
                form.reset();
                setTimeout(() => {
                    window.location.href = result.redirect || 'inscrire.php';
                }, 2000);
            } else {
                errorEl.textContent = result.message;
                errorEl.style.display = 'block';
            }
        } catch (err) {
            console.error(err);
            errorEl.textContent = 'Une erreur est survenue. Veuillez réessayer.';
            errorEl.style.display = 'block';
        }
    });
});
