<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("projects");
		$project=new _projects($serverinfo);
		load_class("user");
		$user=new _user($serverinfo);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	$everyPage=10;
	switch($_POST["type"]){
		case "search":
		$cquery="SELECT * FROM `news` ORDER BY `time` DESC";
		$countResult=$global->query($cquery);
		$count=$countResult->num_rows;
		$query="SELECT * FROM `news` ORDER BY `time` DESC LIMIT {$_POST["row"]},{$everyPage}";
		$result=$global->query($query);
		?>
		<table class="v-table">
			<tr class="list-header" ><th style="width:50px;">选择</th><th style="width:200px;">标题</th><th style="width:280px;">内容</th><th style="width:100px;">发布者</th><th style="width:130px;">发布时间</th></tr>
			<?php 
				while($array=$result->fetch_array(1)){
			?>
			<tr><td><input class="n-select" type="checkbox" data-id="<?php echo $array["id"];?>"/></td><td><a class="notice-edit" data-id="<?php echo $array["id"];?>" title="<?php echo $array["title"];?>"><?php echo $global->seizeStr($array["title"],45);?></a></td><td title="<?php echo $array["content"];?>"><?php echo $global->seizeStr($array["content"],60);?></td><td><?php echo $array["author"];?></td><td><?php echo $array["time"];?></td></tr>
			<?php }?>
			
		</table>
		<div class="page-div"><span class="page-info">共<?php echo ceil($count/$everyPage);?>页 | <?php echo $count."条公告";?> | 当前第<?php echo ceil($_POST["row"]/$everyPage)+1;?>页</span><?php if($count>0){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="0">首页</span><?php } if($_POST["row"]>=$everyPage){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="<?php echo $_POST["row"]-$everyPage;?>">上一页</span><?php } if(($count-$everyPage)>0 && ($count>($_POST["row"]+$everyPage))){?><span class="prev-page but2 bg6 br3 clw go-page" data-page="<?php echo ($_POST["row"]+$everyPage);?>">下一页</span><?php } if(($count-$everyPage)>$everyPage-2){?><span class="next-page but2 bg6 br3 clw go-page" data-page="<?php echo (ceil($count/$everyPage)*$everyPage-$everyPage);?>">尾页</span><?php }?></div>
		<?php
		break;
		case "create":
		$keyStr="";
		$valStr="";
		foreach($_POST["data"] as $key=>$val){
			$keyStr.="`{$key}`,";
			$valStr.="'{$val}',";
		}
		$result=$global->query("INSERT INTO `news`({$keyStr}`author`, `time`) VALUES ({$valStr}'{$_SESSION["username"]}','".date("Y-m-d H:h:s")."')");
		if($result>0){
			echo "成功新增公告";
			$user->ulog($_SESSION["username"],"添加了公告",$_POST);
		}else{
			echo "新增公告失败";
		}
		break;
		case "del":
		$idStr="";
		foreach($_POST["data"] as $id){
			$idStr.="'{$id}',";
		}
		$idStr=rtrim($idStr,",");
		$global->query("DELETE FROM `news` WHERE `id` in ({$idStr})");
		$user->ulog($_SESSION["username"],"删除了公告",$_POST);
		break;
		case "updata":
		$keyStr="";
		foreach($_POST["data"] as $key=>$val){
			$keyStr.="`{$key}`='{$val}',";
		}
		$result=$global->query("UPDATE `news` SET {$keyStr}`time`='".date("Y-m-d H:h:s")."',`author`='{$_SESSION["username"]}' WHERE `id`='{$_POST["id"]}'");
		if($result>0){
			echo true;
			$user->ulog($_SESSION["username"],"修改了公告",$_POST);
		}else{
			echo "新增公告失败";
		}
		break;
	}
?>

