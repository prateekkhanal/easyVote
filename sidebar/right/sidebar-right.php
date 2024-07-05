<?php
session_start();
?>
<style>
.active-role {
	width: 230px;
	height: 250px;
	position: relative;
	top: -180px;
	margin-bottom: -50px;
}
	#admin {
		background-color: #f414145e;
	}
	#manager {
		background-color: #76eb76a3;
	}
	#candidate {
		background-color: #cd4fcd4f;
	}
	#voter {
		background-color: #0000ff30;
	}
.active-role img {
	width: 180px;
	border-radius: 50%;

	background-color: rgba(180, 216, 231, 0.15);
	margin-left: 30px;
}

.active-role h3 {
	font-size: 30px;
	text-transform: uppercase;
	text-align: center;
	padding-top: 5px;
}
</style>
<div class="sidenav sidenav-right">
<?php if (isset($_SESSION['vid'])) { ?>
	<div class="active-role">
		<img src="/easyVote/uploads/icons/<?=$_SESSION['role']?>.png"  id="<?=$_SESSION['role']?>">
		<h3><?=$_SESSION['role']?></h3>
	</div>
<?php } ?>
<a href="/easyVote/includes/frontend/voter/pinned-elections.php" <?php if (!isset($_SESSION['vid'])) {?> onclick="if(confirm('You need to login first! \n\nDo you want to login?')) { event.preventDefault(); window.location.href = '/easyVote/signin.php';} else {event.preventDefault();}" <?php } ?>><img src="/easyVote/uploads/icons/pin.png"> <span>Pinned</span></a>
  <a href="/easyVote/includes/switch-role.php" <?php if (!isset($_SESSION['vid'])) {?> onclick="if(confirm('You need to login first! \n\nDo you want to login?')) { event.preventDefault(); window.location.href = '/easyVote/signin.php';} else {event.preventDefault();}" <?php } ?>><img src="/easyVote/uploads/icons/switch-role.png"> <span>Switch Role</span></a>
<!-- decide between either login or logout -->
<?php
	if (isset($_SESSION['vid'])) {
?>
	<a href="/easyVote/logout.php"><img src="/easyVote/uploads/icons/logout.png"> <span>Logout</span></a>
<?php
	} else {
?>
 <a href="/easyVote/signup.php"><img src="/easyVote/uploads/icons/signup.png"> <span>Register</span></a>
  <a href="/easyVote/signin.php"><img src="/easyVote/uploads/icons/key.png"> <span>Login</span></a> 
<?php

	}
?>
</div>
