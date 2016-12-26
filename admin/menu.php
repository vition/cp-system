<?php 
	require_once('../config.php');
	if(isset($_GET["logout"])){
		$_SESSION=array();
	}
	if(isset($_GET["id"])){
		$page="insert.php?id={$_GET["id"]}";
		$active="insert";
	}else{
		$page="base.php";
		$active="base";
	}
	if($global->verify("")=="success"){
		load_class("user");
		load_class("message");
		$user=new _user($serverinfo);
		$message=new _message($serverinfo);
		$userinfo=$user->getuser($_SESSION["username"]);
		if($userinfo["grouplevel"]<2){
			$global->gotopage($global->getoption("weburl"),"亲！你进了不该进的地方了！");
		}
	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
	
	
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo $global->getoption("webname");?> 管理后台</title>
	<link rel="shortcut icon" href="favicon.ico">
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/admin.js?<?php random();?>"></script>
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/admin.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body class="menu-body">
	<div id="body-panel">
		<div class="head-nav"><div class="nav-frame menu-logo"></div><div class="item-frame menu-nav">
			<div class="nav-title"><span class="span-tit user-ico">操作员：<span class="edit-psw"><?php echo $_SESSION["username"];?></span></span><span class="span-tit group-ico">权限组：<?php echo $userinfo["group"];?></span><span class="inbox-ico">信息 (<a><?php echo $message->unread($_SESSION["username"]);?></a>) </span><a href="?logout" class="span-tit logout-ico">退出</a></div>
		</div></div>
		<div id="psw-box">
			<ul>
				<li><span class="psw-title" >旧密码：</span><span><input class="old-psw" type="password" value="" /></span></li>
				<li><span class="psw-title" >新密码：</span><span><input class="new-psw" type="password" value="" /></span></li>
				<li><span class="v-button button-blue" id="change-psw">重置密码</span></li>
			</ul>
		</div>
		<div><iframe class="framebase nav-frame" src="nav.php?<?php echo $active;?>"></iframe><iframe id="page-iframe" class="framebase item-frame" src="<?php echo $page;?>"></iframe></div>
		<div id="inbox-box"></div>
		<div id="message-box">
		</div>
		<div class="foot"><p>COPYRIGHT © 2016 TWOWAY IT RIGHTS RESERVED</p></div>
	</div>
</body>
</html>
