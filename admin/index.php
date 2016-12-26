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
	<title><?php echo $global->getoption("webname");?> 管理后台-登录界面</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/admin.js?<?php random();?>"></script>
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/admin.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="login-panel">
		<div class="login-logo"><span ></span></div>
		<div class="login-info">
			<div><span class="title">账 户</span><span class="inputs"><input id="username" type="text" /></span></div>
			<div><span class="title">密 码</span><span class="inputs"><input id="password" type="password"/></span></div>
			<div><span class="span-button" id="login">登录</span><span class="span-button">重置</span></div>
		</div>
		<div class="remind"><p style="margin-top:10px;">为了更好的使用系统里的功能，请使用火狐、谷歌、Safari等支持HTML5的浏览器</p></div>
	</div>
	
</body>
</html>
