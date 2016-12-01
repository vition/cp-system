<?php 
	require_once('../../config.php');
	load_class("user");
	$user=new _user($serverinfo);
	if($user->checkPsw($_SESSION["username"],$_POST["opsw"])=="success"){
		if($user->changePsw($_SESSION["username"],$_POST["npsw"])=="success"){
			$user->ulog($_SESSION["username"],"修改了自己的密码");
			echo "成功修改密码";
		}else{
			echo "修改密码失败";
		}
	}else{
		echo "请重新确认密码";
	}
	//$user->login($_POST["username"],$_POST["psw"]);
	//$global->verify("weburl");
?>
