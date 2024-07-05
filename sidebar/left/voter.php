<?php session_start();?>
	<div class="sidenav sidenav-left">
	  <a href="/easyVote/"><img src="/easyVote/uploads/icons/home.png"> <span>Home</span></a>
	  <a href="/easyVote/includes/frontend/voter/search-elections.php"><img src="/easyVote/uploads/icons/search.png"> <span>Search</span></a>
	  <a href="/easyVote/includes/frontend/voter/faq.php"><img src="/easyVote/uploads/icons/faq.png"> <span>FAQs</span></a>
	  <a href="/easyVote/includes/backend/contact/email.php?s=<?=$_SESSION['voterID']?>&r=6627a56fe55b1&role=admin&et=easyVote&eid=easyVote"  <?php if (!isset($_SESSION['vid'])) {?> onclick="if(confirm('You need to login first! \n\nDo you want to login?')) { event.preventDefault(); window.location.href = '/easyVote/signin.php';} else {event.preventDefault();}" <?php } ?>><img src="/easyVote/uploads/icons/contact.png"> <span>Contact Us</span></a>
	  <a href="/easyVote/includes/frontend/voter/about-us.php"><img src="/easyVote/uploads/icons/about-us.png"> <span>About Us</span></a>
	  <a href="/easyVote/includes/frontend/voter/profile.php"  <?php if (!isset($_SESSION['vid'])) {?> onclick="if(confirm('You need to login first! \n\nDo you want to login?')) { event.preventDefault(); window.location.href = '/easyVote/signin.php';} else {event.preventDefault();}" <?php } ?>><img src="/easyVote/uploads/icons/profile.png"> <span>Profile</span></a>
	</div>
