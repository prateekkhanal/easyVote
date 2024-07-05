<?php
 session_start();
 include "../../regular_functions.php";
 include "../../../connect.php";
 include "../../../sidebar/sidebar.php";
 displayMessage();
 $s = $_GET['s'];
 $r = $_GET['r'];
 $sql = "SELECT name, email FROM voters WHERE voterID = '$s' UNION ALL SELECT name, email FROM voters WHERE  voterID = '$r'";

 /* echo $sql; */
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
<style>
	form input, select, textarea {
		font-size: 20px;
		max-width: 700px;
}
	button {
	font-size: 25px;
}
	
	form {
		padding: 0px;
		padding-bottom: 0px;
}
.form {
	padding-top: 50px;
	max-width: 1300px;
	margin: auto;
}



.form {
    max-width: 800px;
    margin: -20px auto;
    padding: 20px;
    border-radius: 8px;
}

.form h2 {
    color: #444;
}

hr {
    border: 0;
    height: 1px;
    background: #ddd;
    margin: 20px 0;
}

.form div {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #d3d3d32e;
    margin: auto;
    width: max-content;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="text"], input[type="email"], textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 22px;
}

input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
    border-color: #777;
    outline: none;
}

input[type="file"] {
    margin-bottom: 20px;
	font-size: 25px;
}

button {
    padding: 15px 20px;
    background-color: #133150;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    align-self: flex-start;
	font-size: 25px;
	font-weight: bold;
}

button:hover {
    background-color: #0056b3;
}

</style>

<div class="main">
<h2 style="text-align: center;">Email To -> <?=$rName?> (<?=$rRole?>)</h2><hr><br>
<div class="form">

<div style="max-width: max-content;  border-radius: 10px;">
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

</div>
</div>
