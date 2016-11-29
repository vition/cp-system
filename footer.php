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
?>
<footer class="footer">
		<div class="bottom-bg">
			<?php echo $global->getoption("foothtml");?>
		</div>
</footer>

