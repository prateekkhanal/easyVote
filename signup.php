<?php
include "connect.php";

// Function to validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate password
function validatePassword($password) {
    // Password must be at least 4 characters long and contain a capital letter, a small letter, a number, and a symbol
    return preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){4,}$/', $password);
}

// Function to handle file upload
function uploadFile($file, $directory) {
    $allowedExtensions = array("jpg", "jpeg", "png");
    $timestamp = time();
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = $timestamp . '_' . $file['name'];
    $targetPath = $directory . '/' . $filename;

    if (in_array($extension, $allowedExtensions)) {
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
	 $voterID = uniqid();
	 $citizenship_number = $_POST['citizenship-number'];

    if (empty($name) || empty($email) || empty($password_1) || empty($password_2)) {
        echo "All fields are required.";
    } elseif (!validateEmail($email)) {
        echo "Invalid email address.";
    } elseif ($password_1 !== $password_2) {
        echo "Passwords do not match.";
    } elseif (!validatePassword($password_1)) {
        echo "Password must be at least 4 characters long and contain a capital letter, a small letter, a number, and a symbol.";
    } else {
        // All inputs are valid, proceed with database insertion and file uploads
        $frontImage = uploadFile($_FILES['front_image'], 'uploads/cs_front');
        $backImage = uploadFile($_FILES['back_image'], 'uploads/cs_back');
        $profilePicture = uploadFile($_FILES['photo'], 'uploads/profile_picture');

        if ($frontImage && $backImage && $profilePicture) {
            // Insert into database
            $sql = "INSERT INTO voters (name, email, password, front_image, back_image, citizenship_number, voterID, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $name, $email, md5($password_1), $frontImage, $backImage, $citizenship_number, $voterID, $profilePicture);
            
            if ($stmt->execute()) {
                $_SESSION['msg-success'] = "Signup successful.";
            } else {
                $_SESSION['msg-error'] = "Error occurred while signing up.";
            }
        } else {
            $_SESSION['msg-error'] = "Error uploading files.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>
    <h1>Signup</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name</label><br>
        <input type="text" name="name" id="name" placeholder="Name" required><span></span><br><br>
        <label for="email">Email</label><br>
        <input type="text" name="email" id="email" placeholder="Email" required><span></span><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password_1" id="password" placeholder="Password" required><span></span><br><br>
        <label for="password">Confirm Password</label><br>
        <input type="password" name="password_2" id="confirm_password" placeholder="Confirm Password" required><span></span><br><br>
        <!-- files -->
        <span>Citizenship Photo(Front)</span> <input type="file" name="front_image" ><br><br>
        <span>Citizenship Photo(Back)</span> <input type="file" name="back_image" ><br><br>
        <label for="citizenship_number">Citizenship-number</label><br>
        <input type="text" name="citizenship_number" id="citizenship_number" placeholder="Your Citizenship-Number" required><span></span><br><br>
        <span>Profile Picture</span> <input type="file" name="photo"><br><br>
        <button type="submit">Signup</button>
        <div style="margin-top: 20px;"><i>Already have an account?</i> <a href="signin.php">Sign In</a></div>
    </form>
</body>
<script>
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
</script>
</html>
