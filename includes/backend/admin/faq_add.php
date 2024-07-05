<?php

session_start();
include "../../../connect.php";
require "../../../sidebar/sidebar.php";

// run the script below only if the user hit the submit button
if (isset($_POST['add'])) {
	$question = $_POST['question'];
	$answer = $_POST['answer'];
	$role = $_POST['role'];
	$category = $_POST['category'];
	$sql = "INSERT INTO faq(`question`,`answer`,`role`, `category`) VALUES('$question', '$answer', '$role', '$category');";
	/* echo $sql; */
	/* die; */
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$_SESSION['msg-success'] = "FAQ added SuccessFully!!!";
	} else {
		$_SESSION['msg-error'] = "Failed to add the FAQ!!";
	}
	header("Location: faq.php");
}

?>

<style>
	form input, select, textarea {
	font-size: 20px;
	font-family: "Lato", sans-serif;
	max-width: 600px;
}
textarea {
	border-radius: 8px;
}
form select, input {
	font-size: 23px;
	width: 300px;
	padding: 2px;
}
	
	form {
		background-color:#80808017;
		margin: auto;
		padding: 30px;
		border-radius: 8px;
		max-width: 600px;
		border: 1px solid #ddd;
}
	form button {
	width: max-content;
	border: 1px solid #000000;
	border-radius: 8px;
	padding: 12px 15px;
	text-decoration: none;
	color: white;
	background-color: #1B4D3E;
	font-weight: bold;
	font-size: 25px;
}
</style>
<div class="main">
<center>
<h1>Add an FAQ</h1>
</center>
<hr><br>
<form action="" method="POST">
	<label for="Question">Question : </label><br>
	<textarea id="question" name="question" rows="5" cols="100"></textarea><br><br>
	<label for="answer">Answer : </label><br>
	<textarea id="answer" name="answer" rows="15" cols="100"></textarea><br><br>	
	<label for="role"> Role : </label><br>
	<select id="role" name="role">
	<option value="anyone">Any</option>
		<option value="voter">Voter</option>
		<option value="candidate">Candidate</option>
		<option value="manager">Manager</option>
		<option value="admin">Admin</option>
	</select><br><br>
	<label for="category">Category : </label><br>
	<input type="text" id="category" name="category" value="<?= $row['category'] ?>"><br><br>
	<button name="add">ADD</button>
</form>

<br>
</div>
