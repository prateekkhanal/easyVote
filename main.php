 <?php 
/* $url = explode('?', $_SERVER['REQUEST_URI'])[0]; */
/* $data = explode('?', $_SERVER['REQUEST_URI'])[1]; */
/* if (!empty($data)) {$data = '?'.$data;} */

/* $slug = explode('/', $url); */
/* array_splice($slug, 0, 1); */

/* // redirect */ 
/* $page = array_pop(explode('/', $url)); */

/* if (isset($page_url[$page])) { */
/* 	header("Location: ".$page_url[$page].$data); */
/* } */
/* if(!isset($slug[3])){ */
/* if (isset($slug[2]) && $slug[2] == "")  { */
    
/*         /1* $course= $db->CustomQuery("SELECT * FROM courses WHERE slug = '$slug[1]'"); *1/ */
/*         if(!empty($course[0]->slug)){ */
/*             include './pages/course_info.php'; */
            
/*         }else{ */
/*             include '404.php'; */
/*         } */
/* }else if  ($slug[1] == "search") { */
/*     /1* include './includes/frontend/voter/search-elections.php'; *1/ */
/*     include "/$base_url/includes/frontend/voter/search-elections.php"; */
/* }else if  ($slug[1] == "pinned-elections") { */
/*     include "/$base_url/includes/frontend/voter/pinned-elections.php"; */
/* }else if  ($slug[1] == "switch-role") { */
/*     include "sidebar/right/switch-role.php"; */
/* 	 include "/<?=$base_url?>/sidebar/right/switch-role.php"; */
/* }else if  ($slug[1] == "login") { */
/*     require './signin.php'; */
/* }else if  ($slug[1] == "logout") { */
/*     include 'logout.php'; */
/* }else if  ($slug[1] == "") { */
/* 	 include "./sidebar/right/switch-role.php"; */
/* }else{ */
/*     include "404.php"; */
/* } */
/* } else{ */
/*     include "404.php"; */
/* } */
/*  ?> */
	
/* </div> */
?>

<style>
	#easyVote {
		width: 800px;
		margin-left: 550px;
		position: fixed;
		top: 0px;
}
p {
		text-align: center;
		font-family:"Lato", Arial, sans-serif;
		font-size: 25px;
		position: fixed;
		bottom: 50px;
		right: 350px;
		width: 1200px;
		  letter-spacing: 3px;

}
</style>
<img src="/easyVote/uploads/icons/easyvote-black.png" id="easyVote">
<div class="main">
<p>Welcome to <i><b><big><big><big><big>easyVote</big></big></big></big></b></i>, <br>our online voting platform,  where transparency and accessibility define our democratic process. Our platform caters to various user roles, ensuring a seamless experience for all participants. Anonymous viewers can spectate elections, gaining insight into the electoral landscape. Voters enjoy the privilege of exploring detailed information about elections, candidates, parties, and roles, ensuring informed decision-making. </p>
</div>
