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
	$search=isset($_GET["search"])?urldecode($_GET["search"]):"";
?>
<div id="header">
	<div class="user-info-box" ><span class="user-name"><?php echo $_SESSION["username"];?>  您好！</span><span class="user-time">现在是 <?php echo date("Y-m-d H:i:s",time());?></span><span class="user-group">您的级别是：<?php echo $userinfo["group"];?></span></div>
	<div class="logo-nav">
		<div class="logo">
		</div>
		<div class="navs">
			<ul>
				<li><a id="home-url" href="<?php echo $global->getoption("weburl");?>" <?php if($global->thisPhp()=="index.php"){ echo "class='nav-ative'";}?>>首页</a></li>
				<li><a href="screen.php" <?php if($global->thisPhp()=="screen.php"){ echo "class='nav-ative'";}?>>查询</a></li>
				<?php if($userinfo["grouplevel"]>=3){echo '<li><a href="'.$global->getoption("weburl").'admin" target="_blank">后台</a></li><li><a href="?logout">退朝</a></li>';}else{echo '<li><a href="?logout">退朝</a></li>';} ?>
			</ul>
			<span id="title-screen-box"><input type="text" value="<?php echo $search;?>"/><span id="search-but">搜索</span></span>
		</div>
	</div>
</div>
