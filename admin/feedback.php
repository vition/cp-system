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
	<title><?php echo $global->getoption("webname");?> 管理后台-反馈管理界面</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/feedback.js?<?php random();?>"></script>
	<link href="css/feedback.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="content">
		<div id="feedback-list-box"></div>
		<div class="feedback-con"><span class="but3 bg0 clw fs4 br3" id="f-del">删除</span></div>
	</div>
</body>
</html>
