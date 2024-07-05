<?php
	require "../../../connect.php";
	require "../../../sidebar/sidebar.php";
	include "../../regular_functions.php";

	session_start();
	displayMessage();
	
	$qid = $_GET['qid'];
	//
	// to get the pre-entered information
	$sql = "SELECT * FROM faq WHERE qid=$qid;";
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();
	// to update the new information
	if (isset($_POST['update'])) {
		$question = $_POST['question'];
		$answer = $_POST['answer'];
		$role = $_POST['role'];
		$category = $_POST['category'];
		$sql = "UPDATE faq SET question='$question', answer='$answer',`role` = '$role', `category`='$category' WHERE qid=$qid;";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			$_SESSION['msg-success'] = "FAQ Updated Successfully!!!";
			header("Location: " . $_SERVER['REQUEST_URI']);
		} else {
			$_SESSION['msg-error'] = "Failed to Update the Database Table!";
		}
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
<h1>Update the FAQ</h1>
</center>
<hr><br>
<form action="" method="POST">
	<label for="Question">Question : </label><br>
	<textarea id="question" name="question" rows="5" cols="100"><?= $row['question']?></textarea><br><br>
	<label for="answer">Answer : </label><br>
	<textarea id="answer" name="answer" rows="15" cols="100"><?= $row['answer'] ?></textarea><br><br>	
	<label for="role"> Role : </label>
	<select id="role" name="role">
	<option value="%" <?= ($row['role'] == 'anyone') ? 'selected' : ''?>>Any</option>
	<option value="voter" <?= ($row['role'] == 'voter') ? 'selected' : ''?>>Voter</option>
		<option value="candidate" <?= ($row['role'] == 'candidate') ? 'selected' : ''?>>Candidate</option>
		<option value="manager" <?= ($row['role'] == 'manager') ? 'selected' : ''?>>Manager</option>
		<option value="admin" <?= ($row['role'] == 'admin') ? 'selected' : ''?>>Admin</option>
	</select><br><br>
	<label for="category">Category : </label><br>
	<input type="text" id="category" name="category" value="<?= $row['category'] ?>"><br><br>
	<button name="update">UPDATE</button>
</form>
<br>

</div>
