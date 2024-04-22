<?php
 session_start();
if (isset($_SESSION['msg'])) {
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

<form action="mailer.php" method="POST" enctype="multipart/form-data">
	<label for="email-from">From : </label><br>
	<input type="email" name="email-from" id="email-from" placeholder="Your Email"><br><br>
	<label for="email-to">To : </label><br>
	<input type="email-to" name="email-to" id="email-to" placeholder="easyvote101@gmail.com" disabled><br><br>
	<label for="subject">Subject : </label><br>
	<input type="text" name="subject" id="subject"><br><br>
	<label for="message">Message : </label><br>
	<textarea rows="10" cols="100" name="message" id="message"></textarea><br><br>
	<label for="documents">Required Documents : </label>
	<input type="file" name="documents[]" multiple><br><br>
	<button>Send Email</button>
</form>
