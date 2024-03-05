<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
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
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];
	if (!validateEmail($email)) {
        echo "Invalid email address!";
    } elseif (!validatePassword($password)) {
        echo "Password Format Incorrect!";
    } else {
    // Hash the password (assuming it's stored as MD5 hash)
    $hashed_password = md5($password);
    // Prepare and execute query to check if user exists
    $stmt = $conn->prepare("SELECT vid, email, name FROM voters WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows == 1) {
        // User exists, set session variables
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['vid'] = $row['vid'];
        $_SESSION['name'] = $row['name'];
        // Redirect to index.php
        header("Location: index.php");
        exit();
    } else {
        // Invalid credentials
        echo "Invalid email or password.";
    }
	}
    // Close database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h1>Sign in</h1>

    <form action="" method="post">
        <label for="email">Email</label><br>
        <input type="text" name="email" id="email" placeholder="Email"><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password" placeholder="Password"><br><br>

        <button type="submit">Signin</button>
    </form>
	<div style="margin-top: 10px;">
	<i>Already Signed In? </i></i><a href="register.php">Sign Up</a>
</div>

</body>
</html>
