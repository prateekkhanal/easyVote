<?php
	session_start();
	include "../../includes/regular_functions.php";
	displayMessage();

	require "../../connect.php";

	$eid = $_GET['eid'];
	$oldTitle = isset($_GET['oldTitle']) ? $_GET['oldTitle'] : '';
	$newTitle = isset($_POST['title']) ? $_POST['title'] : '';

	// Update the new information
	if (isset($_POST['update'])) {
		$title = $_POST['title'];
		$position = $_POST['position'];
		$level = $_POST['level'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
		$lid = $_POST['location'];
		$description = $_POST['description'];

		$sql = "UPDATE election SET title='$title', position='$position', level='$level', start_date='$start_date', end_date='$end_date', start_time='$start_time', end_time='$end_time', lid=$lid, description='$description' WHERE electionID='$eid';";
		$result = mysqli_query($conn, $sql);

		if ($result) {
			$_SESSION['msg-success'] = "<big>". $oldTitle ."</big> Updated Successfully!</big>";
		} else {
			$_SESSION['msg-error'] = "Failed to update <big>" . $oldTitle . "</big>";
		}

		header("Location: election.php");
	}

	// Fetch pre-entered information
	$sql = "SELECT * FROM election WHERE electionID='$eid';";
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();
?>

<div style="border:2px; background-color:lightgray; padding: 15px; width: max-content; border-radius: 7px; ">
<h1>Update Election</h1>
	<form action="?eid=<?=$eid?>&oldTitle=<?=$row['title']?>" method="POST">
		<label for="title">Title: </label><br>
		<input type="text" id="title" name="title" value="<?= $row['title'] ?>"><br><br>

		<label for="position">Position: </label><br>
		<input type="text" id="position" name="position" value="<?= $row['position'] ?>"><br><br>

		<label for="level">Level: </label><br>
		<select id="level" name="level">
			<option value="custom" <?= ($row['level'] == 'custom') ? 'selected' : '' ?>>Custom</option>
			<option value="pending" <?= ($row['level'] == 'pending') ? 'selected' : '' ?>>Request for National/International</option>
		</select><br><br>

		<label for="start_date">Start Date: </label><br>
		<input type="date" id="start_date" name="start_date" value="<?= $row['start_date'] ?>"><br><br>

		<label for="end_date">End Date: </label><br>
		<input type="date" id="end_date" name="end_date" value="<?= $row['end_date'] ?>"><br><br>

		<label for="start_time">Start Time: </label><br>
		<input type="time" id="start_time" name="start_time" value="<?= $row['start_time'] ?>"><br><br>

		<label for="end_time">End Time: </label><br>
		<input type="time" id="end_time" name="end_time" value="<?= $row['end_time'] ?>"><br><br>

		<label for="lid">Location: </label><br>
		<select id="lid" name="location">
			<?php
				$sql = "SELECT * FROM locations;";
				$rows = mysqli_query($conn, $sql);

				if ($rows->num_rows > 0) {
					while($location = $rows->fetch_assoc()) {
			?>
			<option value="<?= $location['lid'] ?>" <?= ($location['lid'] == $row['lid']) ? 'selected' : '' ?>><?= $location['location_name'] ?></option>
			<?php
					}
				}
			?>
		</select><br><br>

		<label for="description">Description: </label><br>
		<textarea id="description" name="description" rows="15" cols="80"><?= $row['description'] ?></textarea><br><br>

		<button name="update">Submit</button>
	</form>
</div>
<br>
