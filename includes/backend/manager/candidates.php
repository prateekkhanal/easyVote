<?php

session_start();

include '../../../connect.php';
include "../../../sidebar/right/view-election.php";
include "../../../sidebar/sidebar.php";
include "../../regular_functions.php";

displayMessage();

?>

<style>
	table {
	 font-size: 25px;
	min-width: 800px;
}
	button {
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
.main {
	max-width: 900px;
}
h1 {
	font-size: 1.3em;
}
</style>
<div class="main">
<?php
if (isset($_GET['eid'])) {
	$eid = $_GET['eid'];
if (isset($_SESSION['vid'])) {
	// check if the user has already created election
	if ($_SESSION['role'] == 'manager') {
		// continue
		include './check-for-this-election.php';
		include "./view-election.php";
		include './manage-candidate.php';
		?>
	<?php
	} else {
		echo "You need to switch role to manager to view the candidates!";
	}

} else {
	$_SESSION['msg'] = "You need to login first!";
	redirectHere($_SERVER['PHP_SELF']);
	header("Location: ../../../signin.php");
}
} else {
	echo 'Election not chosen to view the candidates!';
}
?>
</div>
