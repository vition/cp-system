<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("projects");
		$project=new _projects($serverinfo);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	switch($_POST["type"]){
		case "search":
		$query="SELECT * FROM `news` ORDER BY `time` DESC LIMIT 0,5";
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
		break;
		case "updata":
		$keyStr="";
		foreach($_POST["data"] as $key=>$val){
			$keyStr.="`{$key}`='{$val}',";
		}
		$result=$global->query("UPDATE `news` SET {$keyStr}`time`='".date("Y-m-d H:h:s")."',`author`='{$_SESSION["username"]}' WHERE `id`='{$_POST["id"]}'");
		if($result>0){
			echo true;
		}else{
			echo "新增公告失败";
		}
		break;
	}
?>

