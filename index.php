<?php
	session_start();
if (isset($_SESSION['name'])) {
	echo 'Hello, ' . $_SESSION['name'];
}
?>

<h1>Hello, This is easyVote!</h1>

<h1></h1>
<div>
<a href="logout.php">Logout</a>
</div>
