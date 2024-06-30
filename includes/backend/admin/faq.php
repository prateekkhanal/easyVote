<html>
	<head>
		<title>FAQ</title>
<style>


</style>
	</head>
	<body>
<center>
		<h1>FAQs </h1>
<hr><br>
		<a href="faq_add.php">Add an faq</a>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<br><br>
		<table border=2 cellspacing=0 cellpadding=10>
			<thead>
				<th>ID</th>
				<th>Question</th>
				<th>Answer</th>
				<th>Category</th>
				<th>Role</th>
				<th>Action</th>
			</thead>

			<tbody>
<?php
	include "../../../connect.php";
	$getRows = "SELECT * FROM faq;";
	$rows = mysqli_query($conn, $getRows);
	/* print_r($rows); */
	if ($row = $rows->num_rows > 0) {
		while($row = $rows->fetch_assoc()) {
?>
<tr>
	<td><?php echo $row['qid'] ?></td>
	<td style="max-width: 200px;" class="truncate"><?php echo $row['question'] ?></td>
	<td style="max-width: 250px;" class="truncate"><?php echo $row['answer'] ?></td>
	<td><?php echo $row['category'] ?></td>
	<td>
		<select id="role" onchange="getFaqs(document.getElementById('keyword').value, this.value)" style="pointer-events: none; opacity: 1;">
			<option value="%" <?= (!isset($row['role']) ? 'selected' : '' ) ?>>Any</option>
				<option value="voter" <?= (($row['role'] == 'voter') ? 'selected' : '' ) ?>>Voter</option>
				<option value="candidate" <?= (($row['role'] == 'candidate') ? 'selected' : '' ) ?>>Candidate</option>
				<option value="manager" <?= (($row['role'] == 'manager') ? 'selected' : '' ) ?>>Manager</option>
				<option value="admin" <?= (($row['role'] == 'admin') ? 'selected' : '' ) ?>>Admin</option>
			</select>
	</td>
	<td>[<a href="faq_update.php?qid=<?php echo $row['qid']; ?>">Edit</a>]<br>[<a href="faq_delete.php?qid=<?php echo $row['qid']; ?>">Delete</a>]</td>
</tr>
<?php
		}
	} 
?>
			</tbody>
		</table>
	</center>
	</body>
</html>
