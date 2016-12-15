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
		case "insert":
		//print_r($_POST);
		preg_match("/^@\w+(\:)/",$_POST["content"],$content);
		$date=date("Y-m-d H:i:s");
		$userArr=$projects->getRelevantUser($_POST["pid"]);
		if(empty($content)){
			$result=$global->query("INSERT INTO `comment`(`pid`, `username`, `comment`, `date`, `verify`) VALUES ('{$_POST["pid"]}','{$_SESSION["username"]}','{$_POST["content"]}','{$date}','0')");
		}else{
			$_POST["content"]=str_replace($content[0],"",$_POST["content"]);
			if(strlen($_POST["content"])>0){
				$result=$global->query("INSERT INTO `comment`(`pid`, `username`,`reply`,`comment`, `date`, `verify`) VALUES ('{$_POST["pid"]}','{$_SESSION["username"]}','{$_POST["rid"]}','{$_POST["content"]}','{$date}','0')");
				array_push($userArr,$global->getComment($_POST["rid"],"username"));
			}else{
				return;
			}
			
		}
		if($result==1){
			$userNameArr=array();
			foreach($userArr as $val){
				if($val!=$_SESSION["username"]){
					$mes=array("type"=>"comment","tid"=>$_POST["pid"],"from"=>$_SESSION["username"],"to"=>"{$val}","content"=>$global->en_quotes("您好！员工{$_SESSION["username"]}对与您相关的IP<a target='_blank' href='".$global->getoption("weburl")."page.php?id={$_POST["pid"]}'>【".$projects->getProjectKey($_POST["pid"])."】</a>做出了评论，内容如下：{$_POST["content"]}"));
					//print_r($mes);
					$message->sendMes($mes);
				}
				array_push($userNameArr,$val);
			}
			$wxids=$user->getUserId($userNameArr);
			$id=$_POST["pid"];
			$data=array("touser"=>"{$wxids}","msgtype"=> "text","agentid"=> 0,"text"=>array("content"=>"您好！您参与的IP【".$projects->getProjectKey($_POST["pid"])."】刚刚收到了一条评论，内容如下：".$_POST["content"]."。详情请使用电脑登录系统查看！"),"safe"=>"0");
			$weixin->send($data);
			
			//$message->sendMes();
			//echo json_encode(array("username"=>$_SESSION["username"],"comment"=>$_POST["content"],"date"=>$date));
			?>
			<ul>
				<li class="com-list-user"><span><?php echo $_SESSION["username"];?></span></li>
				<li class="com-list-con"><?php if($_POST["rid"]>0){$content=$global->getComment($_POST["rid"]);echo "<span class='reply'>{$content}</span>";}?><span><?php echo $_POST["content"];?></span></li>
				<li class="com-list-date"><span><?php echo $date;?></span></li>
			</ul>
			<?php
		}
		
		//echo $result;
		break;
		case "before":
		break;
		case "last":
		$limit=$_POST["limit"];
		$result=$global->query("SELECT * FROM `comment` WHERE `pid`='{$_POST["pid"]}' ORDER BY `date` DESC LIMIT {$limit},5");
		while($commentArr=$result->fetch_array(1)){
		?>
		<ul>
			<li class="com-list-user"><span><?php echo $commentArr["username"];?></span></li>
			<li class="com-list-con"><span><?php echo $commentArr["comment"];?></span></li>
			<li class="com-list-date"><?php if($commentArr["username"]!=$_SESSION["username"]) {?><a class="com-reply br3 bg8 clw" href="#top" data-id="<?php echo $commentArr["id"];?>">回复</a><?php } ?><span><?php echo $commentArr["date"];?></span></li>
		</ul>
		<?php
		}
		
		break;
	}
?>
