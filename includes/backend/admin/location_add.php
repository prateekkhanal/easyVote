<?php
session_start();
include "../../../connect.php";

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

<h1>Add a LOCATION</h1>
<form action="" method="POST">
	<label for="location">Location : </label><br>
	<input type="text" id="location" name="location" value="<?= $row['location'] ?>"><br><br>
	<button name="update">Submit</button>
</form>

<br>
