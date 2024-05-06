<?php
	session_start();
	include "../../connect.php";

	$eid = $_GET['eid'];
	$vid = $_GET['vid'];
	$title = $_GET['title'];

	$sql = "DELETE FROM election WHERE electionID='$eid' AND vid=".$_SESSION['vid'];
	$result = mysqli_query($conn, $sql);

	if ($result) {
		$_SESSION['msg-success'] = "Election <big>" . $title . "</big> Deleted Successfully!!!";
	} else {
		$_SESSION['msg-error'] = "Election <big>" . $title . "</big> couldn't be deleted!!!";
	}

	header("Location: election.php");
?>
