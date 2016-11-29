<?php 
	require_once('../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	//print_r($_POST);
	$result=$global->query("SELECT `title`,`content` FROM `news` WHERE `id`='{$_POST["id"]}'");
	$array=$result->fetch_array(1);
	$array["title"]=$global->seizeStr($array["title"],50);
	$array["content"]=$global->seizeStr($array["content"],600);
	echo json_encode($array);
?>
