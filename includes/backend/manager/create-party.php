<?php
	session_start();
	include "../../../connect.php";
	include "../../../sidebar/sidebar.php";
	include "./view-election.php";

	// Run the script below only if the user hits the submit button
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$description = $_POST['description'];
		$status = $_POST['status'];
		$authentic = $_POST['authentic'];
		$eid = $_GET['eid'];

		// Handling file upload for logo
		if (isset($_FILES['logo'])) {
			$uploadDir = '../../../uploads/party/'; // Directory where images will be uploaded
			$fileName = uniqid(). basename($_FILES['logo']['name']);
			$uploadedFile = $uploadDir . $fileName;

			if (!move_uploaded_file($_FILES['logo']['tmp_name'], $uploadedFile)) {
				$fileName = '';
			} 
		}

		// Generate unique partyID
		$partyID = uniqid();

		$sql = "INSERT INTO parties (partyID, name, eid, description, logo, status, authentic) VALUES ('$partyID', '$name', '$eid', '$description', '$fileName', '$status', '$authentic');";
		echo $sql;
		$result = mysqli_query($conn, $sql);

		if ($result) {
			$_SESSION['msg-success'] = "Party <big>$name</big> added successfully!";
		} else {
			$_SESSION['msg-error'] = "Failed to add the Party!";
		}

		header("Location: list-parties.php?eid=".urlencode($eid)."&et=".urlencode($_GET['et']));
	}
?>

<style>
	table {
	 font-size: 25px;
	min-width: 800px;
}
	.locations a,label,input, textarea, select, button{
		 font-size: 22px;
}

input, textarea {
	width: 500px;
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
	<h2>Create a Party</h2>
</center>
<div style="border:2px; background-color:lightgray; padding: 15px; width:max-content; border-radius: 7px; margin: auto;">
	<form action="" method="POST" enctype="multipart/form-data">

		<label for="name">Name: </label><br>
		<input type="text" id="name" name="name"><br><br>

		<label for="description">Description: </label><br>
		<textarea id="description" name="description" rows="5" cols="50"></textarea><br><br>

		<label for="status">Status: </label><br>
		<select id="status" name="status">
			<option value="open">Open</option>
			<option value="closed">Closed</option>
		</select><br><br>

		<label for="authentic">Authentic: </label><br>
		<select id="authentic" name="authentic">
			<option value="pending">Pending</option>
			<option value="verified" selected>Verified</option>
			<option value="rejected">Rejected</option>
		</select><br><br>

		<label for="logo">Logo: </label><br>
		<input type="file" id="logo" name="logo"><br><br>

		<button name="submit">CREATE</button>
	</form>
</div>

</div>
