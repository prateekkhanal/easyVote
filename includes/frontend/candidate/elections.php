<?php
	$roles = ['pending', 'accepted', 'rejected'];

	foreach ($roles as $role) {
		$CandidatesSql = " 
						SELECT *,candidate.description as moto, 
									parties.name as partyName,
									candidate.vid as cID, 
									mvoters.voterID as mID
					 FROM candidate 
						join election on
							 election.electionID = candidate.eid 
						join roles on
							 roles.rid = candidate.rid 
						join parties on
							 parties.partyID = candidate.pid 
						join voters as cvoters on
							 cvoters.voterID = candidate.vid 
						join voters as mvoters on
							 mvoters.vid = election.vid 
						where candidate.vid = (
									select voterID from voters where vid = " . $_SESSION['vid'] . "
												) 
						and verified = '$role';";
		/* echo $CandidatesSql; */
	?>
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
.important {
	text-transform: uppercase;
	font-style: italic;
}
span.title {
	font-weight: bold;
	font-size: 1.5em;
	
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
/* echo $CandidatesSql; */
		$resultPC = mysqli_query($conn, $CandidatesSql);
		$Candidates = mysqli_fetch_all($resultPC, MYSQLI_ASSOC);
		echo "<details class=\"".$role."\">";
		echo "<summary><span class=\"title\">Requests ". (($role == 'pending') ? 'Pending' : (($role == 'accepted') ? 'Approved' : 'Rejected')) . " (".count($Candidates). ")</span></summary>";
		if (count($Candidates) > 0) {
		foreach ($Candidates as $Candidate) {
			echo "<pre>";
			/* print_r($Candidate); */
			echo "</pre>";
?>
			<div class="candidate">

			<img src="../../../uploads/<?= (!empty($Candidate['logo'])) ? 'party/'.$Candidate['logo'] : 'profile_picture/no-image-party.jpg'?>" alt="John">
			<h3><?=$Candidate['title']?></h3>
			<p class="ID"><?=$Candidate['electionID']?></p>
			<div class="details">
			  <p><big>Role:</big> <i><?=$Candidate['position']?></i> </p>
			  <p><big>Place:</big> <i><?=$Candidate['place']?></i> </p>
			  <p><big>Party: </big> <?=$Candidate['partyName']?> (<span class="important"><?=$Candidate['partyID']?>)</span></p>
			  <p><big>Authentication:</big> <span class="important"><?=$Candidate['verified']?></span></p>
			  <p><big>Moto:</big> <?=$Candidate['moto']?></p>
			  </div>
			  <p class="show-details"><a href="../../frontend/candidate/update-profile.php?eid=<?=urlencode($Candidate['electionID'])?>">Update Details</a></p>
				<p><button onclick="window.location.href='../../backend/contact/email.php?s=<?=urlencode($Candidate['cID'])?>&r=<?=urlencode($Candidate['mID'])?>&role=manager&et=<?=urlencode($Candidate['title'])?>&eid=<?=urlencode($Candidate['electionID'])?>'" >Contact Manager</button></p>
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

	</script>
