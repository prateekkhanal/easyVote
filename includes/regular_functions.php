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

	function role() {
		return isset($_SESSION['role']) ? $_SESSION['role'] : '';
	}

	function displayMessage() {
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
	}
?>
