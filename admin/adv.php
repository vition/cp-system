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
	<title><?php echo $global->getoption("webname");?> 管理后台-广告管理界面</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/adv.js?<?php random();?>"></script>
	<link href="css/adv.css?<?php random();?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="content">
		<ul>
			<?php
				for($i=1;$i<=8;$i++){
					$banner=$global->getoption("banner-{$i}","array");
					echo '<li><div class="ban-li-div"><span class="ban-title">banner'.$i.'</span><span class="ban-title-input"><input type="text" value="'.$banner["value"].'" /></span><span class="ban-title-href"><input type="text"  value="'.$banner["value3"].'"/></span></div><div class="ban-li-div"><span class="ban-img-input"><input id="imgurl-'.$i.'" type="text"  value="'.$banner["value2"].'"/></span><span class="ban-updata-file"><input id="imgs-'.$i.'" class="upimg-input" type="file" accept="image/*" /></span></div></li>';
				}
			?>
		</ul>
		<div id="photo-preview"></div>
		<div style="margin-bottom:20px;"><span id="updata-imgs-button">确认修改</span></div>
	</div>
</body>
</html>
