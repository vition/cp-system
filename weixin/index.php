<?php 
	require_once('../config.php');
	load_class("weixin");
	load_class("user");
	$user=new _user($serverinfo);
	$weixin=new weixin($serverinfo);
	if(isset($_GET["code"])){
		$wxId=$weixin->getUserId();
		if($weixin->checkUserId($wxId)){
			$user->ulog($_SESSION["username"],"通过企业微信登录");
			$global->gotopage($global->getoption("weburl"));
		}
		$username=$weixin->getUsername($wxId);
	}
	if(isset($_GET["username"])){
		if($weixin->binding($_GET["username"],$_GET["wxid"])=="success"){
			$username= $_GET["username"];
			$wxId=$_GET["wxid"];
			$user->ulog($_GET["username"],"绑定了微信ID",$_GET);
		}else{
			echo "<script>alert('用户名不存在')</script>";
			$username= false;
			$wxId=$_GET["wxid"];
		}
	}
	if(isset($_GET["cancel"])){
		if($weixin->unbing($_GET["cancel"])=="success"){
			$user->ulog($_GET["cancel"],"解绑了微信ID",$_GET);
			$username= false;
			$wxId=$_GET["wxid"];
		}else{
			$username= $_GET["cancel"];
			$wxId=$_GET["wxid"];
		}
		
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title>娱乐营销CP推进系统管理后台</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script>
	 $(function(){
			$("#username").change(function(){$("#putUsername").attr("href","?username="+$(this).val()+"&wxid="+$("#wxid").val())})
		})

	</script>
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<style>
	#menu{
	width:70%;
	height:320px;
	font-size:1em;
	position:fixed;
	top:10%;
	left:15%;
}
#logo{
	height:96px;
	width:252px;
	background:url("../images/wxlogo.png")no-repeat;
	background-size:100%;
}
#register-box{
	height:170px;
	border:1px solid #0372BA;
	box-shadow:0 0 10px 6px #0372BA;
	border-radius:5px;
	margin-top:20px;
	background:#0F1922;
	text-align:center;
	padding:20px 0;
}
.v-search-group{
	background:#ffffff;
	width:80%;
}
.v-search-title{
	border-radius:5px 0 0 5px;
	width:30%;
}
#username{
	width:60%;
}
.mes,.name{
	color:#ffffff;
	font-size:0.95em;
	margin-top:10px;
	margin-bottom:10px;
}
.but3{
	margin-top:10px;
}
	</style>
</head>
<body>
	<div id="menu">
		<div id="logo"></div>
		<div id="register-box">
			<?php if($username==false){
				echo '<div class="mes">请输入在WTC系统里的用户名</div>';
				echo '<div><span class="v-search-group"><span class="v-search-title">用户名</span><input id="username" autocomplete="off" type="text"><input id="wxid" type="hidden" value="'.$wxId.'"></span></div>';
				echo '<div><a id="putUsername" href="" class="but3 bg1 clw br3">绑定</a></div>';
			}else{
				echo '<div class="mes">您在WTC系统里的用户名：</div>';
				echo '<div class="name">'.$username.'</div>';
				echo '<div><a href="?cancel='.$username.'&wxid='.$wxId.'" class="but3 bg1 clw br3">取消绑定</a></div>';
			}?>
		</div>
			
	</div>
</body>
</html>
