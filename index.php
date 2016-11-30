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
	
	$result=$global->query("SELECT * FROM `projects` WHERE `pushed`>=1 ORDER BY `date` DESC LIMIT 0,8");
	$newResult=$global->query("SELECT * FROM `projects` ORDER BY `date` DESC LIMIT 0,8");
	$newsResult=$global->query("SELECT * FROM `news` ORDER BY `time` DESC LIMIT 0,5  ");
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo $global->getoption("webname");?></title>
	<meta name="Description" content="<?php echo $global->getoption("description");?>">
	<meta name="Keywords" content="<?php echo $global->getoption("keywords");?>">
	<meta http-equiv="X-UA-Compatible" content="IE=10">
	<meta http-equiv="Cache-Control" content="no-transform"> 
	<script type="text/javascript" src="js/tool1.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/jui.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/mokoutil.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/slider.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/index.js?<?php random();?>"></script>
	<script>
	</script>
	<link href="css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/nav.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/index.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/dialog.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/commons.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/slider.css?<?php random();?>" rel="stylesheet" type="text/css">
	<style>
		.logo{background:url("<?php echo $global->getoption("logo");?>") no-repeat;background-size: 221px 60px;}
	</style>
</head>
<body>
<?php require_once('header.php');?>
<div class="body_w">
	<div class="wrap">
		<div class="moko-slider" style="width: 960px;">
			<div class="frame">
				<ul style="width: 8640px; margin-left: -1920px;">
					<?php for($i=1;$i<=8;$i++){
							$banner=$global->getoption("banner-{$i}","array"); ?>
						<li><a target="_blank" hidefocus="ture" href="<?php echo $banner["value3"];?>" title="<?php echo $banner["value"];?>"><img src="<?php preg_match("/http/",$banner["value2"],$array);if(empty($array)){ echo $global->getoption("weburl").$banner["value2"];}else {echo $banner["value2"];}?>"></a></li>
					<?php }?>
				</ul>
			</div>
			<div class="point-ctrl" style="display: none;">
				<a class="left-point" href="javascript:void(0)" hidefocus="true"></a>
				<a class="right-point" href="javascript:void(0)" hidefocus="true"></a>
			</div>
			<div class="point-ctrl" style="display: none;">
				<a class="left-point" href="javascript:void(0)" hidefocus="true"></a>
				<a class="right-point" href="javascript:void(0)" hidefocus="true"></a>
			</div>
		</div>
		<div class="index-module">
	<h3>
		<a href="" hidefocus="true" class="title" target="_blank">重磅推荐</a>
		<div class="vocation-mark">
			<span class="vocation-a"><a href="screen.php?pushed=仅推荐">全部 &gt;</a></span>
		</div>
	</h3>
	
		<div class="w970">
				<span class="news-box">
				<div class="news-head">系统公告</div>
					<ul>
					<?php while($newsArray=$newsResult->fetch_array(1)){?>
						<li><div><span class="news-title"><a class="news-href" data-newsid="<?php echo $newsArray["id"];?>" href="javascript:void(0)"><?php echo $global->seizeStr($newsArray["title"],30);?></a></span></div></li>
					<?php }?>
					</ul>
				</span>
				<?php while($projects=$result->fetch_array(1)){?>
				<ul class="post big-post">
					<div class="cover" cover-text="爱慕先生" cover-girl-text="">
						<a href="page.php?id=<?php echo $projects["id"];?>" hidefocus="true" target="_blank"><img src2="<?php echo $global->getoption("weburl").$projects["cover"];?>" alt="赵泽峰作品《爱慕先生》" style="display: block;" src="<?php echo $global->getoption("weburl").$projects["cover"];?>"><div class="overlay" style="display: none;">爱慕先生<span style="color: rgb(255, 0, 153);"></span></div></a>
					</div>
					<li><label>项目名称 / </label><a href="page.php?id=<?php echo $projects["id"];?>" title="赵泽峰" hidefocus="true" class="nickname" target="_blank"><?php echo $global->seizeStr($projects["title"],40);?></a></li>
					<li><label>平台 / </label><span><?php echo $projects["platform"];?></span></li>
					<li><label>更新日期 / </label><span><?php echo $projects["date"];?></span></li>
				</ul>
				<?php }?>
		</div>
		<hr>
		<h3>
		<a href="" hidefocus="true" class="title" target="_blank">最新项目</a>
		<div class="vocation-mark">
			<span class="vocation-a"><a href="screen.php">全部 &gt;</a></span>
		</div>
	</h3>
		<div class="w970">
		<?php while($projects=$newResult->fetch_array(1)){?>
		<ul class="post big-post">
			<div class="cover" cover-text="" cover-girl-text="">
				<a href="page.php?id=<?php echo $projects["id"];?>" hidefocus="true" target="_blank"><img src2="<?php echo $global->getoption("weburl").$projects["cover"];?>" alt="" style="display: block;" src="<?php echo $global->getoption("weburl").$projects["cover"];?>"><div class="overlay" style="display: none;"><span style="color: rgb(255, 0, 153);"></span></div></a>
			</div>
			<li><label>项目名称 / </label><a href="page.php?id=<?php echo $projects["id"];?>" title="赵泽峰" hidefocus="true" class="nickname" target="_blank"><?php echo $global->seizeStr($projects["title"],40);?></a></li>
			<li><label>平台 / </label><span><?php echo $projects["platform"];?></span></li>
			<li><label>更新日期 / </label><span><?php echo $projects["date"];?></span></li>
		</ul>
		<?php }?>
		</div>
	
</div>
	</div>
</div>
<div id="newsp-box">
	<div class="newsp-head"><span class="newsp-title">zheli jiushi</span><span class="close-ico" data-box="newsp-box">x</span></div>
	<div><p class="newsp-content"></p></div>
</div>
<?php require_once('footer.php');?>
</body>
</html>
