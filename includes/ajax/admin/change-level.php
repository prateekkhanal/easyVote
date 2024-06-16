<?php
session_start();
include "../../regular_functions.php";
include "../../../connect.php";
displayMessage();

if (role() == 'admin') {
	$eid = $_GET['eid'];
	$level = $_GET['level'];
	$sql = "UPDATE election SET level = '$level' where electionID = '$eid' AND ". $_SESSION['vid'] ." in (SELECT vid FROM admins)";
	echo $sql;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$affected_rows = mysqli_affected_rows($conn);
		if ($affected_rows == 1) {
			$_SESSION['msg-success'] = "Election <big>$eid</big> level Updated to <big>$level</big>";
			echo $_SESSION['msg-success'];
		} else {
			$_SESSION['msg'] = "Election <big>$eid</big>'s level not updated!";
			echo $_SESSION['msg'];
		}
	}
}else {
	 "Not authorized!";
}
