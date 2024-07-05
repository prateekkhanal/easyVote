<?php
session_start();
	include "../../../sidebar/sidebar.php";
	include "../../regular_functions.php";
	displayMessage();


?>
<style>
.faqs {
	padding-top: 50px;
	max-width: 1200px;
	margin: auto;
}



table {
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: left;
    background-color: #fff;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    vertical-align: top; /* Ensure vertical alignment */
}

th {
    background-color: #f4f4f4;
    color: #333;
    text-transform: uppercase;
    font-weight: 600;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

caption {
    font-size: 24px;
    font-weight: bold;
    margin: 10px 0;
    color: #333;
}

td:nth-child(2), td:nth-child(3) {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
table, select {
font-size: 25px;
}
table {
	min-width : 700px;
	max-width: 700px;
}
table a {
margin : auto;
}

.add {
	width: max-content;
	border: 1px solid #000000;
	border-radius: 8px;
	padding: 12px 15px;
	text-decoration: none;
	color: white;
	background-color: #1B4D3E;
	font-weight: bold;
}
</style>

<div class="main">
<div class="faqs">
<center>
		<h2 style="color: red;">ADMINISTRATOR - FAQs </h2>
<hr><br>
		<a href="faq_add.php" class="add">Add an faq</a>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<br><br>
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
	<td style="max-width: 300px;" class="truncate"><?php echo $row['question'] ?></td>
	<td style="max-width: 350px;" class="truncate"><?php echo $row['answer'] ?></td>
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
	<td><a href="faq_update.php?qid=<?php echo $row['qid']; ?>"><img src="/easyVote/uploads/icons/edit.png"></a><a href="faq_delete.php?qid=<?php echo $row['qid']; ?>"><img src="/easyVote/uploads/icons/delete.png"></a></td>
</tr>
<?php
		}
	} 
?>
			</tbody>
		</table>
	</center>
</div>
</div>
