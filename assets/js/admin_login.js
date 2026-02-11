/**
 * admin_login.js
 * Handles administrator authentication.
 */

document.addEventListener('DOMContentLoaded', () => {
    const adminLoginForm = document.getElementById('adminLoginForm');
    const loginError = document.getElementById('loginError');

    if (adminLoginForm) {
        adminLoginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(adminLoginForm);
            const data = Object.fromEntries(formData.entries());
            
            // Add action and type
            data.action = 'login';
            data.user_type = 'Admin';
            data.csrf_token = CSRF_TOKEN; // Assumes CSRF_TOKEN is defined globally in header/footer

            try {
                const response = await fetch('../assets/php/auth.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.status === 'success') {
                    window.location.href = result.redirect;
                } else {
                    loginError.textContent = result.message;
                    loginError.style.display = 'block';
                }
            } catch (error) {
                console.error('Admin login error:', error);
                loginError.textContent = 'Une erreur est survenue lors de la connexion.';
                loginError.style.display = 'block';
            }
        });
    }
});
