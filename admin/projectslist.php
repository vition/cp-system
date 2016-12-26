<?php 
	require_once('../config.php');
	if($global->verify()=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo $global->getoption("webname");?> 管理后台-IP管理界面</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/list.js?<?php random();?>"></script>
	<link href="css/list.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="content">
		<div class="p-search">
			<span class="v-search-group"><span class="v-search-title">IP名称</span><input id="title" class="p-info" autocomplete="off" type="text"></span><span class="v-search-group"><span class="v-search-title">发布平台</span><input id="platform" class="p-info" autocomplete="off" type="text"></span><span class="v-search-group"><span class="v-search-title">核心</span><input id="core" class="p-info" autocomplete="off" type="text"></span>
		</div>
		<div id="datalist"></div>
		<div class="user-con"><span class="but3 bg0 clw fs4 br3" id="p-del">删除</span></div>
	</div>
</body>
</html>
