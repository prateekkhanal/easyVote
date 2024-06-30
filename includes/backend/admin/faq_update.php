<?php
	require "../../../connect.php";
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
<h1>Update the FAQ</h1>
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
	<button name="update">Submit</button>
</form>
<br>
