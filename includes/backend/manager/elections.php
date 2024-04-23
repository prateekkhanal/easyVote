<?php

// check if the user has already created election

include '../../../connect.php';

if (isset($_SESSION['vid'])) {
	echo "User signed in!";
} else {
	header("Location: ../../../signin.php");
}



?>
