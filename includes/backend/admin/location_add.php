<?php
session_start();
include "../../../connect.php";
include "../../../sidebar/sidebar.php";

// run the script below only if the user hit the submit button
if (isset($_POST['update'])) {
	$location = $_POST['location'];
	$sql = "INSERT INTO locations(`location_name`) VALUES('$location');";
	/* echo $sql; */
	/* die; */
	$result = mysqli_query($conn, $sql);
	if ($result) {
		 $_SESSION['msg-success'] = "Location <big>" . $location . "</big> added SuccessFully!!!";
	} else {
		$_SESSION['msg-error'] = "Failed to add the Location <big>" . $location . "</big> !!";
	}
	header("Location: location.php");
	/* die; */
}

?>

<style>
	form button,label,input{
		margin-left: 240px;
		font-size: 25px;
}
.add {
	width: max-content;
	border: 1px solid #000000;
	border-radius: 8px;
	padding: 12px 15px;
	text-decoration: none;
	color: white;
	background-color: #1B4D3E;
	font-weight: bold;
}
</style>
<div class="main">
<center>
<h1>Add a LOCATION</h1>
</center>
<hr><br>
<form action="" method="POST">
	<label for="location">Location : </label><br>
	<input type="text" id="location" name="location" value="<?= $row['location'] ?>" placeholder="Location Name"><br><br>
	<button name="update" class="add">ADD</button>
</form>

<br>

</div>
