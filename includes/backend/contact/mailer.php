<?php
	 session_start();
	$s = $_GET['s'];
	$r = $_GET['r'];
	$role = $_GET['role'];
	$et = $_POST['et'];
	$eid = $_POST['eid'];
	if ($et != '' && $eid != '') {
		$election = 'Election : '. $et .' ('.$eid .')<br><br><br> ';
	} else {
		$election = '';
	}
	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
	require 'vendor/autoload.php';

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
		 //Server settings
		 $mail->isSMTP();                                            //Send using SMTP
		 $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		 $mail->Username   = 'easyvote101@gmail.com';                     //SMTP username
		 $mail->Password   = 'sjtw slql rhyn pktw';                               //SMTP password
		 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		 $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		 //Recipients
		 $mail->addAddress('khanalprateek101@gmail.com');               //Name is optional
		 $mail->addAddress('easyvote101@gmail.com');               //Name is optional
		 $mail->addAddress($_GET['r']);               //Name is optional
		 foreach($_FILES['documents']['name'] as $key => $value){
		 $filename = uniqid().$_FILES['documents']['name'][$key];
		 if (move_uploaded_file($_FILES['documents']['tmp_name'][$key], 'uploads/'.$filename)) {
			  $mail->addAttachment('uploads/'.$filename, $_FILES['documents']['name'][$key]);
		 }
		
		 }
		
		 //Content
		 $mail->isHTML(true);                                  //Set email format to HTML
		 $mail->Subject = $_POST['subject'];
		 $mail->Body    = 'From: ' . $s . "(".$_SESSION['role'].")<br>To : You (". $role .")<br><br><br> ". $election.  $_POST['message'];
		 $mail->AltBody = $_POST['message'];

		 $mail->send();
		 $_SESSION['msg-success'] = 'Message has been sent';

	} catch (Exception $e) {
		  $_SESSION['msg-error'] = "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
	}
		 /* header("Location: ./email.php"); */
?>
	<script>
		window.history.back();
	</script>
