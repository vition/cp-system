<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	//print_r($_POST);
	switch($_POST["type"]){
		case "showgroup":
		$result=$global->query("SELECT distinct `group` FROM `user` ");
		if(isset($_POST["mode"])){
			echo "<li class='group-item'>所有</li>";
			echo "<li class='group-item'>宙斯</li>";
			
		}
		foreach($groupArr as $key=>$val){
			if($key!="宙斯"){echo "<li class='group-item'>{$key}</li>";}
		}
		break;
		case "search":
		$everyPage=20;
		$cquery="SELECT * FROM `user` ORDER BY `id` DESC";
		$countResult=$global->query($cquery);
		$count=$countResult->num_rows;
		if(isset($_POST["data"])){
			$condition="";
			foreach($_POST["data"] as $key => $val){
				if($key=="group"){
					if($val!="所有"){
						$condition.=" `{$key}` = '{$val}' AND";
					}else{
						$condition.=" `{$key}` LIKE '%%' AND";
					}
					
				}else{
					$condition.=" `{$key}` LIKE '%{$val}%' AND";
				}
				
			}
			$condition=rtrim($condition,"AND");
			$query="SELECT * FROM `user` WHERE".$condition." ORDER BY `id` DESC LIMIT {$_POST["row"]},{$everyPage}";
		}else{
			$query="SELECT * FROM `user` ORDER BY `id` DESC LIMIT {$_POST["row"]},{$everyPage}";
		}
		//echo $query;
		$result=$global->query($query);
		//echo '<li><span class="check-span">选择</span><span class="username-span">用户名</span><span class="group-span">组别</span><span class="psw-span-head">密码</span></li>';
		//while($userArr=$result->fetch_array(1)){
			?>
			<!--<li><span class="check-span"><input type="checkbox" class="user-control"></span><span class="username-span"><?php //echo $userArr["username"];?></span><span  class="group-span" data-level="<?php //echo $userArr["grouplevel"];?>"><?php //echo $userArr["group"];?></span><span class="psw-span">********</span></li>-->
			<?php
		//}
		?>
		<table class="v-table">
			<tr class="list-header" ><th style="width:50px;">选择</th><th style="width:200px;">用户名</th><th style="width:100px;">组别</th><th style="width:200px;">密码</th><th style="width:130px;">备注</th></tr>
			<?php 
				while($userArr=$result->fetch_array(1)){
			?>
			<tr><td><input class="user-control" type="checkbox" data-id="<?php echo $userArr["id"];?>"/></td><td><a class="comment-edit" data-id="<?php echo $userArr["id"];?>"><?php echo $userArr["username"];?></a></td><td id="changeg-<?php echo $userArr["id"];?>" data-id="changeg" class="change-group"><?php echo $userArr["group"];?></td><td><span class="psw-span">********</span></td><td class="remark-change" data-id="<?php echo $userArr["id"];?>"><?php echo $userArr["remark"];?></td></tr>
			<?php }?>
		</table>
		<div class="page-div"><?php if($count>0){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="0">首页</span><?php } if($_POST["row"]>=$everyPage){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="<?php echo $_POST["row"]-$everyPage;?>">上一页</span><?php } if(($count-$everyPage)>0 && ($count>($_POST["row"]+$everyPage))){?><span class="prev-page but2 bg6 br3 clw go-page" data-page="<?php echo ($_POST["row"]+$everyPage);?>">下一页</span><?php } if(($count-$everyPage)>$everyPage-2){?><span class="next-page but2 bg6 br3 clw go-page" data-page="<?php echo (ceil($count/$everyPage)*$everyPage-$everyPage);?>">尾页</span><?php }?></div>
		<?php
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
		case "changegroup":
		//print_r($_POST);
		$change=$user->changeGroup($_POST["uid"],$_POST["group"],$groupArr[$_POST["group"]]);
		if($change=="success"){
			echo "级别修改成功！";
		}
		break;
		case "changeremark":
		$change=$user->changeRemark($_POST["uid"],$_POST["remark"]);
		if($change=="success"){
			echo "备注修改成功！";
		}
		break;
	}
	//ALTER TABLE `user` ADD `state` INT(1) NOT NULL DEFAULT '1' ;
?>
