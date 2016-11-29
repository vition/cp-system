<?php 
	require_once('../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	switch($_POST["type"]){
		case "create":
		$time=date("Y-m-d H:i:s");
		$result=$global->query("INSERT INTO `feedback`(`pid`, `username`, `feedback`, `createdate`, `prevdate`, `lastdate`, `times`, `state`) VALUES ('{$_POST["pid"]}','{$_SESSION["username"]}','{$_POST["contents"]}','{$time}','{$time}','{$time}','1','0')");
		if($result==1){
			$query="SELECT `id` FROM `feedback` WHERE `pid`='{$_POST["pid"]}' AND `username`='{$_SESSION["username"]}'";
			$result=$global->query($query);
			$array=$result->fetch_array(1);
			?>
			<ul data-fid="<?php echo $array["id"];?>">
				<li class="feed-list-user"><span><?php echo $_SESSION["username"];?></span><span>发布时间：<?php echo $time;?></span><span>最后编辑：<?php echo $time;?></span></li>
				<li class="feed-list-con"><p><?php echo $_POST["contents"];?></p></li>
				<li class="feed-list-date"><span class="times">编辑次数：<span>1</span></span><span class="feedback-edit br3 bg4 clw">编辑</span></li>
			</ul>
			<?php
		}
		break;
		case "update":
		$time=date("Y-m-d H:i:s");
		$query="UPDATE `feedback` SET `pid`='{$_POST["pid"]}',`username`='{$_SESSION["username"]}',`feedback`='{$_POST["content"]}',`prevdate`=`lastdate`,`lastdate`='{$time}',`times`=`times`+1 WHERE `id`='{$_POST["fid"]}'";
		$result=$global->query($query);
		echo json_encode(array("state"=>$result,"time"=>$time));
		break;
	}
?>
