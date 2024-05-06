<?php
 session_start();
 include "../../regular_functions.php";
 displayMessage();
if (isset($_SESSION['msg'])) {
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}

	// get the email from the database if the user is logged in
	if (isset($_SESSION['vid'])) {
		include "../../../connect.php";
		$getEmail = "SELECT email FROM voters WHERE vid = " . $_SESSION['vid'];
		echo $getRows;
		$rows = mysqli_query($conn, $getEmail);
		/* print_r($rows); */
		if ($row = $rows->num_rows > 0) {
			while($row = $rows->fetch_assoc()) {
				$email = $row['email'];
			}
		} else {
			$email = '';
		}
		} else {
			$email = '';
	}
?>

<form action="mailer.php" method="POST" enctype="multipart/form-data">
	<label for="email-from">From : </label><br>
	<input type="email" name="email-from" id="email-from" placeholder="Your Email" value="<?=$email?>"><br><br>
<!--	<label for="email-to">To : </label><br>
	<input type="email-to" name="email-to" id="email-to" placeholder="easyvote101@gmail.com" disabled><br><br> -->
	<label for="subject">Subject : </label><br>
	<input type="text" name="subject" id="subject"><br><br>
	<label for="message">Message : </label><br>
	<textarea rows="10" cols="100" name="message" id="message"></textarea><br><br>
	<label for="documents">Required Documents : </label>
	<input type="file" name="documents[]" multiple><br><br>
	<button>Send Email</button>
</form>
