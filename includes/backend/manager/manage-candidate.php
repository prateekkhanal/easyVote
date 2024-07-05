<!doctype html>
<center>
<h2>Candidates Requests</h2>
</center>
<hr>
<style>
.candidate {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 450px;
  min-width: 450px;
  margin: auto;
  text-align: center;
  font-family: arial;
	font-size: 20px;
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
.candidate h3 {
	margin-bottom: 5px;
	font-size: 30px;
}
.candidate img {
	max-height: 220px;
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
  font-size: 25px;
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
	min-height: 150px;
}
.details p {
	overflow: hidden;
	text-overflow: ellipsis;
}
.details big {
	font-size: 23px;
	font-weight: bold;
}
button:hover, a:hover {
  opacity: 0.7;
}
span.title {
	font-weight: bold;
	font-size: 1.5em;
	
}
.candidate select {
	font-size: 20px;
	height: 50px;
	text-transform: uppercase;
	padding: 5px;
	font-weight: bold;
	color: darkblue;
}
.candidate option {
	background-color: white;
}
details {
	margin-bottom: 20px;
}
.show-details {
	font-style: italic;
	text-align: left;
	margin-left: 50px;
}
.show-details a {
	font-size: 1.15em;
	text-decoration: underline;
	color: darkblue;
}
</style>
<?php
	$roles = ['pending', 'accepted', 'rejected'];

	foreach ($roles as $role) {
		$CandidatesSql = " 
							SELECT *, (SELECT voterID from voters WHERE vid = ". $_SESSION['vid'] . ") as mid, candidate.description as moto FROM candidate 
							JOIN 		voters 		ON 
							voters.voterID 	=	 candidate.vid 
							JOIN	   roles 		ON 
							roles.rid 			= 	candidate.rid 
							JOIN	   election 		ON 
							election.electionID 			= 	candidate.eid 
							WHERE candidate.verified = '$role' 
							AND candidate.eid = '".$_GET['eid']."'" . 
							(isset($_GET['pid']) ? " and candidate.pid = '" .$_GET['pid']."'" : ' ') .
						  (isset($_GET['rid']) ? " and candidate.rid = '" .$_GET['rid']."'" : ' ') . "; ";

		/* echo $CandidatesSql; */
	?>
<?php
/* echo $CandidatesSql; */
		$resultPC = mysqli_query($conn, $CandidatesSql);
		$Candidates = mysqli_fetch_all($resultPC, MYSQLI_ASSOC);
		echo "<details class=\"".$role."\">";
		echo "<summary><span class=\"title\">". (($role == 'pending') ? 'Requests' : (($role == 'accepted') ? 'Approved' : 'Rejected')) . " (".count($Candidates). ")</span></summary>";
		if (count($Candidates) > 0) {
		foreach ($Candidates as $Candidate) {
			echo "<pre>";
			/* print_r($Candidate); */
			echo "</pre>";
?>
			<div class="candidate">

			<img src="../../../uploads/profile_picture/<?=$Candidate['photo']?>" alt="John">
			<h3><?=$Candidate['name']?></h3>
			<p class="ID"><?=$Candidate['candidateID']?></p>
			<div class="details">
			  <p><big>Role:</big> <i><?=$Candidate['position']?></i> </p>
			  <p><big>Moto:</big> <?=$Candidate['moto']?></p>
			  <p><big>Authentication:</big>
			  <select onchange="candidateAuth('<?=$Candidate['candidateID']?>', this.value)">
				<option value="pending" <?= ($Candidate['verified'] == 'pending') ? 'selected' : ''?>>Pending</option>
				<option value="accepted" <?= ($Candidate['verified'] == 'accepted') ? 'selected' : ''?>>verified</option>
				<option value="rejected" <?= ($Candidate['verified'] == 'rejected') ? 'selected' : ''?>>Rejected</option>
				</select>
				</p>
			  </div>
			  <p class="show-details"><a href="../../frontend/candidate/profile.php?cid=<?=urlencode($Candidate['candidateID'])?>">Show Details...</a></p>
				<p><button onclick="window.location.href='../../backend/contact/email.php?s=<?=urlencode($Candidate['mid'])?>&r=<?=urlencode($Candidate['voterID'])?>&role=candidate&et=<?=urlencode($Candidate['title'])?>&eid=<?=urlencode($Candidate['electionID'])?>'" >Contact Candidate</button></p>
			</div>
<?php
			}
		}
		echo "</details>";

	}
?>
<script>
	var details = document.getElementsByTagName('details');
	console.log(details);
	details[0].open = true;

	function candidateAuth(cid, role) {
	var userInput = window.prompt('Enter ID of the candidate for confirmation : '+ cid);
	if (userInput == cid) {
		console.log("You have successfully updated the role of cadidate to "+role+"!");
		updateCandidate(cid, <?=$_SESSION['vid']?>,role, encodeURIComponent('<?=$_GET['eid']?>'));
		/* candidate(<?=$vid?>, cid); */
		/* window.location = '?rid='+<?=$rid?>+'&cid='+cid; */
	} else {
		alert("Invalid Candidate ID! candidate Failed!");
		event.preventDefault();
	}
}

function updateCandidate(cid, mid, newStatus, eid) {
	/* $.post("../../ajax/manager/manage-candidate.php?cid="+encodeURIComponent(cid)+"&mid="+encodeURIComponent(mid)+"&status="+encodeURIComponent(newStatus), */
	/* { */
	/* 	 cid: cid, */
	/* 	 mid: mid, */
	/* 	 status: newStatus */
	/* }, */
	/* function(data, status){ */
	/* 	 alert("Data: " + data + "\nStatus: " + status); */
	/* }) */
	/* .fail(function(xhr, status, error) { */
	/* 	 alert("Error: " + error); */
	/* }); */
	 var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        /* document.getElementById("txtHint").innerHTML = this.responseText; */
		 console.log("Data: " + this.responseText);
		 location.reload();
		/* location.href(window.location.href); */
      }
    };
    xmlhttp.open("GET", "../../ajax/manager/manage-candidate.php?cid="+encodeURIComponent(cid)+"&mid="+encodeURIComponent(mid)+"&status="+encodeURIComponent(newStatus)+"&eid="+encodeURIComponent(eid), true);
    xmlhttp.send();
}
</script>
