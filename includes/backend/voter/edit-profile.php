<?php
session_start();
include "../../../connect.php";
include "../../regular_functions.php";
displayMessage();

// Check if user is logged in
if (!isset($_SESSION['vid'])) {
    $_SESSION['msg'] = "You need to login first!";
    redirectHere($_SERVER['PHP_SELF']);
    header("Location: ../../../signin.php");
    exit();
}

// Fetch voter information
$vid = $_SESSION['vid'];
$sql = "SELECT * FROM voters JOIN locations on locations.lid = voters.lid WHERE vid = $vid;";
$locationQuery = "SELECT * FROM locations;";
$locations = mysqli_query($conn, $locationQuery);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


// Function to validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to handle file upload
function uploadFile($file, $directory, $oldFilename = null) {
    $allowedExtensions = array("jpg", "jpeg", "png", "webp");
    $timestamp = time();
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = $timestamp . '_' . $file['name'];
    $targetPath = $directory . '/' . $filename;


    // Check if old file exists and delete it
    if ($oldFilename && file_exists($directory . '/' . $oldFilename)) {
        unlink($directory . '/' . $oldFilename);
    }
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

if (!empty($_POST)) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$age = $_POST['age'];
	$lid = $_POST['lid'];
	$citizenship_number = $_POST['citizenship_number'];
	$updateFront = (isset($_POST['update_front_image'])) ? true : false;
	$updateBack = (isset($_POST['update_back_image'])) ? true : false;
	$updateProfile = (isset($_POST['update_profile_picture'])) ? true : false;

    if (empty($name) || empty($email) ||empty($age) || empty($lid) ||  empty($citizenship_number)) {
        echo "All fields are required.";
    } elseif (!validateEmail($email)) {
        echo "Invalid email address.";
	} else {
	if ($updateFront) {
	  $frontImage = uploadFile($_FILES['front_image'], '../../../uploads/cs_front', $row['front_image']);
	} else {
		$frontImage = $row['front_image'];
	}
	if ($updateBack) {
	  $backImage = uploadFile($_FILES['back_image'], '../../../uploads/cs_back', $row['back_image']);
	} else {
		$backImage = $row['back_image'];
	}

	if ($updateProfile) {
	  $profilePicture = uploadFile($_FILES['photo'], '../../../uploads/profile_picture', $row['photo']);
	} else {
		$profilePicture = $row['photo'];
	}

	
	// Insert into database
	$sql = "UPDATE voters 
		SET name = ?,
		 email = ?,
		 age = ?,
		 lid = ?,
		 citizenship_number = ?,
		 front_image = ?,
		 back_image = ?,
		 photo = ?
		WHERE vid = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sssssssss", $name, $email, $age, $lid, $citizenship_number, $frontImage, $backImage, $profilePicture, $_SESSION['vid']);
	if ($stmt->execute()) {
		 $_SESSION['msg-success'] = "Profile Updated Successfully!";
	} else {
		 $_SESSION['msg-error'] = "Some error occurred while Updating your Profile.";
	}
	header("Location: ". $_SERVER['PHP_SELF']);

	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
				font-size: 17px;
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
            display: block;
            margin-bottom: 10px;
            margin-top: 20px;
				font-size: 20px;
        }
			input[type="checkbox"] {
			display: none;
			}
        input[type="text"],
        input[type="number"],
        input[type="password"],
        input[type="file"], select {
            width: 100%;
				font-size: 19px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
			label {
			font-weight: bold;
			}
			span {
				font-size: 18px;
			}
			#reset {
				background-color: maroon;
				color: white;
				text-decoration: none;
				padding: 15px;
				font-size: 18px;
				border: 5px;
				border-radius: 8px;
				float: right;
				font-weight: bold;
			}
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
				font-size: 17px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .picture {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .picture img {
            max-width: 100%;
            display: block;
            margin-bottom: 10px;
        }
			.undo {
			display: none;
			}
    </style>
</head>
<body>
    <div class="container">
		 <h1>Update Profile</h1>
			<p><a href="javascript: void(location.reload())" id="reset">RESET</a></p>
		 <form action="" method="post" enctype="multipart/form-data" style="clear: both; margin-top: 35px;">
			  <label for="name">Name</label>
			  <input type="text" name="name" id="name" placeholder="Name" required value="<?= $row['name'] ?>" ><span></span><br>
			  <label for="email">Email</label>
			  <input type="text" name="email" id="email" placeholder="Email" required value="<?= $row['email'] ?>"><span></span><br>
			  <label for="age">Age</label>
			  <input type="number" name="age" min="16" max="150" id="age" placeholder="Age" required value="<?= $row['age'] ?>" ><span></span><br>
			  <label for="location">Location</label>
					<select name="lid" id="location">
					<?php 
						if ($locations->num_rows > 0) {
							while ($location = $locations->fetch_assoc()) {
						?>
						<option value="<?=$location['lid']?>" <?=($location['lid'] == $row['lid']) ? "selected" : ''?>><?=$location['location_name']?></option>
						<?php
							}
						}
					?>
					</select><br>
			  <!-- files -->
			  <label>Citizenship Photo(Front)
			  <a class="undo" href="#" onclick="undo(0)">UNDO</a>
				</label>
				<input type="file" name="front_image" class="imageInput" accept="image/*" ><br>
			  <img class="previewImage" src="#" alt="Preview" style="max-width: 300px; display: none;">
            <?php if (!empty($row['front_image'])): ?>
                <div class="picture">
                    <img src="../../../uploads/cs_front/<?= $row['front_image'] ?>" class="photo" alt="Citizenship Front">
                    <input type="checkbox" class="updateImage" id="delete_front_image" name="update_front_image">
                </div>
            <?php endif; ?>
			  <label>Citizenship Photo(Back)
			  <a class="undo" href="#" onclick="undo(1)">UNDO</a>
				</label>
			 <input type="file" name="back_image"  class="imageInput" accept="image/*" ><br>
			  <img class="previewImage" src="#" alt="Preview" style="max-width: 300px; display: none;">
            <?php if (!empty($row['back_image'])): ?>
                <div class="picture">
                    <img src="../../../uploads/cs_back/<?= $row['back_image'] ?>" class="photo" alt="Citizenship Back">
                    <input type="checkbox" class="updateImage" id="delete_front_image" name="update_back_image">
                </div>
            <?php endif; ?>
			  <label for="citizenship_number">Citizenship-number
				</label>
				<input type="text" name="citizenship_number" id="citizenship_number" placeholder="Your Citizenship-Number" required value="<?=$row['citizenship_number']?>"><span></span><br>
			  <label>Profile Picture
			  <a class="undo" href="#" onclick="undo(2)">UNDO</a>
			</label> <input type="file" name="photo" class="imageInput" accept="image/*" ><br>
			  <img class="previewImage" src="#" alt="Preview" style="max-width: 300px; display: none;">
            <?php if (!empty($row['photo'])): ?>
                <div class="picture">
                    <img src="../../../uploads/profile_picture/<?= $row['photo'] ?>" class="photo" alt="Profile Picture">
                    <input type="checkbox" class="updateImage" id="delete_profile_picture" name="update_profile_picture">
                </div>
            <?php endif; ?>
			  <button type="submit">Update</button>
		 </form>
	</div>
<script>
  const imageInputs = document.querySelectorAll('.imageInput');
  const previewImages = document.querySelectorAll('.previewImage');
  const updateImages = document.querySelectorAll('.updateImage');
  const updatePhoto = document.querySelectorAll('.photo');
  const updateUndo = document.querySelectorAll('.undo');

  imageInputs.forEach((input, index) => {
    input.addEventListener('change', () => {
      const file = input.files[0];
      const reader = new FileReader();
      reader.onload = () => {
        previewImages[index].src = reader.result;
        previewImages[index].style.display = 'block';
        updateImages[index].checked = true;
		  updatePhoto[index].style.display = 'none';
		  updateUndo[index].style.display = 'inline';
      };
      reader.readAsDataURL(file);
    });
  });

  function undo(index) {
    imageInputs[index].value = null; // Clear the selected file
    previewImages[index].src = '#'; // Reset the preview image source
    previewImages[index].style.display = 'none'; // Hide the preview image
	 updateImages[index].checked = false;
	 updatePhoto[index].style.display = 'block';
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
</body>
</html>

