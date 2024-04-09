<html>
	<head>
		<title>FAQ</title>
	</head>
	<body>
		<h1>FAQ </h1>
		<a href="faq_add.php">Add an faq</a>
		<table border=2 cellspacing=0 cellpadding=10>
			<thead>
				<th>ID</th>
				<th>Question</th>
				<th>Answer</th>
				<th>Category</th>
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
	<td><?php echo $row['question'] ?></td>
	<td><?php echo $row['answer'] ?></td>
	<td><?php echo $row['category'] ?></td>
	<td>[<a href="faq_update.php?qid=<?php echo $row['qid']; ?>">Edit</a>]<br>[<a href="faq_delete.php?qid=<?php echo $row['qid']; ?>">Delete</a>]</td>
</tr>
<?php
		}
	} 
?>
			</tbody>
		</table>
	</body>
</html>
