<?php

include "../../../connect.php";

// run the script below only if the user hit the submit button
if (isset($_POST['update'])) {
	$question = $_POST['question'];
	$answer = $_POST['answer'];
	$role = $_POST['role'];
	$category = $_POST['category'];
	$sql = "INSERT INTO faq(`question`,`answer`,`role`, `category`) VALUES('$question', '$answer', '$role', '$category');";
	/* echo $sql; */
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "FAQ added SuccessFully!!!";
	} else {
		echo "Failed to add the FAQ!!";
	}
	include "faq.php";
	die;
}

?>

<h1>Add an FAQ</h1>
<form action="" method="POST">
	<label for="Question">Question : </label><br>
	<textarea id="question" name="question" rows="5" cols="100"></textarea><br><br>
	<label for="answer">Answer : </label><br>
	<textarea id="answer" name="answer" rows="15" cols="100"></textarea><br><br>	
	<label for="role"> Role : </label>
	<select id="role" name="role">
	<option value="%">Any</option>
		<option value="voter">Voter</option>
		<option value="candidate">Candidate</option>
		<option value="manager">Manager</option>
		<option value="admin">Admin</option>
	</select><br><br>
	<label for="category">Category : </label><br>
	<input type="text" id="category" name="category" value="<?= $row['category'] ?>"><br><br>
	<button name="update">Submit</button>
</form>

<br>
