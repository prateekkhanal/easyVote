<?php

session_start();
include "../../includes/regular_functions.php";

if (!isset($_SESSION['vid'])) {
	$_SESSION['msg'] = 'You need to login first!';
	redirectHere($_SERVER['PHP_SELF']);
	header("Location: /easyVote/signin.php");
}

$vid = $_SESSION['vid'];
$sql = "SELECT * FROM voters WHERE vid=$vid";

/* echo $sql; */
include "../../connect.php";

$result = mysqli_query($conn, $sql);
/* print_r($result); */
foreach($result as $row) {
	/* print_r($row); */
?>

<div style="font-size: 1.3em; float:left; width:30%; margin-top: 50px">
<b>Name</b> : <?=$row['name'];?> <br><br>
<b>Age</b> : <?=$row['age'];?> <br><br>
<b>Email</b> : <?=$row['email'];?> <br><br>
<b>Citizenship number</b> : <?=$row['citizenship_number'];?> <br><br>
<b>Voter ID</b> : <?=$row['voterID'];?> <br><br>
<b>Verification</b> : <?=$row['authentic'];?> <br><br>
</div>

<div width="50%" style="float:left; margin-top: 50px">

	<img src="/easyVote/uploads/profile_picture/<?php echo $row['photo'];?>" style="border-radius:50%; width:230; margin:0 auto;">
<?php
}
?>
</div>

