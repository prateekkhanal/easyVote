<?php

include "../../../connect.php";

$cid = $_GET['cid'];

$candidateQuery = "
SELECT voters.photo, voters.name, voters.age, candidate.candidateID, roles.position, roles.place, parties.name as party, parties.partyID, candidate.description
FROM candidate
JOIN voters on voters.voterID = candidate.vid
JOIN parties ON parties.partyID = candidate.pid
JOIN roles on roles.rid = candidate.rid
WHERE candidate.candidateID = '$cid'
";

echo $candidateQuery;

$candidate = mysqli_query($conn, $candidateQuery);
if ($candidate->num_rows > 0) {
	$candidateInfo = $candidate->fetch_assoc();
	echo "<pre>";
	print_r($candidateInfo);
	echo "</pre>";

} else {
	echo "<h2>The Candidate ID is invalid!</h2>";
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.candidate {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 600px;
  margin: auto;
  text-align: center;
  font-family: arial;
	font-size: 25px;
	padding: 0px;
	padding-top: 20px;
	display: inline-block;
	margin: 50px;
}

.ID {
  color: grey;
  font-size: 25px;
  padding-top: 0px;
  margin-top: 0px;

}
.candidate h1 {
	margin-bottom: 5px;
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

<div class="candidates">
	<div class="candidate">
	  <img src="../../../uploads/profile_picture/1709521573_random_pp_1.jpg" alt="John">
	  <h1>John Doe</h1>
	  <p class="ID">xlK1@9K49</p>
	  <div class="details">
		  <p><big>Party:</big> <i>Class Monitor</i> (<span class="ID">aADXC23@3jc!2</span>)</p>
		  <p><big>Moto:</big>  I want to be CR!I want to I want to be CR! I want to be CR!I want to be CR!</p>
	  </div>
	  <p><button>Vote</button></p>
	</div>

	<div class="candidate">
	  <img src="../../../uploads/profile_picture/1709521573_random_pp_1.jpg" alt="John">
	  <h1>John Doe</h1>
	  <p class="ID">xlK1@9K49</p>
	  <div class="details">
		  <p><big>Party:</big> <i>Class Monitor</i> (<span class="ID">aADXC23@3jc!2</span>)</p>
		  <p><big>Moto:</big>  I want to be CR!I want to I want to be CR! I want to be CR!I want to be CR!</p>
	  </div>
	  <p><button>Vote</button></p>
	</div>

	<div class="candidate">
	  <img src="../../../uploads/profile_picture/1709521573_random_pp_1.jpg" alt="John">
	  <h1>John Doe</h1>
	  <p class="ID">xlK1@9K49</p>
	  <div class="details">
		  <p><big>Party:</big> <i>Class Monitor</i> (<span class="ID">aADXC23@3jc!2</span>)</p>
		  <p><big>Moto:</big>  I want to be CR!I want to I want to be CR! I want to be CR!I want to be CR!</p>
	  </div>
	  <p><button>Vote</button></p>
	</div>

	<div class="candidate">
	  <img src="../../../uploads/profile_picture/1709521573_random_pp_1.jpg" alt="John">
	  <h1>John Doe</h1>
	  <p class="ID">xlK1@9K49</p>
	  <div class="details">
		  <p><big>Party:</big> <i>Class Monitor</i> (<span class="ID">aADXC23@3jc!2</span>)</p>
		  <p><big>Moto:</big>  I want to be CR!I want to I want to be CR! I want to be CR!I want to be CR!</p>
	  </div>
	  <p><button>Vote</button></p>
	</div>
</div>
</body>
</html>
