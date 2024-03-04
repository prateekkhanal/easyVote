<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include "connect.php";

    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Hash the password (assuming it's stored as MD5 hash)
    $hashed_password = md5($password);
    // Prepare and execute query to check if user exists
    $stmt = $conn->prepare("SELECT vid, email, name FROM voters WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

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

    // Close database connection
    $stmt->close();
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

</body>
</html>
