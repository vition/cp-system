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
		$result=$global->query("SELECT distinct `group` FROM `user` ");//SELECT `value2` as `group`,`grouplevel`,`wxid` FROM `user`,`option` WHERE `user`.`username`='vition' AND `option`.`item` REGEXP 'level-[0-9]+' AND `option`.`value`=`user`.`grouplevel`
		if(isset($_POST["mode"])){
			echo "<li class='group-item'>所有</li>";
			echo "<li class='group-item'>";
			echo $global->getLevel("4");
			echo "</li>";
			
		}
		foreach($groupArr as $key=>$val){
			if($key!=$global->getLevel("4")){echo "<li class='group-item'>{$key}</li>";}
		}
		break;
		case "search":
		$everyPage=15;
		$cquery="SELECT `user`.`id`,`username`,`value2` as `group`,`grouplevel`,`state`,`remark`,`wxid` FROM `user`,`option` WHERE `option`.`item` REGEXP 'level-[0-9]+' AND `option`.`value`=`user`.`grouplevel` ";
		$countResult=$global->query($cquery);
		$count=$countResult->num_rows;
		if(isset($_POST["data"])){
			$condition="";
			foreach($_POST["data"] as $key => $val){
				if($key=="group"){
					$key="grouplevel";
					if($val=="所有"){
						$condition.="`option`.`item` REGEXP 'level-[0-9]+' AND";
					}else{
						$condition.="`option`.`item` REGEXP 'level-[0-9]+' AND `option`.`value2`='{$val}' AND";
					}
					
				}else{
					$condition.=" `{$key}` LIKE '%{$val}%' AND";
				}
				
			}
			$condition=rtrim($condition,"AND");
			$query="SELECT `user`.`id`,`username`,`value2` as `group`,`grouplevel`,`state`,`remark`,`wxid` FROM `user`,`option` WHERE".$condition." AND `option`.`value`=`user`.`grouplevel` ORDER BY `user`.`id` DESC LIMIT {$_POST["row"]},{$everyPage}";
		}else{
			$query="SELECT `user`.`id`,`username`,`value2` as `group`,`grouplevel`,`state`,`remark`,`wxid` FROM `user`,`option` WHERE `option`.`value`=`user`.`grouplevel` ORDER BY `user`.`id` DESC LIMIT {$_POST["row"]},{$everyPage}";
		}
		$result=$global->query($query);
		//echo '<li><span class="check-span">选择</span><span class="username-span">用户名</span><span class="group-span">组别</span><span class="psw-span-head">密码</span></li>';
		//while($userArr=$result->fetch_array(1)){
			?>
			<!--<li><span class="check-span"><input type="checkbox" class="user-control"></span><span class="username-span"><?php //echo $userArr["username"];?></span><span  class="group-span" data-level="<?php //echo $userArr["grouplevel"];?>"><?php //echo $userArr["group"];?></span><span class="psw-span">********</span></li>-->
			<?php
		//}
		?>
		<table class="v-table">
			<tr class="list-header" ><th style="width:50px;">选择</th><th style="width:150px;">用户名</th><th style="width:100px;">组别</th><th style="width:150px;">密码</th><th style="width:150px;">微信企业号ID</th><th style="width:130px;">备注</th></tr>
			<?php 
				while($userArr=$result->fetch_array(1)){
			?>
			<tr><td><input class="user-control" type="checkbox" data-id="<?php echo $userArr["id"];?>"/></td><td><a class="comment-edit" data-id="<?php echo $userArr["id"];?>"><?php echo $userArr["username"];?></a></td><td id="changeg-<?php echo $userArr["id"];?>" data-id="changeg" class="change-group"><?php echo $userArr["group"];?></td><td><span class="psw-span">********</span></td><td><?php echo $userArr["wxid"];?></td><td class="remark-change" data-id="<?php echo $userArr["id"];?>"><span class="remark-title"><?php echo $userArr["remark"];?><span></td></tr>
			<?php }?>
		</table>
		<div class="page-div"><span class="page-info">共<?php echo ceil($count/$everyPage);?>页 | <?php echo $count."个用户";?> | 当前第<?php echo ceil($_POST["row"]/$everyPage)+1;?>页</span><?php if($count>0){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="0">首页</span><?php } if($_POST["row"]>=$everyPage){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="<?php echo $_POST["row"]-$everyPage;?>">上一页</span><?php } if(($count-$everyPage)>0 && ($count>($_POST["row"]+$everyPage))){?><span class="prev-page but2 bg6 br3 clw go-page" data-page="<?php echo ($_POST["row"]+$everyPage);?>">下一页</span><?php } if(($count-$everyPage)>$everyPage-2){?><span class="next-page but2 bg6 br3 clw go-page" data-page="<?php echo (ceil($count/$everyPage)*$everyPage-$everyPage);?>">尾页</span><?php }?></div>
		<?php
		break;
		case "create":
		if($user->isUser($_POST["data"]["username"])=="success"){
			echo "警告！ 用户【{$_POST["data"]["username"]}】 已存在";
		}else{
			$_POST["data"]["grouplevel"]=$groupArr[$_POST["data"]["group"]];
			if($user->createUser($_POST["data"])=="success"){
				echo " 用户【{$_POST["data"]["username"]}】 创建成功";
				$user->ulog($_SESSION["username"],"新建用户{$_POST["data"]["username"]}");
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
		$user->ulog($_SESSION["username"],"删除用户",$_POST);
		echo "用户 {$condition} 删除成功";
		break;
		case "resetpsw":
		if($user->checkPsw($_SESSION["username"],$_POST["data"][2])=="success"){
			$user->changePsw($_POST["data"][0],$_POST["data"][1]);
			echo "用户 【{$_POST["data"][0]}】 成功修改密码";
			$user->ulog($_SESSION["username"],"修改用户{$_POST["data"][0]}的密码");
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
		$change=$user->changeGroup($_POST["name"],$_POST["group"],$groupArr[$_POST["group"]]);
		if($change=="success"){
			$user->ulog($_SESSION["username"],"修改用户{$_POST["name"]}用户的级别",$_POST);
			echo "级别修改成功！";
		}
		break;
		case "changeremark":
		$change=$user->changeRemark($_POST["username"],$_POST["remark"]);
		if($change=="success"){
			$user->ulog($_SESSION["username"],"修改用户{$_POST["username"]}的备注",$_POST);
			echo "备注修改成功！";
		}
		break;
	}
	//ALTER TABLE `user` ADD `state` INT(1) NOT NULL DEFAULT '1' ;
?>
