<?php
	include "can-i-vote.php";
	include "../../../connect.php";
	
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

<h2 style="text-align:center">User Profile candidate</h2>

<?php
	if ($candidate->num_rows > 0) {
?>
<?php
		while ($candidateInfo = $candidate->fetch_assoc()) {
		/* print_r($candidateInfo); */
?>
	<div class="candidate">
	<img src="../../../uploads/profile_picture/<?=$candidateInfo['photo']?>" alt="John">
	<h1><?=$candidateInfo['name']?></h1>
	<p class="ID"><?=$candidateInfo['candidateID']?></p>
	  <div class="details">
	  <p><big>Party:</big> <i><?=$candidateInfo['party']?></i> (<span class="ID"><?=$candidateInfo['partyID']?></span>)</p>
	  <p><big>Moto:</big> <?=$candidateInfo['description']?></p>
	  </div>
	  <p><button onclick="voteAuth('<?=$candidateInfo['candidateID']?>')">Vote</button></p>
	</div>
<?php
		}
	} else {
		echo "<h2>The Role is invalid!</h2>";
	}
?>


</div>
<button onclick="voteAuth('dF12#(8cBf/')" onmouseover="this.style.cursor= 'not-allowed'; this.style.backgroundColor = 'lightgray'" style="cursor: not-allowed; background-color: lightgray;">Vote</button>


<script>
function voteAuth(cid) {
	console.log("functoin call", cid);
	var userInput = window.prompt('Enter ID of the candidate for confirmation : '+ cid);
	if (userInput == cid) {
		console.log("You have successfully Voted for "+cid+"!");
		/* window.location = '?rid='+<?=$rid?>+'&cid='+cid; */
	} else {
		alert("Invalid Candidate ID! Vote Failed!");
	}
}
</script>
</body>
</html>
