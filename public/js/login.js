/* ============================================
   Login Form Validation & Interactions
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const errorAlert = document.getElementById('errorAlert');

    function setFieldError(id, message) {
        const errorElement = document.getElementById(id);

        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    // Toggle password visibility
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' 
                ? '<i class="fas fa-eye"></i>' 
                : '<i class="fas fa-eye-slash"></i>';
        });
    }

    // Clear errors on input
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            setFieldError('usernameError', '');
            this.classList.remove('is-invalid');
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            setFieldError('passwordError', '');
            this.classList.remove('is-invalid');
        });
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Reset errors
            setFieldError('usernameError', '');
            setFieldError('passwordError', '');
            usernameInput.classList.remove('is-invalid');
            passwordInput.classList.remove('is-invalid');
            if (errorAlert) errorAlert.style.display = 'none';

            // Validate username
            const username = usernameInput.value.trim();
            if (!username) {
                setFieldError('usernameError', 'Username is required');
                usernameInput.classList.add('is-invalid');
                return;
            }

            if (username.length < 3) {
                setFieldError('usernameError', 'Username must be at least 3 characters');
                usernameInput.classList.add('is-invalid');
                return;
            }

            if (!/^[a-zA-Z0-9_-]+$/.test(username)) {
                setFieldError('usernameError', 'Username can only contain letters, numbers, dashes and underscores');
                usernameInput.classList.add('is-invalid');
                return;
            }

            // Validate password
            const password = passwordInput.value;
            if (!password) {
                setFieldError('passwordError', 'Password is required');
                passwordInput.classList.add('is-invalid');
                return;
            }

            if (password.length < 6) {
                setFieldError('passwordError', 'Password must be at least 6 characters');
                passwordInput.classList.add('is-invalid');
                return;
            }

            setLoading(true);
            form.submit();
        });
    }

    // Prevent form submission during loading
    function setLoading(isLoading) {
        const btn = form.querySelector('.btn-login');
        if (isLoading) {
            btn.disabled = true;
            btn.classList.add('loading');
            btn.innerHTML = '<span class="spinner"></span>Signing in...';
        } else {
            btn.disabled = false;
            btn.classList.remove('loading');
            btn.innerHTML = 'Sign In';
        }
    }
});
