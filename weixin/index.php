<?php 
	require_once('../config.php');
	if($global->verify("")=="success"){
		
	}else{
		load_class("user");
		$user=new _user($serverinfo);
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title>娱乐营销CP推进系统管理后台</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/weixin.js?<?php random();?>"></script>
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/weixin.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="menu">
		<div id="logo"></div>
		<div id="register-box">
			<div class="mes">请输入在WTC系统里的用户名</div>
			<div class="mes">您在WTC系统里的用户名：</div>
			<div><span class="v-search-group"><span class="v-search-title">用户名</span><input id="username" autocomplete="off" type="text"></span></div>
			<div><span class="but3 bg1 clw br3">绑定</span><span class="but3 bg1 clw br3">取消绑定</span></div>
		</div>
			
	</div>
</body>
</html>
