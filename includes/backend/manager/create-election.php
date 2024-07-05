<?php
	session_start();
	include "../../../connect.php";
	include "../../../sidebar/sidebar.php";

	$sql = "SELECT * FROM locations;";
	/* echo $sql; */
	$rows = mysqli_query($conn, $sql);
	// run the script below only if the user hit the submit button
	if (isset($_POST['submit'])) {
		 $vid = $_SESSION['vid'];
		 $title = $_POST['title'];
		 $level = $_POST['level'];
		 $view = $_POST['view'];
		 $start_date = $_POST['start_date'];
		 $end_date = $_POST['end_date'];
		 $start_time = $_POST['start_time'];
		 $end_time = $_POST['end_time'];
		 $lid = $_POST['location'];
		 $electionID = uniqid();
		 $description = $_POST['description'];

		 $sql = "INSERT INTO election (vid, title, level, view, start_date, end_date, start_time, end_time, lid, electionID, description) VALUES ('$vid', '$title', '$level', '$view', '$start_date', '$end_date', '$start_time', '$end_time', '$lid', '$electionID', '$description');";

		 $result = mysqli_query($conn, $sql);
		 if ($result) {
			  $_SESSION['msg-success'] = "Election titled <big>" . $electionID . "</big> added successfully!";
		 } else {
			  $_SESSION['msg-error'] = "Failed to add the Election titled <big>" . $title . "</big>!";
		 }
		 header("Location: election.php");
	}

?>
<style>
.election div {
	margin: auto;
	padding: 15px;
}
label {
    display: inline-block;
    margin-bottom: 10px;
	font-size: 20px;
}

input, select, textarea {
    width: 600px;
    padding: 8px;
    margin: 0px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
	font-size: 20px;
}

.election form button {
	font-size: 25px;
}
input[type="text"]:focus, select:focus {
    border-color: #777;
    outline: none;
}
</style>
<div class="main">
<div class="election">
<center>
	<h1>Create an Election</h1>
</center>
<hr>
<div style="border:2px; background-color:#d3d3d33b; padding: 15px; width:max-content; border-radius: 7px; ">
	<form action="" method="POST">

		 <label for="title">Title: </label><br>
		 <input type="text" id="title" name="title"><br><br>

		 <label for="level">Level: </label><br>
		 <select id="level" name="level">
			  <option value="custom">Custom</option>
			  <option value="national" disabled>National</option>
			  <option value="international" disabled>International</option>
		 </select><br><br>

		 <label for="view">View: </label><br>
		 <select id="view" name="view">
			  <option value="private" selected>Private</option>
			  <option value="public">Public</option>
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

</div>
</div>
