<?php 
	require_once('../config.php');
	if($global->verify()=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
		$rootClass=$global->getClass("root");
	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo $global->getoption("webname");?> 管理后台-分类管理界面</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/classif.js?<?php random();?>"></script>
	<link href="css/classif.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
<script charset="utf-8" src="editor/lang/zh-CN.js"></script>
</head>
<body>
	<div class="content">
		<div class="class-box">
			<ul data-class="firstclass">
				<?php  for($i=0;$i<count($rootClass);$i++){
						$classInfo=explode("-",$rootClass[$i]);
						echo "<li class='ul-root' data-classid='{$classInfo[0]}'><span class='jico plus-ico ul-click'></span><span class='edit-class'>{$classInfo[1]}</span><a class='add-class'></a></li>";
						echo "<li class='ul-sub'></li>";
				}?>
			</ul>
		</div>
	</div>
	<div class="add-class-box"><span><input type="text" value=""/><input type="hidden" class="sup-name" value=""></span><span><a class="button1" id="add-class-button">新增</a></span></div>
	<div id="edit-class">
		<ul>
			<li><a class="close-ico"></a></li>
			<li><div id="super-list"></div></li>
			<li><input type="text" id="class-input"/><input type="hidden" id="class-id" value=""/></li>
		</ul>
		<div><span id="edit-class-but" class="but3 bg4 clw fs4 br3">修改</span><span id="del-class-but" class="but3 bg0 clw fs4 br3">删除</span></div>
	</div>
	<input type="hidden" id="thisclass" value="" /><input type="hidden" id="prevclass" value="" />
</body>
</html>
