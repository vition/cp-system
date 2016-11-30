<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	$userArr=$user->userList($_POST["user"]);
	if($userArr!="error"){
		foreach($userArr as $val){
			echo "<li class='user-itme'>{$val}</li>";
		}
		
	}
?>
