<?php
session_start();
include "../../../connect.php";
include "view-election.php";
include "../../../sidebar/sidebar.php";

$pid = $_GET['pid'];
// Fetch pre-entered information
$sql = "SELECT * FROM parties WHERE partyID='$pid';";
/* echo $sql; */
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
        $uploadDir = '../../../uploads/party/';
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
<style>
	table {
	 font-size: 25px;
	min-width: 800px;
}
	button, textarea, select, input {
font-size: 23px;
}
	.locations a,label,input{
		 font-size: 22px;
}
	.locations {
		max-width: 800px;
		margin: auto;
}
	table td {
		padding: 20px;
}
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
		margin: auto;
		padding: 30px;
		border-radius: 8px;
		max-width: 600px;
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
    <h1>Update Party</h1>
</center>
<div style="border:2px; background-color:lightgray; padding: 15px; width:max-content; border-radius: 7px; margin: auto;">
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
        <input type="file" id="logo" name="logo" accept="image/*"><br><br>

        <!-- Show the current logo -->
        <?php if (!empty($row['logo'])): ?>
            <img id="currentLogo" src="../../../uploads/party/<?= $row['logo'] ?>" alt="Current Logo" style="max-width: 200px;"><br><br>
        <?php endif; ?>

        <!-- Show the new logo preview -->
        <img id="previewLogo" src="#" alt="New Logo Preview" style="max-width: 200px; display: none;">

        <button name="submit">Update</button>
    </form>
</div>

<script>
    // Preview the new logo when selected
    document.getElementById('logo').addEventListener('change', function(event) {
        var preview = document.getElementById('previewLogo');
        var current = document.getElementById('currentLogo');
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (current) {
                current.style.display = 'none';
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
            if (current) {
                current.style.display = 'block';
            }
        }
    });
</script>
</div>
