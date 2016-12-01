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
	<title>娱乐营销CP推进系统管理后台</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/notice.js?<?php random();?>"></script>
	<link href="css/notice.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="content">
		<ul class="notice-new-box">
			<li><span class="v-search-group"><span class="v-search-title bgb clw">公告标题：</span><input id="title" class="notice-info" autocomplete="off" type="text" data-key="title"></span></li>
			<li><span class="v-textarea-group"><span class="v-textarea-title clw bgb">公告内容：</span><span class="v-textarea-content"><textarea id="content" class="notice-info" data-key="content" ></textarea></span></span></li>
			<li><span id="notice-create" class="but3 bg4 clw fs4 br3">新增</span><span id="notice-updata" class="but3 bg6 clw fs4 br3" data-updata="">更新</span></li>
		</ul>
		<div id="notice-list-box"></div>
		<div class="notice-con"><span class="but3 bg0 clw fs4 br3" id="n-del">删除</span></div>
	</div>
</body>
</html>
