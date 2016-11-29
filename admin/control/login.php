<?php 
	require_once('../../config.php');
	load_class("user");
	$user=new _user($serverinfo);
	$user->login($_POST["username"],$_POST["psw"]);
	//$global->verify("weburl");
?>
