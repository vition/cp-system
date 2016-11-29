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
	<script type="text/javascript" src="js/admin.js?<?php random();?>"></script>
	<link href="css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="content">
		<ul>
			<li><span class="op-tit">网站名字：</span><span><input type="text" data-option="webname" class="base-info" value="<?php echo $global->getoption("webname");?>"/></span></li>
			<li><span class="op-tit">默认网址：</span><span><input type="text" data-option="weburl" class="base-info" value="<?php echo $global->getoption("weburl");?>"/></span></li>
			<li><span class="op-tit">LOGO管理：</span><span><input type="text" data-option="logo" class="base-info" value="<?php echo $global->getoption("logo");?>"/></span></li>
			<li><span class="op-tit">关键字：</span><span><input type="text" data-option="keywords" class="base-info" value="<?php echo $global->getoption("keywords");?>"/></span></li>
			<li><span class="op-tit">网站描述：</span><span><input type="text" data-option="description" class="base-info" value="<?php echo $global->getoption("description");?>"/></span></li>
			<li><span class="op-tit" style="vertical-align: top">底部代码：</span><span><textarea class="foot-html base-info" data-option="foothtml"><?php echo $global->getoption("foothtml");?></textarea></span></li>
		</ul>
		<div class="button-div"><span id="edit-base" class="button-green">修改</span></div>
	</div>
</body>
</html>
