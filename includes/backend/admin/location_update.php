<?php
	session_start();
	include "../../regular_functions.php";
	displayMessage();

	require "../../../connect.php";

	$lid = $_GET['lid'];
	$oldLocation = isset($_GET['oldLocation']) ? $_GET['oldLocation'] : '';
	$newLocation = isset($_POST['location']) ? $_POST['location'] : '';
	echo $newLocation;

	// to update the new information
	if (isset($_POST['update'])) {
		$location = $_POST['location'];
		$sql = "UPDATE locations SET `location_name`='$location' WHERE lid=$lid;";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			$_SESSION['msg-success'] = "<big>". $oldLocation ."</big> Updated into <big>" . $newLocation . "</big>";
		} else {
			$_SESSION['msg-error'] = "Failed to update <big>" . $oldLocation . "</big> into <big> " . $newLocation . "</big>";
		}
		header("Location: location.php");
	}
	
	// to get the pre-entered information
	$sql = "SELECT * FROM locations WHERE lid=$lid;";
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();
?>
<h1>Update the Locations</h1>
<form action="?lid=<?=$lid?>&oldLocation=<?=$row['location_name']?>" method="POST">
	<label for="location">Location : </label><br>
	<input type="text" id="location" name="location" value="<?= $row['location_name'] ?>"><br><br>
	<button name="update">Submit</button>
</form>
<br>
