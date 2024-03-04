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
            $sql = "INSERT INTO voters (name, email, password, front_image, back_image, photo) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $name, $email, md5($password_1), $frontImage, $backImage, $profilePicture);
            
            if ($stmt->execute()) {
                echo "Signup successful.";
            } else {
                echo "Error occurred while signing up.";
            }
        } else {
            echo "Error uploading files.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h1>Signup</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name</label><br>
        <input type="text" name="name" id="name" placeholder="Name"><br><br>
        <label for="email">Email</label><br>
        <input type="text" name="email" id="email" placeholder="Email"><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password_1" id="password" placeholder="Password"><br><br>
        <label for="password">Confirm Password</label><br>
        <input type="password" name="password_2" id="password" placeholder="Confirm Password"><br><br>
        <!-- files -->
        <span>Citizenship Photo(Front)</span> <input type="file" name="front_image"><br><br>
        <span>Citizenship Photo(Back)</span> <input type="file" name="back_image"><br><br>
        <span>Profile Picture</span> <input type="file" name="photo"><br><br>
        <button type="submit">Signup</button>
			<div style="margin-top: 20px;">Already have an account? <a href="signin.php">Sign In</a></div>
    </form>
    
</body>
</html>
