<?php
	session_start();
	include "../../regular_functions.php";
	include "../../../connect.php";
	displayMessage();
	if (!isset($_SESSION['vid'])) {
			$_SESSION['msg'] = "You need to login first!";
			redirectHere($_SERVER['PHP_SELF']);
			header("Location: ../../../signin.php");
	} else if (role() != 'admin') {
			$_SESSION['msg'] = "You need to switch-role to ADMIN!";
			redirectHere($_SERVER['PHP_SELF']);
			header("Location: ../../../sidebar/right/switch-role.php");
	}

	$getVoterID = "SELECT voterID from voters where vid=".$_SESSION['vid'];
	$adminVoterID = mysqli_query($conn, $getVoterID);
	$adminVID = $adminVoterID->fetch_assoc()['voterID'];

		$vid = $_SESSION['vid'];
	$checkIfAdmin = 'select (CASE
       when ' .$_SESSION['vid'] .' in (select vid from admins) then "yes"
       else "no"
       end ) as is_admin';
	$result = mysqli_query($conn, $checkIfAdmin);
	$answer = $result->fetch_assoc();
	if ($answer['is_admin'] == "yes") {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$vid = $_POST['vid'];
			$addAdmin = "INSERT INTO admins(vid) VALUES (
						(SELECT vid FROM voters WHERE voterID = '$vid'));";
			try {
				if (mysqli_query($conn, $addAdmin)) {
					$_SESSION['msg-success'] = "Added <big>'$vid'</big> as ADMIN successfully!";
				}
			} catch(Exception $e) {
				$_SESSION['msg-error'] = 'Sorry, Voter ID <big>\''.$vid.'\'</big> is INVALID!!';
			}
			header("Location: ".$_SERVER['REQUEST_URI']);
		}
?>
<h2 style="text-align: center;">ADMINISTRATOR - Admins</h2>
<hr>
<br> Add New Admin:<br>
<br>
<form action="" method="post" onsubmit="if (!confirm('Are you sure you want to ADD an ADMIN?')) {event.preventDefault();}">
<input type="text" name="vid" placeholder="Enter the Voter ID">
<button hidden>ADD</button>
</form>
<hr>
	<u>Admins :</u> <br><br>
	
	<table border=2 cellspacing=0 cellpadding=10>
		<thead>
			<th>Image</th>
			<th>Name</th>
			<th>Email</th>
			<th>Voter ID</th>
			<th>Contact</th>
		</thead>

		<tbody>
<?php
		$getAdmins = "SELECT aid, name, email, photo, voterID FROM `admins` join voters on voters.vid = admins.vid; ";
		$admins = mysqli_query($conn, $getAdmins);
		while ($admin = $admins->fetch_assoc()) {
			echo "<pre>";
			/* print_r($admin); */
			echo "</pre>";
?>
		<tr>
			<td><img src="../../../uploads/profile_picture/<?=$admin['photo']?>" height="100px"></td>
			<td><?php echo $admin['name'] ?></td>
			<td><?php echo $admin['email'] ?></td>
			<td><?php echo $admin['voterID'] ?></td>
			<td><a href="../../backend/contact/email.php?s=<?=$adminVID?>&r=<?=$admin['voterID']?>&role=admin">Send an Email</a>
</td>		</tr>
<?php
	}
?>
		</tbody>
	</table>
<?php
	} else {
		echo "You are not admin!";
	}

?>
