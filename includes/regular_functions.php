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
?>
