<?php 
	require_once('../../config.php');
	if($global->verify()=="success"){
		load_class("user");
		$user=new _user($serverinfo);
	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
	switch($_POST["type"]){
		case "base":
		$global->setOption($_POST["data"]);
		$user->ulog($_SESSION["username"],"对后台基本信息作出了修改",$_POST["data"]);
		echo "修改完成！";
		break;
		case "level":
		$global->setLevel($_POST["data"]);
		$user->ulog($_SESSION["username"],"对后台等级作出了修改",$_POST["data"]);
		echo "修改完成！";
		break;
	}
	
?>
