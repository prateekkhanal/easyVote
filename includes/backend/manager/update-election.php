<?php
	session_start();
	include "../../../includes/regular_functions.php";
	include "../../../sidebar/sidebar.php";
	include "view-election.php";
	displayMessage();

	require "../../../connect.php";

	$eid = $_GET['eid'];
	$oldTitle = isset($_GET['oldTitle']) ? $_GET['oldTitle'] : '';
	$newTitle = isset($_POST['title']) ? $_POST['title'] : '';

	// Update the new information
	if (isset($_POST['update'])) {
		$title = $_POST['title'];
		$position = $_POST['position'];
		$level = $_POST['level'];
		$view = $_POST['view'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
		$lid = $_POST['location'];
		$description = $_POST['description'];

		$sql = "UPDATE election SET title='$title', view='$view', level='$level', start_date='$start_date', end_date='$end_date', start_time='$start_time', end_time='$end_time', lid=$lid, description='$description' WHERE electionID='$eid';";
		/* echo $sql; die; */
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
	form input, select, textarea {
	font-size: 20px;
	font-family: "Lato", sans-serif;
	max-width: 600px;
}
textarea {
	border-radius: 8px;
}
form select, input {
	font-size: 23px;
	width: 300px;
	padding: 2px;
}
	
	form {
		margin: auto;
		padding: 30px;
		border-radius: 8px;
		max-width: 600px;
}
	form button {
	width: max-content;
	border: 1px solid #000000;
	border-radius: 8px;
	padding: 12px 15px;
	text-decoration: none;
	color: white;
	background-color: #1B4D3E;
	font-weight: bold;
	font-size: 25px;
}
</style>
<div class="main">
<center>
<h1>Update Election</h1>
</center>
<div style="border:2px; background-color:lightgray; margin:auto; padding: 15px; width: max-content; border-radius: 7px; ">
	<form action="?eid=<?=urlencode($eid)?>&oldTitle=<?=urlencode($row['title'])?>" method="POST">
		<label for="title">Title: </label><br>
		<input type="text" id="title" name="title" value="<?= $row['title'] ?>"><br><br>

		<label for="position">Position: </label><br>
		<input type="text" id="position" name="position" value="<?= $row['position'] ?>"><br><br>

		<label for="level">Level: </label><br>
		<select id="level" name="level">
			<option value="custom" <?= ($row['level'] == 'custom') ? 'selected' : '' ?>>Custom</option>
			<option value="pending" <?= ($row['level'] == 'pending') ? 'selected' : '' ?>>Request for National/International</option>
		</select><br><br>

		<label for="view">View: </label><br>
		<select id="view" name="view">
			<option value="private" <?= ($row['view'] == 'private') ? 'selected' : '' ?>>Private</option>
			<option value="public" <?= ($row['view'] == 'public') ? 'selected' : '' ?>>Public</option>
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
</div>
<br>
