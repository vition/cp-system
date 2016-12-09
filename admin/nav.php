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
	<script type="text/javascript" src="js/nav.js?<?php random();?>"></script>
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/nav.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="content">
		<ul>
			<li><a href="<?php echo $global->getoption("weburl");?>" target="_blank" class="">打开前端</a></li>
			<li><a class="a-nav-list <?php if(isset($_GET["base"])){echo "a-active";}?>" data-pagename="base">基本信息</a></li>
			<li><a class="a-nav-list <?php if(isset($_GET["insert"])){echo "a-active";}?>" data-pagename="insert">录入信息</a></li>
			<li><a class="a-nav-list" data-pagename="projectslist">IP查询及编辑</a></li>
			<li><a class="a-nav-list" data-pagename="comment">评论管理</a></li>
			<li><a class="a-nav-list" data-pagename="feedback">反馈管理</a></li>
			<li><a class="a-nav-list" data-pagename="classif">分类管理</a></li>
			<li><a class="a-nav-list" data-pagename="notice">公告管理</a></li>
			<li><a class="a-nav-list" data-pagename="adv">广告管理</a></li>
			<?php if($gorup["grouplevel"]>=4){?>
			<li><a class="a-nav-list" data-pagename="user">员工管理</a></li>
			<li><a class="a-nav-list" data-pagename="logs">日志管理</a></li>
			<?php } ?>
		</ul>
	</div>
</body>
</html>
