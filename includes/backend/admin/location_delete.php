<?php
	session_start();
	include "../../../connect.php";
	$lid = $_GET['lid'];
	$title = $_GET['title'];
	$sql = "DELETE FROM locations WHERE lid=$lid;";
	/* echo $sql; */
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$_SESSION['msg-success'] = "Location <big>" . $title . "</big> Deleted Successfully!!!";
	} else {
		$_SESSION['msg-error'] = "Location  <big>" . $title . "</big> couldn't be deleted!!!";
	}
		header("Location: location.php");
?>
