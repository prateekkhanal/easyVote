<?php
session_start();
include "connect.php";
include "./sidebar/sidebar.php";
include "./includes/regular_functions.php";
displayMessage();

// for locations
$locationQuery = "SELECT * FROM locations;";
$locations = mysqli_query($conn, $locationQuery);

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
    $allowedExtensions = array("jpg", "jpeg", "png", "webp");
    $timestamp = time();
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = $timestamp . '_' . $file['name'];
    $targetPath = $directory . '/' . $filename;

    if (in_array(strtolower($extension), $allowedExtensions)) {
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
    $age = $_POST['age'];
    $lid = $_POST['lid'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
	 $voterID = uniqid();
	 $citizenship_number = $_POST['citizenship_number'];
    if (empty($name) || empty($email) ||empty($age) || empty($lid) ||  empty($citizenship_number) || empty($password_1) || empty($password_2)) {
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
            $sql = "INSERT INTO voters (name, email, age, lid, password, front_image, back_image, citizenship_number, voterID, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssss", $name, $email, $age, $lid, md5($password_1), $frontImage, $backImage, $citizenship_number, $voterID, $profilePicture);
            
            if ($stmt->execute()) {
                $_SESSION['msg-success'] = "Signup successful!";
					 echo "<script>window.location = \"/easyVote/signin.php\";</script>";
            } else {
                $_SESSION['msg-error'] = "Please use your original unused citizenship-number or email!";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
				font-size: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        label {
            margin: 10px 0px;
        }
        input[type="text"],
        input[type="number"],
        input[type="password"],
        input[type="file"], select {
            width: 100%;
				font-size: 17px;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
			label {
			display: block;
			font-weight: bold;
			}
			.undo {
			display: none;
			}
        button {
            padding: 10px 20px;
            background-color: #002D72;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
				font-size: 20px;
				margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .profile-picture {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .profile-picture img {
            max-width: 100%;
            display: block;
            margin-bottom: 10px;
        }
			span{
			margin-top: 0px;
			}
    </style>

</head>
<body>
    <div class="container">
		 <h1>Signup</h1>

		 <form action="" method="post" enctype="multipart/form-data">
			  <label for="name">Name</label>
			  <input type="text" name="name" id="name" placeholder="Name" required><span></span><br>
			  <label for="email">Email</label>
			  <input type="text" name="email" id="email" placeholder="Email" required><span></span><br>
			  <label for="age">Age</label>
			  <input type="number" name="age" min="16" max="150" id="age" placeholder="Age" required><span></span><br>
			  <label for="location">Location</label>
					<select name="lid" id="location">
					<?php 
						if ($locations->num_rows > 0) {
							while ($location = $locations->fetch_assoc()) {
						?>
						<option value="<?=$location['lid']?>" <?=($location['location_name'] == "Other") ? "selected" : ''?>><?=$location['location_name']?></option>
						<?php
							}
						}
					?>
					</select><br>
			  <label for="password">Password</label>
			  <input type="password" name="password_1" id="password" placeholder="Password" required><span></span><br>
			  <label for="password">Confirm Password</label>
			  <input type="password" name="password_2" id="confirm_password" placeholder="Confirm Password" required><span></span><br>
			  <!-- files -->
			  <label>Citizenship Photo(Front)
			  <a class="undo" href="#" onclick="undo(0)">UNDO</a>
				</label>
				<input type="file" name="front_image" class="imageInput" accept="image/*" ><br>
			  <img id="previewImage" src="#" alt="Preview" style="max-width: 300px; display: none;">
			  <label>Citizenship Photo(Back)
			  <a class="undo" href="#" onclick="undo(1)">UNDO</a>
				</label>
			 <input type="file" name="back_image"  class="imageInput" accept="image/*" ><br>
			  <img id="previewImage" src="#" alt="Preview" style="max-width: 300px; display: none;">
			  <label for="citizenship_number">Citizenship-number
				</label>
			  <input type="text" name="citizenship_number" id="citizenship_number" placeholder="Your Citizenship-Number" required><span></span><br>
			  <label>Profile Picture
			  <a class="undo" href="#" onclick="undo(2)">UNDO</a>
				</label> <input type="file" name="photo" class="imageInput" accept="image/*" ><br>
			  <img id="previewImage" src="#" alt="Preview" style="max-width: 300px; display: none;">
			  <button type="submit">Signup</button>
			  <div style="margin-top: 20px;"><i>Already have an account?</i> <a href="signin.php">Sign In</a></div>
		 </form>
	</div>
</body>
<script>
  const imageInputs = document.querySelectorAll('.imageInput');
  const previewImages = document.querySelectorAll('#previewImage');
  const updateUndo = document.querySelectorAll('.undo');

  imageInputs.forEach((input, index) => {
    input.addEventListener('change', () => {
      const file = input.files[0];
      const reader = new FileReader();
      reader.onload = () => {
        previewImages[index].src = reader.result;
        previewImages[index].style.display = 'block';
        updateUndo[index].style.display = 'inline';
      };
      reader.readAsDataURL(file);
    });
  });

  function undo(index) {
    imageInputs[index].value = null; // Clear the selected file
    previewImages[index].src = '#'; // Reset the preview image source
    previewImages[index].style.display = 'none'; // Hide the preview image
	  updateUndo[index].style.display = 'none';
  }

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

        // Function to validate age
        function validateAge(age) {
			  if (/^\d+$/.test(age)) {
				  const Age = parseInt(age);
					return (Age < 151 && Age >13) ? "" : "Age must be between 14-150";
			  } else {
				  return "Age must be a number";
			  }
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
        function handleInputChange(input, event, validationFunc) {
            input.addEventListener(event, function () {
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
        handleInputChange(nameInput, 'change', validateName);

        // Validate email on change
       const emailInput = document.getElementById('email');
        handleInputChange(emailInput, 'change', validateEmail);
		  
        // Validate age on change
       const ageInput = document.getElementById('age');
        handleInputChange(ageInput, 'change', validateAge);

        // Validate password on change
        const passwordInput = document.getElementById('password');
        handleInputChange(passwordInput, 'change', validatePassword);

        // Validate confirm password on change
        const repasswordInput = document.getElementById('confirm_password');
        handleInputChange(repasswordInput, 'change', function(password) {
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
            const ageValue = ageInput.value.trim();
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

            const ageErrorMessage = validateAge(ageValue);
            if (ageErrorMessage !== '') {
                showError(ageInput, ageErrorMessage);
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
