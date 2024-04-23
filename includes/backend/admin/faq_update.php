<?php
	require "../../../connect.php";
	$qid = $_GET['qid'];
	// to get the pre-entered information
	$sql = "SELECT * FROM faq WHERE qid=$qid;";
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();
	// to update the new information
	if (isset($_POST['update'])) {
		$question = $_POST['question'];
		$answer = $_POST['answer'];
		$category = $_POST['category'];
		$sql = "UPDATE faq SET question='$question', answer='$answer', `category`='$category' WHERE qid=$qid;";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "FAQ Updated Successfully!!!";
		} else {
			echo "Failed to Update the Database Table!";
		}
	}
?>
<h1>Update the FAQ</h1>
<form action="" method="POST">
	<label for="Question">Question : </label><br>
	<textarea id="question" name="question" rows="5" cols="100"><?= $row['question']?></textarea><br><br>
	<label for="answer">Answer : </label><br>
	<textarea id="answer" name="answer" rows="15" cols="100"><?= $row['answer'] ?></textarea><br><br>	
	<label for="category">Category : </label><br>
	<input type="text" id="category" name="category" value="<?= $row['category'] ?>"><br><br>
	<button name="update">Submit</button>
</form>
<br>
