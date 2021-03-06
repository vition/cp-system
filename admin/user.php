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
	<title><?php echo $global->getoption("webname");?> 管理后台-用户管理界面</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/user.js?<?php random();?>"></script>
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/user.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="content">
		<div id="user-search"><span class="v-search-group"><span class="v-search-title">用户名</span><input id="username"  autocomplete="off" type="text" /></span><span class="v-search-group"><span class="v-search-title">组别</span><input id="user-search-group" class="user-group" type="text" readonly="readonly" /></span><span id="user-new-but" class="but3 bg1 clw fs4 br3">创建新用户</span></div>
		<input type="hidden" id="superadmin" value=<?php echo $global->getLevel("4");?> />  
		<div id="user-list-box">
		</div>
		<div class="user-con"><span class="but3 bg0 clw fs4 br3" id="del-user">删除</span><!--<span class="but3 bg6 clw fs4 br3" id="freeze-user">冻结</span>--></div>
		<div id="user-new-box" class="boxblack">
			<div><span class="close-but" data-box="user-new-box">X</span></div>
			<ul>
				<li><span class="v-search-group"><span class="v-search-title ws-50">用户名</span><input id="user-new-username" type="text" class="user-new-info"/></span></li>
				<li><span class="v-search-group"><span class="v-search-title ws-50">密码</span><input id="user-new-psw" type="text" class="user-new-info" /></span></li>
				<li><span class="v-search-group"><span class="v-search-title ws-50">组别</span><input id="user-new-group" readonly="readonly" class="user-group user-new-info" type="text" /></span></li>
				<li><span class="v-search-group"><span class="v-search-title ws-50">备注</span><input id="user-new-remark" class="user-new-info" type="text" /></span></li>
				<li><span class="but3 bg4 clw fs4 br3" id="user-create">确认创建</span></li>
			</ul>
		</div>
		<div id="user-group-box" data-input="" data-name=""><ul></ul></div>
		<input type="hidden" id="changegid" value=""/>
		<div id="psw-box">
			<ul><input type="hidden" class="reset-info" id="reset-user" value="">
				<li><span class="psw-title">会员新密码：</span><span><input class="old-psw reset-info" value="" type="password"></span></li>
				<li><span class="psw-title">管理密码：</span><span><input class="new-psw reset-info" value="" type="password"></span></li>
				<li><span class="v-button button-blue" id="reset-psw">重置密码</span></li>
			</ul>
		</div>
	</div>
</body>
</html>
