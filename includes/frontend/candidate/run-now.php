<?php
	session_start();
	include "../../../connect.php";
	include "can-i-run-as-a-candidate.php";
	displayMessage();
	if ($canRun) {
		$_SESSION['msg-success'] = 'You meet all the necessary requirements to run as a candidate!';

	} else {
		$_SESSION['msg-error'] = 'You aren\'t allowed to run as a candidate for this role! Please visit the <i>Can-i-run-as-a-candidate?</i> page!';
	}
	displayMessage();

	$rid = $_GET['rid'];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// handle form submission
		/* echo "<pre>"; */
		/* print_r($_POST); */
		$pid = $_POST['pid'];
		$description = $_POST['moto'];
		$vid = $_SESSION['vid'];
		$candidateID = uniqid();
		$sql = "INSERT INTO candidate (candidateID, vid, eid, pid, rid, description ) VALUES ('$candidateID', (SELECT voterID FROM voters where vid = $vid), (SELECT eid from roles where rid = $rid), '$pid', $rid, \"$description\");";
		/* echo $sql; */
		if (mysqli_query($conn, $sql)) {
			$_SESSION['msg-success'] = "Candidate Request Sent to the Manager!";
			displayMessage();
		}
		/* echo "</pre>"; */
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
		font-size: 1.15em;
		margin: auto;
	}
	textarea {
		font-size: 1.15em;
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
			font-size: 1.15em;
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

<form action="" method="POST">

<div class="container" <?php if (!$canRun) echo "style=\"color: gray;\""?>>
		<p><a href="javascript: void(location.reload())" id="reset">RESET</a></p>
	 <h1>Candidate Request</h1>
	 <form action="" method="post" enctype="multipart/form-data" style="clear: both; margin-top: 35px;">
		  <label for="role">Role</label>
				<select name="rid" id="role">
				<?php 
				$getRoles = "SELECT * FROM roles where eid = (select eid from roles where rid = '". $rid ."') and rid = $rid";
				/* echo $getParties; */
				$roles = mysqli_query($conn, $getRoles);
				if ($roles->num_rows > 0) {
						while ($role = $roles->fetch_assoc()) {
							echo "<pre>";
							print_r($role);
							echo "</pre>";
					?>
						<option value="<?=$role['rid']?>"><?=$role['position']?> <i>(At '<?=$role['place']?>')</i></option>
					<?php
						}
					} else {echo "No Parties are yet created in this election!";}
				?>
				</select><br><br>
		  <!-- files -->
		  <label for="party">Available Parties</label>
				<select name="pid" id="party">
				<?php 
				$getParties = "SELECT * FROM parties where eid = (select eid from roles where rid = '". $rid ."') and status = 'open'";
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
				</select><br><br>
	  <label for="description">Description</label>
	  <textarea id="moto" name="moto" rows="4" <?php if (!$canRun) {echo "style=\"background-color:gray; cursor: not-allowed;\"";}?>cols="60"><?=$info['moto']?></textarea>
	<br><br>
	<br>
	<button type="submit" onclick="<?php echo (!$canRun) ? 'event.preventDefault();' : 'if (!confirm(\'Are you sure you want to send Candidate Request?\')) {event.preventDefault();}'?>" <?php if (!$canRun) {echo "style=\"background-color:gray; cursor: not-allowed;\"";}?>>Apply</button>
	 </form>
<!-- INSERT INTO `candidate` (`cid`, `candidateID`, `vid`, `eid`, `pid`, `rid`, `description`, `verified`) VALUES (NULL, 'aXawEc31@48*', '6627a5ee7f027', 'ADxdlkjA@#1', 'lkjXC@#!35K', '1', 'I want to be like balen shah!', 'pending');  -->
</div>

