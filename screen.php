<?php 
	require_once('config.php');
	if(isset($_GET["logout"])){
		$_SESSION=array();
	}
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$userinfo=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
	
	$newResult=$global->query("SELECT * FROM `projects` ORDER BY `date` DESC LIMIT 0,20");
	
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo $global->getoption("webname");?></title>
	<meta name="Description" content="<?php echo $global->getoption("description");?>">
	<meta name="Keywords" content="<?php echo $global->getoption("keywords");?>">
	<meta http-equiv="X-UA-Compatible" content="IE=10">
	<meta http-equiv="Cache-Control" content="no-transform"> 
	<script type="text/javascript" src="js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/index.js?<?php random();?>"></script>
	<link href="css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/index.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/commons.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/screen.css?<?php random();?>" rel="stylesheet" type="text/css">

	<style>
		.logo{background:url("<?php echo $global->getoption("logo");?>") no-repeat;}
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
		</div>
		<div class="w970">
		<?php while($projects=$newResult->fetch_array(1)){?>
		<ul class="post big-post">
			<div class="cover" cover-text="" cover-girl-text="">
				<a href="page.php?id=<?php echo $projects["id"];?>" hidefocus="true" target="_blank"><img src2="<?php echo $global->getoption("weburl").$projects["cover"];?>" alt="" style="display: block;" src="<?php echo $global->getoption("weburl").$projects["cover"];?>"><div class="overlay" style="display: none;"><span style="color: rgb(255, 0, 153);"></span></div></a>
			</div>
			<li><label>项目名称 / </label><a href="page.php?id=<?php echo $projects["id"];?>" title="赵泽峰" hidefocus="true" class="nickname" target="_blank"><?php echo $projects["title"];?></a></li>
			<li><label>平台 / </label><span><?php echo $projects["platform"];?></span></li>
			<li><label>更新日期 / </label><span><?php echo $projects["date"];?></span></li>
		</ul>
		<?php }?>
		</div>
	</div>
	<div class="condition-box">
		<div class="condition-search-div" data-value=""><input class="con-sea-input" value="" type="text" /><span id="condition-search-title">搜索</span></div>
		<div class="condition-search-price" data-value=""><span class="v-input-group bb6 br3"><span class="v-input-title fs4 bg6 clw ">起始价格</span><input id="sprice" class="br3" value="1" type="text" /></span>-<span class="v-input-group bb6 br3"><span class="v-input-title fs4 bg6 clw ">结束价格</span><input id="eprice" class="br3" value="10000" type="text" /></span><span id="allprice" data-value="1" class="but4 bg6 br3 clw " >所有价格</span></div>
		<div class="condition-list"></div>
		<input class="multiple" id="cond-class" type="hidden" />
		<input class="multiple" id="cond-platform" type="hidden" />
		<input class="multiple" id="cond-price" type="hidden" />
	</div>
</div>
<?php require_once('footer.php');?>
</body>
</html>
