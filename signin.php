<?php
session_start(); // Start session

include "./includes/regular_functions.php";

// print any errors
displayMessage();

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
            $_SESSION['role'] = 'voter';
            // Redirect to the previous page or index.php if not set
            redirectBack('/easyVote/index.php');
				exit;
        } else {
            // Invalid credentials
            $_SESSION['msg-error'] = "Invalid email or password.";
        }
		  header("Location: ". $_SERVER['PHP_SELF']);
    }
    // Close database connection
    $conn->close();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
			body {
				 background-color: #f4f4f4;
				 font-family: Arial;
			}
			.msg {
				font-size: 22px;
}
			.container {
				 font-family: Arial, sans-serif;
				 margin: 0;
				 padding: 0;
				 display: flex;
				 justify-content: center;
				 align-items: center;
				 height: 100vh;
				font-size: 18px;
			}

			h1 {
				 text-align: center;
				margin-bottom: 45px;
			}

			form {
				 width: 400px; /* Set the desired width */
				 margin: auto auto;
				 padding: 20px;
				 background-color: #fff;
				 border-radius: 5px;
				 box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			}

			input[type="text"],
			input[type="password"] {
				 width: 100%;
				font-size: 18px;
				 padding: 10px;
				 margin-bottom: 10px;
				 border-radius: 5px;
				 border: 1px solid #ccc;
				 box-sizing: border-box;
			}

			button {
				 padding: 10px 20px;
				 background-color: #007bff;
				 color: #fff;
				 border: none;
				 border-radius: 5px;
				font-size: 20px;
				 cursor: pointer;
			}

			button:hover {
				 background-color: #0056b3;
			}

			#emailError,
			#passwordError {
				 color: red;
			}
</style>
</head>
<body>

<div class="container">
	<form id="loginForm" action="" method="post">
		 <h1>Sign in</h1>
		 <input type="text" name="email" id="email" placeholder="Email" required>
		 <span id="emailError"></span><br><br>

		 <input type="password" name="password" id="password" placeholder="Password" required>
		 <span id="passwordError"></span><br><br>

		 <button type="submit" id="submitBtn">Sign in</button>
		 <br>
		 <br>
		 <div style="margin-top: 10px;">
			  <i>Not registered yet? </i><a href="signup.php">Sign Up</a>
		 </div>
	</form>
</div>

<script src="./js/login_validation.js"></script>
</body>
</html>
