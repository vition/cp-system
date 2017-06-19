<?php 
	require_once('config.php');
	if(isset($_GET["id"])){
		if($_GET["id"]>0){
			$result=$global->query("SELECT * FROM news WHERE id='{$_GET["id"]}'");
			$notice=$result->fetch_array(1);
		}
	}
	
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
		.body_w{width:1200px;border-top:solid 2px #000000;margin:20px auto;padding:20px;}
		.body_w .notice-title,.body_w .notice-tauthor{width: 100%;text-align: center;height:50px;line-height: 50px;}
		.body_w .notice-tauthor span{display: inline-block;margin-left:20px;margin-right:20px;}
		.body_w p{text-indent: 2em;line-height: 1.5em;}
	</style>
</head>
<body>
<?php require_once('header.php');?>
<div class="body_w">
	<div class="notice-title"><h3><?php echo $notice["title"]; ?></h3></div>
	<div class="notice-tauthor"><span>发布时间：<?php echo $notice["time"]; ?></span><span>作者：<?php echo $notice["author"]; ?></span></div>
	<p><?php echo $notice["content"]; ?></p>	
</div>
<?php require_once('footer.php');?>
</body>
</html>