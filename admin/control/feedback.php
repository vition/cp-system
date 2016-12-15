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
	$everyPage=15;
	switch($_POST["type"]){
		case "search":
		$cquery="SELECT * FROM `feedback` ORDER BY `lastdate` DESC";
		$countResult=$global->query($cquery);
		$count=$countResult->num_rows;
		$query="SELECT * FROM `feedback` ORDER BY `lastdate` DESC LIMIT {$_POST["row"]},{$everyPage}";
		$result=$global->query($query);
		?>
		<table class="v-table">
			<tr class="list-header" ><th style="width:50px;">选择</th><th style="width:150px;">IP名称</th><th style="width:100px;">反馈者</th><th style="width:150px;">反馈内容</th><th style="width:130px;">发布时间</th><th style="width:130px;">最后编辑时间</th><th style="width:60px;">编辑次数</th></tr>
			<?php 
				while($array=$result->fetch_array(1)){
			?>
			<tr><td><input class="f-select" type="checkbox" data-id="<?php echo $array["id"];?>"/></td><td><a class="feedback-edit" data-id="<?php echo $array["id"];?>" title="<?php echo $project->getProjectKey($array["pid"]);?>" target="_blank" href="../page.php?id=<?php echo $array["pid"];?>"><?php echo $global->seizeStr($project->getProjectKey($array["pid"]),30);?></a></td><td><?php echo $array["username"];?></td><td title="<?php echo $array["feedback"];?>"><?php echo $global->seizeStr($array["feedback"],30);?></td><td><?php echo $array["createdate"];?></td><td><?php echo $array["lastdate"];?></td><td><?php echo $array["times"];?></td></tr>
			<?php }?>
			
		</table>
		<div class="page-div"><span class="page-info">共<?php echo ceil($count/$everyPage);?>页 | <?php echo $count."条反馈";?> | 当前第<?php echo ceil($_POST["row"]/$everyPage)+1;?>页</span><?php if($count>0){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="0">首页</span><?php } if($_POST["row"]>=$everyPage){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="<?php echo $_POST["row"]-$everyPage;?>">上一页</span><?php } if(($count-$everyPage)>0 && ($count>($_POST["row"]+$everyPage))){?><span class="prev-page but2 bg6 br3 clw go-page" data-page="<?php echo ($_POST["row"]+$everyPage);?>">下一页</span><?php } if(($count-$everyPage)>$everyPage-2){?><span class="next-page but2 bg6 br3 clw go-page" data-page="<?php echo (ceil($count/$everyPage)*$everyPage-$everyPage);?>">尾页</span><?php }?></div>
		
		<?php
		break;
		case "del":
		$idStr="";
		foreach($_POST["data"] as $id){
			$idStr.="'{$id}',";
		}
		$idStr=rtrim($idStr,",");
		$global->query("DELETE FROM `feedback` WHERE `id` in ({$idStr})");
		$user->ulog($_SESSION["username"],"删除了反馈",$_POST);
		break;
	}
?>

