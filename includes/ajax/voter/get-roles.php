<?php

include "../../../connect.php";

$eid = $_GET['eid'];
$rolesQuery = "SELECT roles.position, roles.place, roles.make_request from
				election 
				join roles 
				on election.electionID = roles.eid
				 where election.electionID = '$eid';";

$rolesResult = mysqli_query($conn, $rolesQuery);


if ($rolesResult->num_rows > 0) {
		$roles = '
      <strong style="display: block;">Roles:</strong>
				<table>
					<thead>
				  <tr>
					 <th>Position</th>
					 <th>Place</th>
					 <th>Authentication</th>
				  </tr>
					</thead>
					<tbody>
		';
	while ($role = $rolesResult->fetch_assoc()) {
		$roles .= '<tr>
			<td>'.$role['position'].'</td>
			<td>'.$role['place'].'</td>
			<td>'.$role['make_request'].'</td>
			</tr>';
	}
		$roles .= '
					</tbody>
					</table>
		';

} else {
	$roles = "<i><big>No Roles are yet defined in this election</big></i>";
}

echo $roles;
