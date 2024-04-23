<?php

session_start();

if (isset($_SESSION['msg-error'])) {
	echo "<p style=\"background-color: red; color: white; padding:10px; border-radius: 10px;\"><b><big>" . "ERROR : " . $_SESSION['msg-error']. "</big></b></p>";
	unset($_SESSION['msg-error']);
}
if (isset($_SESSION['msg-success'])) {
	echo "<p style=\"background-color: green; color: white; padding:10px; border-radius: 10px;\"><b><big>" . "SUCCESS : " . $_SESSION['msg-success']. "</big></b></p>";
	unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg'])) {
	echo "<p style=\"background-color: lightgray; color: black; padding:10px; border-radius: 10px;\"><b><big>" . "MESSAGE : ". $_SESSION['msg']. "</big></b></p>";  
	unset($_SESSION['msg']);
}
