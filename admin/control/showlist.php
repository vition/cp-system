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
	$everyPage=30;
	switch($_POST["type"]){
		case "search":
		if(isset($_POST["data"])){
			$condition="";
			foreach($_POST["data"] as $key=>$val){
				$condition.="`{$key}` LIKE '%{$val}%' AND ";
			}
			$condition=rtrim($condition,"AND ");
			$cquery="SELECT `id` FROM `projects` WHERE {$condition} ORDER BY `date` DESC";
			$countResult=$global->query($cquery);
			$count=$countResult->num_rows;
			$query="SELECT * FROM `projects` WHERE {$condition} ORDER BY `date` DESC LIMIT {$_POST["row"]},{$everyPage}";
		}else{
			$cquery="SELECT * FROM `projects` ORDER BY `date` DESC";
			$countResult=$global->query($cquery);
			$count=$countResult->num_rows;
			$query="SELECT * FROM `projects` ORDER BY `date` DESC LIMIT {$_POST["row"]},{$everyPage}";
		}
		
		//print_r($_POST);
		$result=$global->query($query);
		?>
		<table>
			<tr class="list-header" ><th style="width:35px;">选择</th><th style="width:160px;">项目名称</th><th style="width:90px;">发布平台</th><th style="width:150px;">核心</th><th style="width:100px;">更新时间</th><th style="width:80px;">前端查看</th><th style="width:80px;">CP方联系人</th><th style="width:80px;">联系方式</th></tr>
			<?php 
				while($array=$result->fetch_array(1)){
			?>
			<tr><td><input class="p-select" type="checkbox" data-id="<?php echo $array["id"];?>"/></td><td><a href="insert.php?id=<?php echo $array["id"];?>" title="<?php echo $array["title"];?>"><?php echo $global->seizeStr($array["title"],30);?></a></td><td title="<?php echo $array["platform"];?>"><?php echo $global->seizeStr($array["platform"],18);?></td><td title="<?php echo $array["core"];?>"><?php echo $global->seizeStr($array["core"],30);?></td><td><?php echo date("y-m-d H:i",strtotime($array["date"]));?></td><td><a class="view-page" target="_blank" href="../page.php?id=<?php echo $array["id"]; ?>">查看</a></td><td title="<?php echo $array["contact"];?>"><?php echo $global->seizeStr($array["contact"],18);?></td><td title="<?php echo $array["telephone"];?>"><?php echo $global->seizeStr($array["telephone"],18);?></td></tr>
			<?php }?>
			
		</table>
		<div class="page-div"><span class="page-info">共<?php echo ceil($count/$everyPage);?>页 | <?php echo $count."个IP";?> | 当前第<?php echo ceil($_POST["row"]/$everyPage)+1;?>页</span><?php if($count>0){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="0">首页</span><?php } if($_POST["row"]>=$everyPage){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="<?php echo $_POST["row"]-$everyPage;?>">上一页</span><?php } if(($count-$everyPage)>0 && ($count>($_POST["row"]+$everyPage))){?><span class="prev-page but2 bg6 br3 clw go-page" data-page="<?php echo ($_POST["row"]+$everyPage);?>">下一页</span><?php } if(($count-$everyPage)>$everyPage-2){?><span class="next-page but2 bg6 br3 clw go-page" data-page="<?php echo (ceil($count/$everyPage)*$everyPage-$everyPage);?>">尾页</span><?php }?></div>
		<?php
		break;
		case "del":
		$project->delProject($_POST["data"]);
		$user->ulog($_SESSION["username"],"删除了项目",$_POST);
		break;
	}
?>

