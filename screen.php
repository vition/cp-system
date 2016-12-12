<?php 
	require_once('config.php');
	if(isset($_GET["logout"])){
		$_SESSION=array();
	}
	if(isset($_GET["pushed"])){
		$pushed="仅推荐";
	}else{
		$pushed="所有";
	}
	if(isset($_GET["tags"])){
		$tags=$_GET["tags"];
	}else{
		$tags="";
	}
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$userinfo=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
	
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo $global->getoption("webname");?></title>
	<meta name="Description" content="<?php echo $global->getoption("description");?>">
	<meta name="Keywords" content="<?php echo $global->getoption("keywords");?>">
	<meta http-equiv="X-UA-Compatible" content="IE=10">
	<meta http-equiv="Cache-Control" content="no-transform"> 
	<script type="text/javascript" src="js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/screen.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/index.js?<?php random();?>"></script>
	<link href="css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/index.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/commons.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/screen.css?<?php random();?>" rel="stylesheet" type="text/css">

	<style>
		.logo{background:url("<?php echo $global->getoption("logo");?>") no-repeat;background-size: 221px 60px;}
	</style>
</head>
<body>
<?php require_once('header.php');?>
<div class="body_w">
	<div class="wrap">
		<div id="screen-box">
			<span class="screen-item"><input type="text" value="分类" readonly="readonly" ><span class="search-ico" data-value="class" ></span></span>
			<span class="screen-item"><input type="text" value="平台" readonly="readonly" ><span class="search-ico" data-value="platform" ></span></span>
			<span class="screen-item"><input type="text" value="刊例价" readonly="readonly" ><span class="search-ico" data-value="price" ></span></span>
			<span class="screen-item"><input type="text" value="推荐" readonly="readonly" ><span class="search-ico" data-value="pushed" ></span></span>
		</div>
		<div class="w970">
		</div>
	</div>
	<div class="condition-box">
		<div class="condition-search-div" data-value=""><input class="con-sea-input" value="" type="text" /><span id="condition-search-title">搜索</span></div>
		<div class="class-sel-box">
			<div class="sel-firstclass class-div"><div class="class-title" data-name="firstclass">一级分类</div><div class="class-name"></div></div>
			<div class="sel-secondclass class-div"><div class="class-title" data-name="secondclass">二级分类</div><div class="class-name"></div></div>
			<div class="sel-threeclass class-div"><div class="class-title" data-name="threeclass">三级分类</div><div class="class-name"></div></div>
		</div>
		<div class="condition-search-price" data-value=""><span class="v-input-group bb6 br3"><span class="v-input-title fs4 bg6 clw ">起始价格</span><input id="sprice" class="br3" value="0" type="text" /></span>-<span class="v-input-group bb6 br3"><span class="v-input-title fs4 bg6 clw ">结束价格</span><input id="eprice" class="br3" value="0" type="text" /></span><span id="allprice" data-value="1" class="but4 bg6 br3 clw " >所有价格</span></div>
		<div class="condition-list"></div>
		<input class="multiple" id="cond-class" type="hidden" />
		
		<input class="multiple sel-class" id="cond-firstclass" type="hidden" />
		<input class="multiple sel-class" id="cond-secondclass" type="hidden" />
		<input class="multiple sel-class" id="cond-threeclass" type="hidden" />
		
		<input class="multiple" id="cond-platform" type="hidden" />
		<input class="multiple" id="cond-price" type="hidden" />
		<input class="multiple" id="cond-pushed" value="<?php echo $pushed;?>" type="hidden" />
		<input class="multiple" id="cond-tags" value="<?php echo $tags;?>" type="hidden" />
	</div>
</div>
<?php require_once('footer.php');?>
</body>
</html>
