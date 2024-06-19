<?php
	session_start();
	include "../../../connect.php";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$vid = $_SESSION['vid'];
		$cid = urldecode($_POST['cid']);
	if (empty($vid) || empty($cid)) {
		echo "Vote Failed! Invalid VoterID or CandidateID!";
	} else {
		$voteQuery = "INSERT INTO votes (vid, cid) VALUES((SELECT voterID from voters WHERE vid = $vid), '$cid')";
		/* echo $voteQuery; */
		try {
		$vote = mysqli_query($conn, $voteQuery);
			$_SESSION['msg-success'] = "Voted Successfully!";
		} catch (Exception $e) {
			$_SESSION['msg-error'] = "Voting Failed! You have already Voted for this candidate!";
		}
	}
	}
	include "can-i-vote.php";
	displayMessage();
	echo "<pre>";
	/* print_r($_SERVER); */
	echo "</pre>";
	displayMessage();
	if ($canVote) {
		$_SESSION['msg-success'] = 'You meet all the necessary requirements to vote for a candidate!';

	if ($time == 'started') {
		$_SESSION['msg'] = 'Election has started! Vote Before time runs out!';
	}else if ($time == 'ended' && !$voteAlready) {
		$_SESSION['msg-error'] = 'Election has ended! You can no longer participate in this election!';
	}else if ($time == 'not-started') {
		$_SESSION['msg'] = 'Election hasn\'t started yet! You must wait to participate!';
	}
	} else if (!$voteAlready){
		$_SESSION['msg-error'] = 'You aren\'t allowed to vote! Please visit the <i>Can I Vote?</i> page!';
	}
	if ($voteAlready) {
		$_SESSION['msg'] = 'You have already voted for a candidate in this election!';
	}
	displayMessage();
	if ($voteAlready && $time == 'ended') {
		$_SESSION['msg-error'] = 'Election has ended!';
	}
	displayMessage();

	$rid = $_GET['rid'];

	$candidateQuery = "
	SELECT voters.photo, voters.name, voters.age, candidate.candidateID, roles.position, roles.place, parties.name as party, parties.partyID, candidate.description
	FROM candidate
	JOIN voters on voters.voterID = candidate.vid
	JOIN parties ON parties.partyID = candidate.pid
	JOIN roles on roles.rid = candidate.rid
	WHERE roles.rid = '$rid'
	";

	/* echo $candidateQuery; */

	$candidate = mysqli_query($conn, $candidateQuery);

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.candidate {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 540px;
  margin: auto;
  text-align: center;
  font-family: arial;
	font-size: 23px;
	padding: 0px;
	padding-top: 20px;
	display: inline-block;
	margin: 50px 50px auto;
}

.ID {
  color: grey;
  font-size: 25px;
  padding-top: 0px;
  margin-top: 0px;

}
.candidate h1 {
	margin-bottom: 5px;
	font-size: 40px;
}
.candidate img {
	max-height: 300px;
	width: auto;
	border-radius: 50%;
}
button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 18px;
  color: white;
  background-color: #002D72;
  text-align: center;
  cursor: pointer;
  width: 100%;
	font-weight: bold;
  font-size: 33px;
	text-transform: uppercase;
	margin-bottom: 0px;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}
.candidate .details {
	text-align: left;
	padding-left: 50px;
	padding-right: 50px;
	padding-top: 1px;
	min-height: 200px;
}
.details p {
	overflow: hidden;
	text-overflow: ellipsis;
}
.details big {
	font-size: 27px;
	font-weight: bold;
}
button:hover, a:hover {
  opacity: 0.7;
}
</style>
</head>
<body>

<h2 style="text-align:center">Candidates</h2>

<?php
	if ($candidate->num_rows > 0) {
?>
<?php
		while ($candidateInfo = $candidate->fetch_assoc()) {
		/* print_r($candidateInfo); */
?>
	<div class="candidate">

	<img src="/easyVote/uploads/profile_picture/<?=$candidateInfo['photo']?>" alt="John">
	<h1><?=$candidateInfo['name']?></h1>
	<p class="ID"><?=$candidateInfo['candidateID']?></p>
	  <div class="details">
	  <p><big>Party:</big> <i><?=$candidateInfo['party']?></i> (<span class="ID"><?=$candidateInfo['partyID']?></span>)</p>
	  <p><big>Moto:</big> <?=$candidateInfo['description']?></p>
	  </div>
		<form action="" method="POST">
		<p><button name="cid" value="<?=urlencode($candidateInfo['candidateID']);?>" onclick="voteAuth('<?=$candidateInfo['candidateID']?>')" <?php if ($voteAlready || $time != 'started' || !empty($failures)) {echo 'disabled onmouseover="this.style.cursor= \'not-allowed\';" style="cursor: not-allowed; background-color: '; if (($candidateInfo['candidateID'] == $votedFor)) {echo 'black;"';} else {echo 'lightgray;"';}}?>>Vote<?php if ($candidateInfo['candidateID'] == $votedFor) {echo 'd';}?></button></p>
		</form>
	</div>
<?php
		}
	} else {
		echo "<h2>The Role is invalid!</h2>";
	}
?>


</div>
<!-- <button onclick="voteAuth('dF12#(8cBf/')" onmouseover="this.style.cursor= 'not-allowed'; this.style.backgroundColor = 'lightgray'" style="cursor: not-allowed; background-color: lightgray;" disabled>Vote</button> -->


<script>
function voteAuth(cid) {
	console.log("function call", cid);
	var userInput = window.prompt('Enter ID of the candidate for confirmation : '+ cid);
	if (userInput == cid) {
		console.log("You have successfully Voted for "+cid+"!");
		/* vote(<?=$vid?>, cid); */
		/* window.location = '?rid='+<?=$rid?>+'&cid='+cid; */
	} else {
		alert("Invalid Candidate ID! Vote Failed!");
		event.preventDefault();
	}
}

function vote(vid, cid) {
	console.log(vid, cid);
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText);
			// Create the new element you want to append
			const newElement = document.createElement('div');
			newElement.textContent = this.responseText;

			// Get the target element where you want to append the new element
			const targetElement = document.getElementsByTagName('body');

			// Get the first child of the target element
			const firstChild = targetElement.firstChild;

			// Insert the new element before the first child
			targetElement.insertBefore(newElement, firstChild);

      }
    };
	xmlhttp.open("GET", "../../ajax/voter/vote.php?vid="+encodeURIComponent(vid)+"&cid="+encodeURIComponent(cid), true);
    xmlhttp.send();
}
</script>
</body>
</html>
