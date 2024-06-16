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
    $cid = addslashes($_GET['cid']);
	 /* echo $cid; */
	$CandidatesSql = " 
						SELECT *, (SELECT voterID from voters WHERE vid = ". $_SESSION['vid'] . ") as mid, voters.name as name, candidate.description as moto, parties.name as partyName FROM candidate 
						JOIN 		voters 		ON 
						voters.voterID 	=	 candidate.vid 
						JOIN	   roles 		ON 
						roles.rid 			= 	candidate.rid 
						JOIN	   election 		ON 
						election.electionID 			= 	candidate.eid 
						JOIN	   locations 		ON 
						locations.lid 			= 	voters.lid 
						JOIN	   parties 		ON 
						parties.partyID		= 	candidate.pid 
						WHERE candidate.candidateID = '$cid'";

	/* echo $CandidatesSql; */
    $result = mysqli_query($conn, $CandidatesSql);
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
				margin-bottom: 0px;
        }
        .profile-info {
            margin: 20px; /* Add some margin to separate text from image */
        }
        .profile-info p {
            margin: 5px 15px;
        }
        .profile-info label {
            font-weight: bold;
        }
        .profile-picture {
            margin-bottom: 40px;
        }
        .profile-picture img {
            max-height: 250px; /* Make sure the image fits within its container */
            display: block; /* Prevent any inline spacing */
            margin: auto; /* Push the image to the right */
				border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container parent">
	  <h1>Candidate Profile</h1>
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
				<p><label>Election: </label><?= $row['title'] ?> <i>(<?= $row['electionID']?>)</i></p><br>
            <p><label>Role: </label><?= $row['position'] ?></p><br>
				<p><label>Party: </label><?= $row['partyName']?> (<i><?= $row['partyID'] ?></i>)</p><br>
            <p><label>Description: </label><?= $row['moto'] ?></p><br>
            <!-- You may choose not to display sensitive information like front_image, back_image, and photo -->
<?php if ($_SESSION['role'] == 'manager') {
?>
	<p><label>Citizenship Front: </label><br><br><img src="../../../uploads/cs_front/<?=$row['front_image']?>"></p><br>
	<p><label>Citizenship Back: </label><br><br><img src="../../../uploads/cs_back/<?=$row['back_image']?>"></p>
<?php
		  }
?>
    </div>
</body>
</html>
