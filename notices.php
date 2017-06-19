<?php 
	require_once('config.php');
	$result=$global->query("SELECT * FROM news ORDER BY time DESC LIMIT 0,30;");
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo $global->getoption("webname");?></title>
	<meta name="Description" content="<?php echo $global->getoption("description");?>">
	<link rel="shortcut icon" href="favicon.ico">
	<meta name="Keywords" content="<?php echo $global->getoption("keywords");?>">
	<meta http-equiv="X-UA-Compatible" content="IE=10">
	<meta http-equiv="Cache-Control" content="no-transform"> 
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<script type="text/javascript" src="js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/index.js?<?php random();?>"></script>
	<link href="css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/index.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/commons.css?<?php random();?>" rel="stylesheet" type="text/css">
	<style>
		.logo{background:url("<?php echo $global->getoption("logo");?>") no-repeat;background-size: 221px 60px;}
		.notice-list{width:1200px;border-top:solid 2px #000000;margin:20px auto;padding-top:20px;font-size:0.8em;}
		.notice-list ul li{height:40px;line-height: 40px;}
		.notice-list ul li a:hover{color:blue;}
		.notice-title{width:300px;display: inline-block;}
		.notice-content{width:400px;display: inline-block;}
		.notice-time{width:130px;display: inline-block;}
		.notice-author{width:150px;display: inline-block;text-align:right;}
	</style>
</head>
<body>
<?php require_once('header.php');?>
<div class="body_w">
	<div class="notice-list">
		<ul>
			<?php
				while($notice=$result->fetch_array()){
					echo "<li><a href='notice.php?id={$notice["id"]}'><span class='notice-title'>{$notice["title"]}</span><span class='notice-content'>".mb_substr($notice["content"],0,30,'utf8')."</span><span class='notice-time'>{$notice["time"]}</span><span class='notice-author'>{$notice["author"]}</span></a></li>";
				}
			?>
		</ul>
	</div>
		
</div>
<?php require_once('footer.php');?>
</body>
</html>
