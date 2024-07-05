<?php

	include "../../../connect.php";
	include "../../../sidebar/sidebar.php";
	include "../../regular_functions.php";

	session_start();
	displayMessage();
	
	if (isset($_SESSION['vid'])) {
		$vid = $_SESSION['vid'];
		if ($_SESSION['role'] == 'candidate') {
			if (isset($_GET['eid'])) {
				$eid = $_GET['eid'];
				$getInfoSql = "SELECT *, candidate.description as moto FROM candidate JOIN roles on roles.rid = candidate.rid where vid = (SELECT voterID from voters where vid = $vid) and candidate.eid = '$eid';";
				/* echo $getInfoSql; */
				$result = mysqli_query($conn, $getInfoSql);
				if ($result->num_rows == 1) {
					$info = $result->fetch_assoc();
					if ($info['verified'] == 'pending') {
					echo "<pre>";
					/* print_r($info); */
					echo "</pre>";

					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						/* echo 'Form was submitted'; */
						echo "<pre>";
						/* print_r($_POST); */
						echo "</pre>";
						$pid = $_POST['pid'];
						$moto = $_POST['moto'];
						$updateSql = "UPDATE candidate SET pid = '$pid', description='$moto' WHERE '".$info['candidateID']."' = (SELECT candidateID from candidate where vid = '". $info['vid'] ."' AND eid = '". $info['eid'] . "') AND candidate.cid = ".$info['cid']."";
						/* echo $updateSql; */
						if (mysqli_query($conn, $updateSql)) {
							$_SESSION['msg-success'] = "Your Candidate Profile <big><i>".$info['candidateID']."</i></big> UPDATED SUCCESSFULLY!";
							header("Location: " . $_SERVER['REQUEST_URI']);
						}
					}


?>

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
		.description {
			max-width: 800px;
			padding: 20px;
			font-size: 0.8em;
			margin: auto;
		}
		textarea {
			font-size: 0.8em;
			max-width: 800px;;
		}
        h1 {
            text-align: center;
				margin-bottom: 40px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            margin-top: 20px;
				font-size: 20px;
        }
        input[type="text"],
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
				font-weight: bold;
				text-transform: uppercase;
				font-size: 0.7em;
        }
		  button:nth-last-child(1) {
				float: right;
				background-color: maroon;
				padding: 13px;
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

<div class="main">
<form action="" method="POST">

    <div class="container">
			<p><a href="javascript: void(location.reload())" id="reset">RESET</a></p>
		 <h1>Update Profile</h1>
		 <form action="" method="post" enctype="multipart/form-data" style="clear: both; margin-top: 35px;">
			  <label for="party">Party</label>
					<select name="pid" id="party">
					<?php 
					$getParties = "SELECT * FROM parties where eid = (select eid from parties where partyID = '". $info['pid']."')";
					/* echo $getParties; */
					$parties = mysqli_query($conn, $getParties);
					if ($parties->num_rows > 0) {
							while ($party = $parties->fetch_assoc()) {
								echo "<pre>";
								/* print_r($party); */
								echo "</pre>";
						?>
							<option value="<?=$party['partyID']?>" <?=($party['partyID'] == $info['pid']) ? "selected" : ''?>><?=$party['name']?> <i>(<?=$party['partyID']?>)</i></option>
						<?php
							}
						} else {echo "No Parties are yet created in this election!";}
					?>
					</select><br>
			  <!-- files -->
		  <label for="description">Description</label>
		  <textarea id="moto" name="moto" rows="4" cols="60"><?=$info['moto']?></textarea>
		<br>
		<br>
			  <button type="submit" onclick="if (!confirm('Are you sure you want to Update your Profile?')) {event.preventDefault();}">Update</button>
		 </form>
<!-- INSERT INTO `candidate` (`cid`, `candidateID`, `vid`, `eid`, `pid`, `rid`, `description`, `verified`) VALUES (NULL, 'aXawEc31@48*', '6627a5ee7f027', 'ADxdlkjA@#1', 'lkjXC@#!35K', '1', 'I want to be like balen shah!', 'pending');  -->
		 <button type="submit" onclick="if (confirm('Are you sure you want to Delete your Profile?\n\nAll your information will be lost')) {deleteRequest('<?=$info['vid']?>', '<?=$info['cid']?>', '<?=$info['candidateID']?>', '<?=$info['eid']?>');} else {event.preventDefault();}">Delete</button>
	</div>
	<div class="description">
		<big><i><b>NOTES:</b></i></big>
		<ul>
			<li>You can only update your <i><u>description</u></i> or change your <i><u>party</u></i></li>
			<li>To change role:
				<ul>
				<li>Delete this current request</li>
				<li>Create a new Request</li>
				</ul>
			</li>
		</ul>

	</div>
<script>
	function deleteRequest(vid, cid, candidateID, eid) {
		event.preventDefault();
		  var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText);
			window.location.href = '../candidate/dashboard.php';
      }
    };
    xmlhttp.open("GET", `../../ajax/candidate/delete-request.php?vid=${encodeURIComponent(vid)}&cid=${encodeURIComponent(cid)}&cID=${encodeURIComponent(candidateID)}&eid=${encodeURIComponent(eid)}`, true);
    xmlhttp.send();
		
	}
</script>
<?php
					} else {
						$_SESSION['msg'] = "Your Account is <i>ALREADY VERIFIED</i>! You can't make any Updates!";
						displayMessage();
					}
				} else {
					echo "Invalid Election URL or No Requests Made to this Election yet!";
				}

			} else {
				echo "No election is selected to update!";
			}
	} else {
		echo "You need to switch-role to Candidate first!";
	}
	} else {
		echo "You need to login first!";
	}
?>

</div>
