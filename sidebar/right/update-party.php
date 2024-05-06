<?php
	session_start();
	include "../../connect.php";
	include "view-election.php";

	$pid = $_GET['pid'];
	// Fetch pre-entered information
	$sql = "SELECT * FROM parties WHERE partyID='$pid';";
	echo $sql;
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();

	// Run the script below only if the user hits the submit button
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$description = $_POST['description'];
		$status = $_POST['status'];
		$verified = $_POST['verified'];

		// Handling logo upload
		if ($_FILES['logo']['size'] > 0) {
			$uploadDir = '../../uploads/party/';
			$fileName = uniqid() . basename($_FILES['logo']['name']);
			$uploadedFile = $uploadDir . $fileName;

			// Delete old logo file if it exists
			if (!empty($row['logo'])) {
				$oldLogoPath = $uploadDir . $row['logo'];
				if (file_exists($oldLogoPath)) {
					unlink($oldLogoPath);
					echo "deleted the file!";
				}
			}

			if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadedFile)) {
				// Update logo field only if a new file is uploaded
				$logo = $fileName;
				$sql = "UPDATE parties SET name='$name', description='$description', status='$status', authentic='$verified', logo='$logo' WHERE partyID='$pid';";
				echo $sql;
			} else {
				$sql = "UPDATE parties SET name='$name', description='$description', status='$status', authentic='$verified' WHERE partyID='$pid';";
				echo $sql;
			}
		} else {
			// No new file uploaded, keep the existing logo
			$sql = "UPDATE parties SET name='$name', description='$description', status='$status', authentic='$verified' WHERE partyID='$pid';";
			echo $sql;
		}

		$result = mysqli_query($conn, $sql);

		if ($result) {
			$_SESSION['msg-success'] = "Party <big>" . $name ."</big> updated successfully!";
		} else {
			$_SESSION['msg-error'] = "Failed to update the party " . $name ."!";
		}

		header("Location: list-parties.php?eid=" . urlencode($row['eid']) . "&et=" . urlencode($_GET['et']));
	}
?>

<div style="border:2px; background-color:lightgray; padding: 15px; width:max-content; border-radius: 7px; margin: auto;">
	<h1>Update Party</h1>
	<form action="" method="POST" enctype="multipart/form-data">

		<label for="name">Name: </label><br>
		<input type="text" id="name" name="name" value="<?= $row['name'] ?>"><br><br>

		<label for="description">Description: </label><br>
		<textarea id="description" name="description" rows="5" cols="50"><?= $row['description'] ?></textarea><br><br>

		<label for="status">Status: </label><br>
		<select id="status" name="status">
			<option value="open" <?= ($row['status'] == 'open') ? 'selected' : '' ?>>Open</option>
			<option value="closed" <?= ($row['status'] == 'closed') ? 'selected' : '' ?>>Closed</option>
		</select><br><br>

		<label for="verified">Verified: </label><br>
		<select id="verified" name="verified">
			<option value="pending" <?= ($row['verified'] == 'pending') ? 'selected' : '' ?>>Pending</option>
			<option value="verified" <?= ($row['verified'] == 'verified') ? 'selected' : '' ?>>Verified</option>
			<option value="rejected" <?= ($row['verified'] == 'rejected') ? 'selected' : '' ?>>Rejected</option>
		</select><br><br>

		<label for="logo">Logo: </label><br>
		<input type="file" id="logo" name="logo"><br><br>

		<button name="submit">Submit</button>
	</form>
</div>
