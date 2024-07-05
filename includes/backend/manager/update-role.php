<?php
	session_start();
	include "../../../includes/regular_functions.php";
	include "../../../sidebar/sidebar.php";
	include "view-election.php";
	displayMessage();

	require "../../../connect.php";

	$rid = $_GET['rid'];
	$eid = isset($_GET['eid']) ? $_GET['eid'] : '';
	$oldPosition = isset($_GET['oldPosition']) ? $_GET['oldPosition'] : '';
	$newPosition = isset($_POST['position']) ? $_POST['position'] : '';

	// Update the new information
	if (isset($_POST['update'])) {
		$position = $_POST['position'];
		$place = $_POST['place'];
		$eid = $_GET['eid'];

		$sql = "UPDATE roles SET position='$position', place='$place', eid='$eid' WHERE rid=$rid;";
		$result = mysqli_query($conn, $sql);

		if ($result) {
			$_SESSION['msg-success'] = "<big>". $oldPosition ."</big> Updated Successfully!";
		} else {
			$_SESSION['msg-error'] = "Failed to update <big>" . $oldPosition . "</big>";
		}

		header("Location: manage-election.php?eid=".urlencode($eid));
	}

	// Fetch pre-entered information
	$sql = "SELECT * FROM roles WHERE rid=$rid;";
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();
?>

<style>
	table {
	 font-size: 25px;
	min-width: 800px;
}
	button {
font-size: 23px;
}
	.locations a,label,input{
		 font-size: 22px;
}
	.locations {
		max-width: 800px;
		margin: auto;
}
	table td {
		padding: 20px;
}
</style>
<div class="main">
<center>
	<h1>Update Role</h1>
</center>
<div style="border:2px; background-color:lightgray; min-width: 300px; min-height: 300px; padding: 15px; width:max-content; border-radius: 7px; margin: auto;">
	<form action="?eid=<?=urlencode($eid)?>&rid=<?=urlencode($rid)?>&oldPosition=<?=urlencode($row['position'])?>" method="POST">

		<label for="position">Position: </label><br>
		<input type="text" id="position" name="position" value="<?= $row['position'] ?>"><br><br>

		<label for="place">Place: </label><br>
		<input type="text" id="place" name="place" value="<?= $row['place'] ?>"><br><br>

		<button name="update">Submit</button>
	</form>
</div>
</div>

