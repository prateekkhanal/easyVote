<?php
    session_start();
    include "../../../connect.php";
    include "../../regular_functions.php";

    // Check if user is logged in
    if (!isset($_SESSION['vid'])) {
        $_SESSION['msg'] = "You need to login first!";
        redirectHere($_SERVER['PHP_SELF']);
        header("Location: ../../../signin.php");
        exit();
    }

    // Fetch voter information
    $vid = $_SESSION['vid'];
	 $sql = "SELECT *, locations.location_name FROM voters JOIN locations on locations.lid = voters.lid WHERE vid = $vid;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
echo "<pre>";
/* print_r($row); */
echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 700px; /* Increased max-width to accommodate the image on the right */
            margin: 50px auto;
            background-color: #fff;
            border-radius: 5px;
		}
		.parent {
padding: 20px 0px;
}
		.container.photo {
            display: flex; /* Use flexbox layout */
            align-items: flex-start; /* Align items to the start (top) */
				justify-content: space-around;
				font-size: 1.3em;
				border: none;
            box-shadow: 0 0 0px rgba(0, 0, 0, 0);
        }
        h1 {
            text-align: center;
        }
        .profile-info {
            margin-left: 20px; /* Add some margin to separate text from image */
        }
        .profile-info p {
            margin: 10px 0;
        }
        .profile-info label {
            font-weight: bold;
        }
        .profile-picture {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .profile-picture img {
            max-height: 200px; /* Make sure the image fits within its container */
            display: block; /* Prevent any inline spacing */
            margin-left: auto; /* Push the image to the right */
				border-radius: 50%;
				
        }
    </style>
</head>
<body>
    <div class="container parent">
	  <h1>Profile</h1>
    <div class="container photo">
        <div class="profile-info">
            <p><label>Name: </label><?= $row['name'] ?></p><br>
            <p><label>Age: </label><?= $row['age'] ?></p><br>
            <p><label>Email: </label><?= $row['email'] ?></p><br>
            <p><label>Citizenship Number: </label><?= $row['citizenship_number'] ?></p><br>
            <p><label>Location: </label><?= $row['location_name'] ?></p><br>
            <p><label>Authentic: </label><?= $row['authentic'] ?></p><br>
            <!-- You may choose not to display sensitive information like front_image, back_image, and photo -->
            <p><a href="../../backend/voter/edit-profile.php">Edit Profile</a></p>
        </div>
        <?php if (!empty($row['photo'])): ?>
            <div class="profile-picture">
                <img src="../../../uploads/profile_picture/<?=$row['photo']?>" alt="Profile Picture">
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
