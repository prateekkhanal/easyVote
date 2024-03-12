document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const submitButton = document.getElementById('submitBtn');

    emailInput.addEventListener('blur', function() {
        const emailError = document.getElementById('emailError');
        if (this.value.trim() !== '' && !validateEmail(this.value)) {
            emailError.textContent = 'Invalid email address!';
        } else {
            emailError.textContent = '';
        }
    });

    passwordInput.addEventListener('blur', function() {
        const passwordError = document.getElementById('passwordError');
        if (passwordInput.value.trim() !== '' && !validatePassword(this.value)) {
            passwordError.textContent = 'Password must contain at least 4 characters including a capital letter, a small letter, a number, and a symbol.';
        } else {
            passwordError.textContent = '';
        }
    });

    submitButton.addEventListener('click', function(event) {
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        if (emailInput.value.trim() !== '' && !validateEmail(emailInput.value)) {
            emailError.textContent = 'Invalid email address!';
            event.preventDefault();
        }
        if (passwordInput.value.trim() !== '' && !validatePassword(passwordInput.value)) {
            passwordError.textContent = 'Password must contain at least 4 characters including a capital letter, a small letter, a number, and a symbol.';
            event.preventDefault();
        }
    });

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validatePassword(password) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s:])([^\s]){4,}$/.test(password);
    }
});
