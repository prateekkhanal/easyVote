<?php
	session_start();
	include "../../connect.php";
	include "view-election.php";



	// Run the script below only if the user hits the submit button
	if (isset($_POST['submit'])) {
		$position = $_POST['position'];
		$place = $_POST['place'];
		$eid = $_GET['eid'];

		$sql = "INSERT INTO roles (position, place, eid) VALUES ('$position', '$place', '$eid');";
		echo $sql;
		$result = mysqli_query($conn, $sql);

		if ($result) {
			$_SESSION['msg-success'] = "Role added successfully!";
		} else {
			$_SESSION['msg-error'] = "Failed to add the Role!";
		}

		header("Location: manage-election.php?eid=".urlencode($_GET['eid'])."&et=".urlencode($_GET['et']));
		exit;
	}
?>

<div style="border:2px; margin: auto; background-color:lightgray; padding: 15px; width:max-content; border-radius: 7px; ">
	<h1>Create a Role</h1>
	<form action="" method="POST">

		<label for="position">Position: </label><br>
		<input type="text" id="position" name="position"><br><br>

		<label for="place">Place: </label><br>
		<input type="text" id="place" name="place"><br><br>

		<button name="submit">CREATE</button>
	</form>
</div>

