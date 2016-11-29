<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	switch($_POST["type"]){
		case "showgroup":
		$result=$global->query("SELECT distinct `group` FROM `user` ");
		if(isset($_POST["mode"])){
			echo "<li class='group-item'></li>";
			echo "<li class='group-item'>超级管理员</li>";
			
		}
		foreach($groupArr as $key=>$val){
			if($key!="超级管理员"){echo "<li class='group-item'>{$key}</li>";}
		}
		break;
		case "search":
		if(isset($_POST["data"])){
			$condition="";
			foreach($_POST["data"] as $key => $val){
				if($key=="group"){
					$condition.=" `{$key}` = '{$val}' AND";
				}else{
					$condition.=" `{$key}` LIKE '%{$val}%' AND";
				}
				
			}
			$condition=rtrim($condition,"AND");
			$result=$global->query("SELECT * FROM `user` WHERE".$condition." ORDER BY `id` DESC");
		}else{
			$result=$global->query("SELECT * FROM `user` ORDER BY `id` DESC");
		}
		echo '<li><span class="check-span">选择</span><span class="username-span">用户名</span><span class="group-span">组别</span><span class="psw-span-head">密码</span></li>';
		while($userArr=$result->fetch_array(1)){
			?>
			<li><span class="check-span"><input type="checkbox" class="user-control"></span><span class="username-span"><?php echo $userArr["username"];?></span><span  class="group-span" data-level="<?php echo $userArr["grouplevel"];?>"><?php echo $userArr["group"];?></span><span class="psw-span">********</span></li>
			<?php
		}
		break;
		case "create":
		if($user->isUser($_POST["data"]["username"])=="success"){
			echo "警告！ 用户【{$_POST["data"]["username"]}】 已存在";
		}else{
			$_POST["data"]["grouplevel"]=$groupArr[$_POST["data"]["group"]];
			if($user->createUser($_POST["data"])=="success"){
				echo " 用户【{$_POST["data"]["username"]}】 创建成功";
			}else{
				echo " 用户【{$_POST["data"]["username"]}】 创建失败";
			}
			// $query="INSERT INTO `user`(`username`, `password`, `group`, `grouplevel`,`state`) VALUES ('{$_POST["data"]["username"]}','".sha1($_POST["data"]["psw"])."','{$_POST["data"]["group"]}','{$groupArr[$_POST["data"]["group"]]}','1')";
			// $result=$global->query($query);
		}
		
		break;
		case "del":
		$condition="";
		foreach($_POST["data"] as $val){
			$condition.="'{$val}',";
		}
		$condition=rtrim($condition,",");
		//echo "DELETE FROM `user` WHERE `username` in ({$condition})";
		$result=$global->query("DELETE FROM `user` WHERE `username` in ({$condition})");
		echo "用户 {$condition} 删除成功";
		break;
		case "resetpsw":
		if($user->checkPsw($_SESSION["username"],$_POST["data"][2])=="success"){
			$user->changePsw($_POST["data"][0],$_POST["data"][1]);
			echo "用户 【{$_POST["data"][0]}】 成功修改密码";
		}else{
			echo "管理密码不正确！";
		}
		break;
		case "freeze":
		foreach($_POST["data"] as $val){
			$user->activUser($val,false);
		}
		break;
	}
	//ALTER TABLE `user` ADD `state` INT(1) NOT NULL DEFAULT '1' ;
?>
