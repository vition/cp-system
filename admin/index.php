<?php 
	require_once('../config.php');
	if($global->verify("")=="success"){
		$global->gotopage($global->getoption("weburl")."admin/menu.php");
	}else{
		load_class("user");
		$user=new _user($serverinfo);
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title>娱乐营销CP推进系统管理后台</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/admin.js?<?php random();?>"></script>
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/admin.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="login-panel">
		<div><span class="title">账 户</span><span class="inputs"><input id="username" type="text" /></span></div>
		<div><span class="title">密 码</span><span class="inputs"><input id="password" type="password"/></span></div>
		<div><span class="span-button" id="login">登录</span><span class="span-button">重置</span></div>
	</div>
</body>
</html>
