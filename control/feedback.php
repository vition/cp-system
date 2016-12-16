<?php 
	require_once('../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		load_class("message");
		load_class("projects");
		load_class("weixin");
		$weixin=new weixin($serverinfo);
		$user=new _user($serverinfo);
		$projects=new _projects($serverinfo);
		$message=new _message($serverinfo);
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
			$userArr=$projects->getRelevantUser($_POST["pid"]);
			$userNameArr=array();
			foreach($userArr as $val){
				if($val!=$_SESSION["username"]){
					$mes=array("type"=>"feedback","tid"=>$_POST["pid"],"from"=>$_SESSION["username"],"to"=>"{$val}","content"=>$global->en_quotes("您好！员工{$_SESSION["username"]}对与您相关的IP<a target='_blank' href='".$global->getoption("weburl")."page.php?id={$_POST["pid"]}'>【".$projects->getProjectKey($_POST["pid"])."】</a>做出了反馈，内容如下：{$_POST["contents"]}"));
					//print_r($mes);
					$message->sendMes($mes);
					array_push($userNameArr,$val);
				}
			}
			$wxids=$user->getUserId($userNameArr);
			$data=array("touser"=>"{$wxids}","msgtype"=> "text","agentid"=> 0,"text"=>array("content"=>"您好！您参与的IP【".$projects->getProjectKey($_POST["pid"])."】刚刚收到了一条反馈，内容如下：".$_POST["contents"]."。详情请使用电脑登录系统查看！"),"safe"=>"0");
			$weixin->send($data);
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
		if($result==1){
			$userArr=$projects->getRelevantUser($_POST["pid"]);
			$userNameArr=array();
			foreach($userArr as $val){
				if($val!=$_SESSION["username"]){
					$mes=array("type"=>"feedback","tid"=>$_POST["pid"],"from"=>$_SESSION["username"],"to"=>"{$val}","content"=>$global->en_quotes("您好！员工{$_SESSION["username"]}对与您相关的IP<a target='_blank' href='".$global->getoption("weburl")."page.php?id={$_POST["pid"]}'>【".$projects->getProjectKey($_POST["pid"])."】</a>做出了反馈，内容如下：{$_POST["content"]}"));
					//print_r($mes);
					$message->sendMes($mes);
					array_push($userNameArr,$val);
				}
				
			}
			$wxids=$user->getUserId($userNameArr);
			$data=array("touser"=>"{$wxids}","msgtype"=> "text","agentid"=> 0,"text"=>array("content"=>"您好！您参与的IP【".$projects->getProjectKey($_POST["pid"])."】刚刚更新了一条反馈，内容如下：".$_POST["content"]."。详情请使用电脑登录系统查看！"),"safe"=>"0");
			$weixin->send($data);
			
			echo json_encode(array("state"=>$result,"time"=>$time));
		}
		
		break;
	}
?>
