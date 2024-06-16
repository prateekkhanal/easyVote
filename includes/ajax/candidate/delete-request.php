<?php

session_start();
include "../../../connect.php";
include "../../regular_functions.php";

$eid = $_GET['eid'];
$vid = $_GET['vid'];
$cid = $_GET['cid'];
$cID = $_GET['cID'];

$deleteRequest = "DELETE FROM candidate WHERE cid=$cid AND eid='$eid' AND '$cID' = (SELECT candidateID FROM candidate WHERE vid = '$vid' and eid = '$eid')";
echo $deleteRequest;

if (mysqli_query($conn, $deleteRequest)) {
	$_SESSION['msg-success'] = "Your Candidate Request <i><big>$cID</big></i> has been DELETED SUCCESSFULLY!";
	echo "Your Candidate Request <i><big>$cID</big></i> has been DELETED SUCCESSFULLY!";
} else {
	$_SESSION['msg-error'] = "Your Candidate Request <i><big>$cID</big></i> FAILED TO DELETE!";
	echo "Your Candidate Request <i><big>$cID</big></i> FAILED TO DELETE!";
}
?>
