document.addEventListener('DOMContentLoaded', function () {
  // Function to validate name
  function validateName(name) {
		if (name.length < 3 || name.length > 64) {
			 return 'Name must be between 3 and 64 characters';
		} else if (/\d/.test(name)) {
			 return 'Name must not contain any number';
		} else if (/[^a-zA-Z\s]/.test(name)) {
			 return 'Name must not contain any special characters';
		} else {
			 return '';
		}
  }

  // Function to validate email
  function validateEmail(email) {
		return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) ? '' : 'Invalid email address';
  }

  // Function to validate password
  function validatePassword(password) {
		return /^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^A-Za-z0-9\s])\S{4,}$/.test(password) ? '' : 'Password must be at least 4 characters long and contain a capital letter, a small letter, a number, and a symbol';
  }

  // Function to display error message
  function showError(input, message) {
		const errorSpan = input.nextElementSibling;
		errorSpan.innerText = message;
		errorSpan.style.color = 'red';
  }

  // Function to clear error message
  function clearError(input) {
		const errorSpan = input.nextElementSibling;
		errorSpan.innerText = '';
  }

  // Function to validate and handle input change event
  function handleInputChange(input, validationFunc) {
		input.addEventListener('change', function () {
			 const value = input.value.trim();
			 if (value !== '') {
				  const errorMessage = validationFunc(value);
				  if (errorMessage !== '') {
						showError(input, errorMessage);
				  } else {
						clearError(input);
				  }
			 } else {
				  clearError(input);
			 }
		});
  }

  // Validate name on change
  const nameInput = document.getElementById('name');
  handleInputChange(nameInput, validateName);

  // Validate email on change
  const emailInput = document.getElementById('email');
  handleInputChange(emailInput, validateEmail);

  // Validate password on change
  const passwordInput = document.getElementById('password');
  handleInputChange(passwordInput, validatePassword);

  // Validate confirm password on change
  const repasswordInput = document.getElementById('confirm_password');
  handleInputChange(repasswordInput, function(password) {
		const passwordValue = passwordInput.value.trim();
		if (password !== passwordValue) {
			 return 'Passwords do not match';
		} else {
			 return '';
		}
  });

  // Validate form on submit
  const form = document.querySelector('form');
  form.addEventListener('submit', function (event) {
		const nameValue = nameInput.value.trim();
		const emailValue = emailInput.value.trim();
		const passwordValue = passwordInput.value.trim();
		const repasswordValue = repasswordInput.value.trim();

		const nameErrorMessage = validateName(nameValue);
		if (nameErrorMessage !== '') {
			 showError(nameInput, nameErrorMessage);
			 event.preventDefault();
		}

		const emailErrorMessage = validateEmail(emailValue);
		if (emailErrorMessage !== '') {
			 showError(emailInput, emailErrorMessage);
			 event.preventDefault();
		}

		const passwordErrorMessage = validatePassword(passwordValue);
		if (passwordErrorMessage !== '') {
			 showError(passwordInput, passwordErrorMessage);
			 event.preventDefault();
		}

		const repasswordErrorMessage = validatePassword(repasswordValue);
		if (repasswordErrorMessage !== '') {
			 showError(repasswordInput, repasswordErrorMessage);
			 event.preventDefault();
		}
  });
});

