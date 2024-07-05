<?php
	session_start();

	// function to keep track of the redirection history
	function redirectHere($location) {
		$_SESSION['redirectTo'] = $location;
	}

	function redirectBack($backup) {
		if (isset($_SESSION['redirectTo'])) {
			$location = $_SESSION['redirectTo'];
			/* echo "<pre>"; */
			/* print_r($_SESSION); */
			/* die; */
			unset($_SESSION['redirectTo']);
			header("Location: " . $location);
		} else {
			/* echo "the session variable is not set"; */
			header("Location: " . $backup);
		}
	}

	function checkIfAdmin($vid) {
		include "../connect.php";
		$getAdmin = "SELECT * FROM admins WHERE vid = $vid;";
		/* echo $getAdmin; */
		

		$rows = mysqli_query($conn, $getAdmin);
		/* print_r($rows); */
		if ($rows->num_rows > 0) {
			return true;
		}
		return false;
		}

	/* checkIfAdmin(1); */

	function role() {
		return isset($_SESSION['role']) ? $_SESSION['role'] : '';
	}

	function setRole($role) {
		$_SESSION['role'] = $role;
	}

	function displayMessage() {
		if (isset($_SESSION['msg-error'])) {
			echo "<p style=\"background-color: red; color: white; width: 70%; margin: 40px auto; text-align: center;  padding:10px; border-radius: 10px;\" class=\"msg\"><b><big>" . "ERROR : " . $_SESSION['msg-error']. "</big></b></p>";
			unset($_SESSION['msg-error']);
		}
		if (isset($_SESSION['msg-success'])) {
			echo "<p style=\"background-color: green; color: white; padding:10px; margin: 40px auto; border-radius: 10px; width: 70%; \" class=\"msg\"><b><big>" . "SUCCESS : " . $_SESSION['msg-success']. "</big></b></p>";
			unset($_SESSION['msg-success']);
		}

		if (isset($_SESSION['msg'])) {
			echo "<p style=\"background-color: lightgray; color: black; padding:10px; margin: 40px auto; border-radius: 10px; width: 70%; \" class=\"msg\"><b><big>" . "MESSAGE : ". $_SESSION['msg']. "</big></b></p>";  
			unset($_SESSION['msg']);
		}
	}
?>
