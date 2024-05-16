<?php

$rid = $_GET['rid'];
echo $rid;

$canVote = true;

if (!$canVote) {
	echo "you can't vote because of such and such reason....";
	die;
}

?>
