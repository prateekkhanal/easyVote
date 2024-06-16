<?php

session_start();

include "../../../connect.php";

$vid = $_GET['vid'];
$eid = $_GET['eid'];

$unpinSql = "DELETE FROM pinned_elections WHERE vid = $vid AND eid = '$eid'";

if (mysqli_query($conn, $unpinSql)) {
	$_SESSION['msg-success'] = "Election <i><big>$eid</big></i> UNPINNED successfully!";
	echo 'Unpinned successfully!';
} else {
	$_SESSION['msg-error'] = "Failed to unpin the election <i><big>$eid</big></i>!";
	echo 'Unpinning Failed!';
}

/* echo $unpinSql; */

?>
