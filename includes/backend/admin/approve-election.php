<?php
	session_start();
	include "../../regular_functions.php";
	include "../../../connect.php";
	
	// check if the user is admin
	if (role() != 'admin') {
		$_SESSION['msg'] = "You need to switch-role to ADMIN to approve elections!";
	  	echo "you need to be admin first";
		$_SESSION['redirectTo'] = $_SERVER['PHP_SELF'];
		header("Location: /easyVote/index.php");
	}

	$eid = $_GET['eid'];
	if (!empty($_POST)) {
		$level = $_POST['level'];
		$sql = "update election set level = '$level'
					where electionID='ADxdlkjA@#1' and " .$_SESSION['vid'] . " in (SELECT vid FROM admins)";
		echo $sql;
		$result = mysqli_query($conn, $sql);

		if ($result) {
			$_SESSION['msg-success'] = "Election <big>" . $eid ."</big> level updated to <big>$level</big>!";
		} else {
			$_SESSION['msg-error'] = "Failed to update the role of " . $eid ."!";
		}

		header("Location: view-elections.php?eid=" . urlencode($row['eid']));
	}
?>

<div style="border:2px; background-color:lightgray; min-width: 300px; min-height: 200px; padding: 15px; width:max-content; border-radius: 7px; margin: auto;">
	<h1>Update Level</h1>
	<form action="" method="POST">

		<label for="level">Position: </label><br>
		<select id="level" name="level">
			<option value="pending" <?= ($row['level'] == 'pending') ? 'selected' : '' ?>>Pending</option>
			<option value="national" <?= ($row['level'] == 'national') ? 'selected' : '' ?>>National</option>
			<option value="international" <?= ($row['level'] == 'international') ? 'selected' : '' ?>>International</option>
		</select><br><br>

		<button name="update">Submit</button>
	</form>
</div>

