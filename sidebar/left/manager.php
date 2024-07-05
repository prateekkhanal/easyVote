


<style>
	.sidenav li {
		list-style-type: none;
		padding-bottom: 0px;
		margin-right: 0px;
}
	.sidenav-left li a{
		padding-top: 0px;
		margin-top: 0px;
		padding-bottom: 0px;
		margin-bottom: 0px;
}
</style>

<?php
	$electionSelected = (isset($_GET['eid']) & isset($_GET['et'])) ? true : false;
	if ($electionSelected) {
		$eid = urlencode($_GET['eid']);
		$et = urlencode($_GET['et']);
	}
	
	/* $checkIfPersonalElection =  ""; */
?>

	<div class="sidenav sidenav-left">
	  <li><a href="/easyVote/includes/backend/manager/election.php"><img src="/easyVote/uploads/icons/election.png"> <span>Elections</span></a>
			<ol>
			<li>&ensp;&ensp;&ensp;<a href="/easyVote/includes/backend/manager/election.php?role=personal"><img src="/easyVote/uploads/icons/leader.png"> <span>Personal</span></a></li>
				<li>&ensp;&ensp;&ensp;<a href="/easyVote/includes/backend/manager/election.php?role=assistant"><img src="/easyVote/uploads/icons/assistant.png"> <span>Assisted</span></a></li>
			</ol>
		</li>
		<a href="/easyVote/includes/backend/manager/manage-assistants.php?eid=<?=$eid?>&et=<?=$et?>" <?php if(!$electionSelected) { ?> onclick="alert('You must choose a Personal Election to view it\'s Assistant!'); event.preventDefault();" <?php } ?>><img src="/easyVote/uploads/icons/manager.png"> <span>Assistants</span></a>
	  <a href="/easyVote/includes/backend/manager/list-parties.php?eid=<?=$eid?>&et=<?=$et?>" <?php if(!$electionSelected) { ?> onclick="alert('You must choose an Election to view it\'s Parties!'); event.preventDefault();" <?php } ?>><img src="/easyVote/uploads/icons/party.png"> <span>Parties</span></a>
	  <a href="/easyVote/includes/backend/manager/manage-election.php?eid=<?=$eid?>&et=<?=$et?>#roles" <?php if(!$electionSelected) { ?> onclick="alert('You must choose an Election to view it\'s Roles!'); event.preventDefault();" <?php } ?>><img src="/easyVote/uploads/icons/role.png"> <span>Roles</span></a>
	  <a href="/easyVote/includes/backend/manager/candidates.php?eid=<?=$eid?>&et=<?=$et?>" <?php if(!$electionSelected) { ?> onclick="alert('You must choose an Election to view it\'s Candidates!'); event.preventDefault();" <?php } ?>><img src="/easyVote/uploads/icons/candidate-request.png"> <span>Candidates</span></a>
	  <a href="/easyVote/includes/frontend/voter/search-elections.php"><img src="/easyVote/uploads/icons/search.png"> <span>Search</span></a>
	  <a href="/easyVote/includes/frontend/voter/faq.php"><img src="/easyVote/uploads/icons/faq.png"> <span>FAQs</span></a>
	</div>


