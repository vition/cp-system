<?php 
	require_once('../../config.php');
	if($global->verify()=="success"){
		load_class("user");
		$user=new _user($serverinfo);
	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
	$global->setOption($_POST);
	$user->ulog($_SESSION["username"],"对后台基本信息作出了修改",$_POST);
	echo "修改完成！";
?>
