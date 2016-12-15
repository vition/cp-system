<?php 
	require_once('config.php');
	
	load_class("weixin");
	$weixin=new weixin($serverinfo);
	if(isset($_GET["code"])){
		$wxId=$weixin->getUserId();
		if($weixin->checkUserId($wxId)){
			$global->gotopage($global->getoption("weburl"));
		}
		$username=$weixin->getUsername($wxId);
	}
	if(isset($_GET["id"])){
		load_class("user");
		$user=new _user($serverinfo);
		$userInfo=$user->getuser($_SESSION["username"]);
		//print_r($userInfo);
		$result=$global->query("SELECT * FROM `projects` WHERE `id`='{$_GET["id"]}'");
		$array=$result->fetch_array(1);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	$result=$global->query("SELECT * FROM `comment` WHERE `pid`='{$_GET["id"]}' ORDER BY `date` DESC LIMIT 0,5");
	
	$fresult=$global->query("SELECT * FROM `feedback` WHERE `pid`='{$_GET["id"]}' ORDER BY `lastdate` DESC LIMIT 0,5");
?>

<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo $global->getoption("webname");?>-<?php echo $array["title"];?></title>
	<meta name="Description" content="<?php echo $global->getoption("description");?>">
	<meta name="Keywords" content="<?php echo $global->getoption("keywords");?>">
	<meta http-equiv="X-UA-Compatible" content="IE=10">
	<meta http-equiv="Cache-Control" content="no-transform"> 
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link href="css/page.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="css/index.css?<?php random();?>" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/page.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/index.js?<?php random();?>"></script>
	<style>
		.logo{background:url("<?php echo $global->getoption("logo");?>") no-repeat;background-size: 221px 60px;}
	</style>
</head>
<body>
<?php require_once('header.php');?>
<div id="content">
	<div></div>
	<div></div>
	<div id="project-info">
		<div class="base-info">
			<span class="cover-span"><img src="<?php if($array["cover"]==""){ echo $global->getoption("weburl")."images/default.png";}else{ echo $global->getoption("weburl").$array["cover"];}?>"></span>
			<span class="base-info-list">
				<ul>
					<input id="pid" type="hidden" value="<?php echo $array["id"];?>" />
					<li><span class="base-title">IP名称：</span><span class="base-val"><?php echo $array["title"];?></span><?php if($userInfo["grouplevel"]>=3){?><a target="_blank" href="admin/menu.php?id=<?php echo $array["id"];?>" class="edit-ico"></a><?php }?></li>
					<li><span class="base-title">平台/地点：</span><span class="base-val"><?php echo $array["platform"];?></span></li>
					<li><span class="base-title">类别：</span><span class="base-val"><?php echo "{$array["firstclass"]}>>{$array["secondclass"]}>>{$array["threeclass"]}";?></span></li>
					<li><span class="base-title">核心：</span><span class="base-val"><?php echo $array["core"];?></span></li>
					<li><span class="base-title">时间：</span><span class="base-val"><?php echo $array["datetime"];?></span></li>
					<li><span class="base-title">更新时间：</span><span class="base-val"><?php echo $array["date"];?></span></li>
					<li><span class="base-title">标签：</span><span class="base-val"><?php $tags=explode(",",$array["tags"]);foreach($tags as $val){echo "<a class='tags' href='screen.php?tags={$val}'>{$val}</a>,";} ?></span></li>
				</ul>
			</span>
		</div>
		<div class="details-info" id="top">
			<ul>
				<?php if($array["mode1"]!=""){?>
					<li><span class="base-title">合作形式1：</span><span class="model-value"><?php echo $array["mode1"];?></span><span class="base-title">刊例价1：</span><span class="model-value"><?php echo "¥".$array["price1"];?></span></li>
				<?php }?>
				<?php if($array["mode2"]!=""){?>
					<li><span class="base-title">合作形式2：</span><span class="model-value"><?php echo $array["mode2"];?></span><span class="base-title">刊例价2：</span><span class="model-value"><?php echo "¥".$array["price2"];?></span></li>
				<?php }?>
				<?php if($array["mode3"]!=""){?>
					<li><span class="base-title">合作形式3：</span><span class="model-value"><?php echo $array["mode3"];?></span><span class="base-title">刊例价3：</span><span class="model-value"><?php echo "¥".$array["price3"];?></span></li>
				<?php }?>
				<li><span class="base-title">推荐客户：</span><p><?php echo $array["channel"];?></p></li>
				<li><span class="base-title">负责人：</span><p><?php echo $array["director"];?></p></li>
				<li class="feedbcak-box">
					<div class="feedback-head"><span>意见反馈</span></div>
					<?php if($global->isFeedback($_SESSION["username"],$_GET["id"])!="success" && $userInfo["grouplevel"]>1){?>
					<div class="feedbcak-title"><span class="feedback-content-span"><textarea class="feedback-content" placeholder="对此项目做些反馈！"></textarea></span><span id="create-feedback" class="bg1 clw fs4 br3">新增反馈</span></div>
					<?php }?>
					<div class="feedback-list">
						<?php while($feedbackArr=$fresult->fetch_array(1)){?>
						<ul data-fid="<?php echo $feedbackArr["id"]; ?>">
							<li class="feed-list-user"><span><?php echo $feedbackArr["username"];?></span><span>发布时间：<?php echo $feedbackArr["createdate"];?></span><span>最后编辑：<?php echo $feedbackArr["lastdate"];?></span></li>
							<li class="feed-list-con"><p><?php echo $feedbackArr["feedback"];?></p></li>
							<li class="feed-list-date"><span class="times">编辑次数：<span><?php echo $feedbackArr["times"];?></span></span>
							<?php if($feedbackArr["username"]==$_SESSION["username"]){?>
							<span class="feedback-edit br3 bg4 clw">编辑</span>
							<?php }?>
							</li>
						</ul>
						<?php }?>
					</div>	
					<div class="more-div"><span class="feed-more-but">更多</span></div>
				</li>
				<div id="feedback-create-box"></div>
			</ul>
		</div>
		<div class="content-info" <?php if($array["content"]==""){ echo "style='display:none;'";}?>>
			<?php echo $global->de_quotes($array["content"]);?>
		</div>
		<?php if($array["pdfname"]!=""){?>
			<div style="margin:10px;"><span class="show-pdf-button" data-boxstate=0 data-pdfname="<?php echo $array["pdfname"];?>">点击查看PDF</span> <span class="down-pdf bg9 clw fs5 br3" data-pdfname="<?php echo $array["pdfname"];?>">下载本PDF</span></div>
			<p class="wap-pdf-msg">注意：部分手机可能无法在线观看PDF！点击会提示下载此PDF</p>
		<div class="show-pdf"><iframe src=""></iframe></div>
		<?php }?>
	</div>
	<div id="comment">
		<div class="my-comment">
			<div class="com-con-div" id="commeta"><textarea class="comment-content" placeholder="这项目有点意思！" data-rid=""></textarea></div>
			<div class="com-but-div"><span class="comment-but">我要评论</span></div>
		</div>
		<div class="comment-list">
		<?php while($commentArr=$result->fetch_array(1)){?>
			<ul>
				<li class="com-list-user"><span><?php echo $commentArr["username"];?></span></li>
				<li class="com-list-con"><?php if($commentArr["reply"]>0){$content=$global->getComment($commentArr["reply"]);echo "<span class='reply'>{$content}</span>";}?><span><?php echo $commentArr["comment"];?></span></li>
				<li class="com-list-date"><?php if($commentArr["username"]!=$_SESSION["username"]) {?><a class="com-reply br3 bg8 clw" href="#top" data-id="<?php echo $commentArr["id"];?>">回复</a><?php }?><span class="com-list-date"><?php echo $commentArr["date"];?></span></li>
			</ul>
		<?php }?>
		</div>
		<div class="more-div"><span class="more-but">更多</span></div>
	</div>
</div>
<?php require_once('footer.php');?>
</body>
</html>
