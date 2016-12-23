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
			<?php foreach($groupArr as $key=>$val){?>
			<li><span class="op-tit"><?php echo $key;?>：</span><span><input type="text" data-level="<?php echo $val;?>" class="level-info" value="<?php echo $key;?>"/></span></li>
			<?php }?>
		</ul>
		<div class="button-div"><span id="edit-level" class="button-green">修改</span></div>
	</div>
</body>
</html>
