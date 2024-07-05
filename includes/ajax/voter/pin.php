<?php

session_start();

include "../../../connect.php";

$vid = $_GET['vid'];
$eid = $_GET['eid'];

$pinSql = "INSERT INTO pinned_elections (vid, eid) VALUES ($vid, '$eid');";

if (mysqli_query($conn, $pinSql)) {
	/* $_SESSION['msg-success'] = "Election <i><big>$eid</big></i> PINNED successfully!"; */
	echo 'pinned successfully';
} else {
	/* $_SESSION['msg-error'] = "Failed to pin the election <i><big>$eid</big></i>!"; */
	echo 'pinning failed!';
}


?>
