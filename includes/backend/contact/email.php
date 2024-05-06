<?php
 session_start();
 include "../../regular_functions.php";
 include "../../../connect.php";
 displayMessage();
 $s = $_GET['s'];
 $r = $_GET['r'];
 $sql = "SELECT name, email FROM voters WHERE voterID = '$s' UNION ALL SELECT name, email FROM voters WHERE  voterID = '$r'";

 $emails = mysqli_query($conn, $sql);
 if ($emails->num_rows == 2) {
 $sender = $emails->fetch_assoc();
 $sName = $sender['name'];
 $s = $sender['email'];
 $receiver = $emails->fetch_assoc();
 $rName = $receiver['name'];
 $r = $receiver['email'];
 $rRole = $_GET['role'];
 $et = $_GET['et'];
 $eid = $_GET['eid'];
  
?>
	<h2 style="text-align: center;">Email To -> <?=$rName?> (<?=$rRole?>)</h2><hr><br>

<div style="background-color: lightgray; margin: auto; width: max-content; padding: 15px; border-radius: 10px;">
<form action="mailer.php?s=<?=$s?>&r=<?=$r?>&role=<?=$rRole?>" method="POST" enctype="multipart/form-data">
		<input type="text" name="et"  value="<?=$et?>" style="display: none;">
		<input type="text" name="eid"  value="<?=$eid?>" style="display: none;">
		<input type="email" name="email-from" id="email-from" placeholder="Your Email" value="<?=$s?>" style="display: none;">
		<input type="email-to" name="email-to" id="email-to" placeholder="<?=$_GET['r']?>" value="<?=$r?>" style="display: none;" disabled>
		<label for="subject">Subject : </label><br>
		<input type="text" name="subject" id="subject"><br><br>
		<label for="message">Message : </label><br>
		<textarea rows="10" cols="100" name="message" id="message"></textarea><br><br>
		<label for="documents">Required Documents : </label>
		<input type="file" name="documents[]" multiple><br><br>
		<button>Send Email</button>
	</form>
</div>
<?php
} else {
	echo "<i>Invalid URL</i>!";
}
?>
