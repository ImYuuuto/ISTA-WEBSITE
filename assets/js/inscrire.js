let isAnimating = false;

// Fake users database
// Fake users database removed - using PHP auth
const fakeUsers = [];

function showForm(formId) {
    if (isAnimating) return;
    isAnimating = true;

    // Hide all forms
    document.querySelectorAll('#login, #inscription, #reinscription').forEach(form => {
        if (form.id === formId) return; // Skip target for now

        form.style.maxHeight = form.scrollHeight + 'px'; // Set explicit height first
        requestAnimationFrame(() => {
            form.classList.remove('show');
            form.style.maxHeight = '0'; // Then collapse
        });
    });

    document.querySelectorAll('.choice-btn').forEach(btn => btn.classList.remove('active'));

    const targetForm = document.getElementById(formId);
    const targetButton = document.querySelector(`.choice-btn[data-form="${formId}"]`);

    if (targetForm) {
        // Small delay to allow closing animations to start
        setTimeout(() => {
            targetForm.classList.add('show');
            targetForm.style.maxHeight = targetForm.scrollHeight + 'px'; // Expand to exact height

            if (targetButton) {
                targetButton.classList.add('active');
            }

            // Clean up after animation
            setTimeout(() => {
                // Optional: set to auto if content might change, 
                // but keeping explicit height is smoother for now given the context
                // targetForm.style.maxHeight = 'none'; 
                isAnimating = false;
            }, 800); // Match CSS transition duration

        }, 100);
    } else {
        isAnimating = false;
    }
}

// Handle Login
async function handleLogin(e) {
    e.preventDefault();

    const username = document.getElementById('login-username').value.trim();
    const password = document.getElementById('login-password').value;
    const errorMsg = document.getElementById('loginError');

    if (errorMsg) errorMsg.style.display = "none";

    try {
        const response = await fetch('../assets/php/auth.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'login',
                username,
                password,
                csrf_token: CSRF_TOKEN
            })
        });
        const result = await response.json();

        if (result.status === 'success') {
            window.location.href = result.redirect; // Redirect to user_page.php
        } else {
            if (errorMsg) {
                errorMsg.textContent = result.message;
                errorMsg.style.display = "block";
            }
            document.getElementById('login-password').value = "";
        }
    } catch (error) {
        console.error('Error:', error);
        if (errorMsg) {
            errorMsg.textContent = "An error occurred. Please try again.";
            errorMsg.style.display = "block";
        }
    }
}

// Handle Registration
async function handleRegistration(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    data.action = 'register';
    data.csrf_token = CSRF_TOKEN; // Add CSRF token

    try {
        const response = await fetch('../assets/php/auth.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();

        if (result.status === 'success') {
            alert(result.message);
            form.reset();
            showForm('login'); // Switch to login form
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred during registration.');
    }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
    // Show login by default (or check URL hash)
    const defaultForm = document.getElementById('login');
    if (defaultForm) {
        defaultForm.classList.add('show');
        defaultForm.style.maxHeight = defaultForm.scrollHeight + 'px';
        document.querySelector('.choice-btn[data-form="login"]')?.classList.add('active');
    }

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }

    // Attach handler to inscription form
    // The form in html has action="inscription.php", we need to select it.
    // Ideally add an ID to the form in HTML, but here we can select by parent ID
    const inscriptionForm = document.querySelector('#inscription form');
    if (inscriptionForm) {
        inscriptionForm.addEventListener('submit', handleRegistration);
    }

    // Reinscription - similar logic if needed, or just redirect to same auth for now
    // For this demo, we'll focus on new inscription.
});