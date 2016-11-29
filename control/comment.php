<?php 
	require_once('../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		load_class("message");
		load_class("projects");
		$user=new _user($serverinfo);
		$projects=new _projects($serverinfo);
		$message=new _message($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	switch($_POST["type"]){
		case "insert":
		$date=date("Y-m-d H:i:s");
		$result=$global->query("INSERT INTO `comment`(`pid`, `username`, `comment`, `date`, `verify`) VALUES ('{$_POST["pid"]}','{$_SESSION["username"]}','{$_POST["content"]}','{$date}','0')");
		if($result==1){
			$userArr=$projects->getRelevantUser($_POST["pid"]);
			foreach($userArr as $val){
				if($val!=$_SESSION["username"]){
					$mes=array("tid"=>$_POST["pid"],"from"=>$_SESSION["username"],"to"=>"{$val}","content"=>"您好！员工{$_SESSION["username"]}对与您相关的IP【<a target='_blank' href='".$global->getoption("weburl")."page.php?id={$_POST["pid"]}'>".$projects->getProjectKey($_POST["pid"])."</a>】做出了评论，内容如下：{$_POST["content"]}");
					//print_r($mes);
					$message->sendMes($mes);
				}
				
			}
			
			//$message->sendMes();
			//echo json_encode(array("username"=>$_SESSION["username"],"comment"=>$_POST["content"],"date"=>$date));
			?>
			<ul>
				<li class="com-list-user"><span><?php echo $_SESSION["username"];?></span></li>
				<li class="com-list-con"><span><?php echo $_POST["content"];?></span></li>
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
			<li class="com-list-date"><span><?php echo $commentArr["date"];?></span></li>
		</ul>
		<?php
		}
		break;
	}
?>
