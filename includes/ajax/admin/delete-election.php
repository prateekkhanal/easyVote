<?php
session_start();
include "../../regular_functions.php";
include "../../../connect.php";
displayMessage();

if (role() == 'admin') {
	$eid = $_GET['eid'];
	$title = $_GET['title'];
	$sql = "DELETE FROM election where electionID = '$eid' AND ". $_SESSION['vid'] ." in (SELECT vid FROM admins)";
	echo $sql;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$affected_rows = mysqli_affected_rows($conn);
		if ($affected_rows == 1) {
			$_SESSION['msg-success'] = "Election <big>$title</big> DELETED successfully!";
			echo $_SESSION['msg-success'];
		} else {
			$_SESSION['msg'] = "Failed to DELETE Election <big>$title</big>!";
			echo $_SESSION['msg'];
		}
	}
}else {
	echo "Not authorized!";
}
