<?php
	session_start();
	include "../../connect.php";

	$sql = "SELECT * FROM locations;";
	/* echo $sql; */
	$rows = mysqli_query($conn, $sql);
	// run the script below only if the user hit the submit button
	if (isset($_POST['submit'])) {
		 $vid = $_SESSION['vid'];
		 $title = $_POST['title'];
		 $position = $_POST['position'];
		 $level = $_POST['level'];
		 $start_date = $_POST['start_date'];
		 $end_date = $_POST['end_date'];
		 $start_time = $_POST['start_time'];
		 $end_time = $_POST['end_time'];
		 $lid = $_POST['location'];
		 $electionID = uniqid();
		 $description = $_POST['description'];

		 $sql = "INSERT INTO election (vid, title, position, level, start_date, end_date, start_time, end_time, lid, electionID, description) VALUES ('$vid', '$title', '$position', '$level', '$start_date', '$end_date', '$start_time', '$end_time', '$lid', '$electionID', '$description');";

		 $result = mysqli_query($conn, $sql);
		 if ($result) {
			  $_SESSION['msg-success'] = "Election titled <big>" . $electionID . "</big> added successfully!";
		 } else {
			  $_SESSION['msg-error'] = "Failed to add the Election titled <big>" . $title . "</big>!";
		 }
		 header("Location: election.php");
	}

?>
<div style="border:2px; background-color:lightgray; padding: 15px; width:max-content; border-radius: 7px; ">
	<h1>Create an Election</h1>
	<form action="" method="POST">

		 <label for="title">Title: </label><br>
		 <input type="text" id="title" name="title"><br><br>

		 <label for="position">Position: </label><br>
		 <input type="text" id="position" name="position"><br><br>

		 <label for="level">Level: </label><br>
		 <select id="level" name="level">
			  <option value="custom">Custom</option>
			  <option value="national" disabled>National</option>
			  <option value="international" disabled>International</option>
		 </select><br><br>

		 <label for="start_date">Start Date: </label><br>
		 <input type="date" id="start_date" name="start_date"><br><br>

		 <label for="end_date">End Date: </label><br>
		 <input type="date" id="end_date" name="end_date"><br><br>

		 <label for="start_time">Start Time: </label><br>
		 <input type="time" id="start_time" name="start_time"><br><br>

		 <label for="end_time">End Time: </label><br>
		 <input type="time" id="end_time" name="end_time"><br><br>

		 <label for="lid">Location : </label><br>
		 <select id="lid" name="location">
<?php
	if ($row = $rows->num_rows > 0) {
		print_r($row);
		while($row = $rows->fetch_assoc()) {
			
?>
	<option value="<?=$row['lid']?>"><?=$row['location_name']?></option>
<?php
		}
	}
?>
		 </select><br><br>

		 <label for="description">Description: </label><br>
		 <textarea id="description" name="description" cols="80" rows="15"></textarea><br><br>

		 <button name="submit">CREATE</button>
	</form>
</div>
