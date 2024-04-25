<?php
include "../../includes/regular_functions.php";
include "../../connect.php";
include "./election-timer.php";
displayMessage();
$eid = $_GET['eid'];
$et = $_GET['et'];

?>
<div>

</div>
<br>
<hr>
<a href="create-role.php?eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>">Create New Role</a>
View Roles:-
<br>
<br>

	<table border=2 cellspacing=0 cellpadding=10>
		<thead>
			<th>Position</th>
			<th>Place</th>
			<th>Actions</th>
		</thead>

		<tbody>
<?php
	$sql = 'SELECT * FROM roles WHERE eid=\''.$_GET['eid'].'\'';
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
?>
		<tr>
			<td><?php echo $row['position'] ?></td>
			<td><?php echo $row['place'] ?></td>
			<td>[<a href="update-role.php?eid=<?=urlencode($eid)?>&et=<?=urlencode($et)?>&rid=<?=$row['rid']?>">Update</a>]<br>[<a href="delete-role.php?eid=<?=urlencode($row['eid'])?>&et=<?=urlencode($_GET['et'])?>&rid=<?=$row['rid']?>&position=<?=$row['position']?>" onclick="if (!confirm('Are you sure you want to DELETE this role?')) {event.preventDefault();}">Delete</a>]</td>
		</tr>
<?php
		}
	} else {
		echo "<tr><td colspan=\"3\" style=\"font-style: italic;\">No roles Created for this election yet!</td></tr>";
	}
?>
		</tbody>
	</table>
<hr>
	Manage Election
<br>
<br>
	<a href="update-election.php?eid=<?=$_GET['eid']?>&et=<?=urlencode($_GET['et'])?>">Edit This Election Details</a>
<br>
<br>
	<a href="list-parties.php?eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>">Manage Parties</a>
