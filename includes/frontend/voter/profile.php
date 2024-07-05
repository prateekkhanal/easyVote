<?php
    session_start();
    include "../../../connect.php";
    include "../../regular_functions.php";
    include "../../../sidebar/left/candidate.php";
    include "../../../sidebar/sidebar.php";

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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 850px; /* Increased max-width to accommodate the image on the right */
            margin: 80px auto;
            background-color: #fff;
            border-radius: 5px;
		}
		.parent {
		padding: 20px 0px;
		padding-bottom: 0px;
		}
		.container.photo {
            display: flex; /* Use flexbox layout */
            align-items: flex-start; /* Align items to the start (top) */
				justify-content: space-around;
				font-size: 1em;
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
            max-width: 400px;
            margin-bottom: 20px;
				margin: auto;
        }
        .profile-picture img {
            max-height: 400px; /* Make sure the image fits within its container */
            display: block; /* Prevent any inline spacing */
            margin: auto; /* Push the image to the right */
				border-radius: 50%;
				
        }


		
.parent {
    max-width: 650px;
    margin: 50px auto;
    background-color: #fff;
    padding: 0px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

h1 {
    color: #444;
    text-align: center;
    margin-bottom: 0px;
}

.container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.container.photo {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.profile-info p {
    margin: 0px;
}

.profile-info label {
    font-weight: bold;
    color: #555;
}

.profile-picture img {
    max-width: 250px;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	margin: auto;
	margin-bottom: 40px;
}

.profile-info a {
    display: inline-block;
    margin-top: 0px;
    padding: 15px 20px;
    background-color: #133150;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
	font-size: 23px;
}

.profile-info a:hover {
    background-color: #0056b3;
}

    </style>
<div class="main">
<br>
	  <h1>Profile</h1>
<hr>
    <div class="container parent">
    <div class="container photo">
        <div class="profile-info">
        <?php if (!empty($row['photo'])): ?>
            <div class="profile-picture">
                <img src="../../../uploads/profile_picture/<?=$row['photo']?>" alt="Profile Picture">
            </div>
        <?php endif; ?>
            <p><label>Name: </label><?= $row['name'] ?></p><br>
            <p><label>Age: </label><?= $row['age'] ?></p><br>
            <p><label>Email: </label><?= $row['email'] ?></p><br>
            <p><label>Citizenship Number: </label><?= $row['citizenship_number'] ?></p><br>
            <p><label>Location: </label><?= $row['location_name'] ?></p><br>
            <p><label>Authentic: </label><?= $row['authentic'] ?></p><br>
            <!-- You may choose not to display sensitive information like front_image, back_image, and photo -->
            <p><a href="../../backend/voter/edit-profile.php">Edit Profile</a></p>
        </div>
	 </div>

</div>
