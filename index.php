<?php
		session_start();
		/* include "./includes/globals.php"; */

		/* include "./includes/page-url.php"; */
		/* include "./includes/regular_functions.php"; */

		include "./sidebar/sidebar.html";
		include "./sidebar/left/sidebar-left.php";
		
		include "main.php";

		include "./sidebar/right/sidebar-right.php";

?>
