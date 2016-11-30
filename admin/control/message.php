<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("projects");
		load_class("message");
		$projects=new _projects($serverinfo);
		$message=new _message($serverinfo);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	
	if(isset($_POST["state"])){
		$read=$_POST["state"];
	}else{
		$read=0;
	}
	$everyPage=5;
	switch($_POST["type"]){
		case "search":
		$cquery="SELECT * FROM `message` WHERE `to`='{$_SESSION["username"]}' AND `state`='{$read}' ORDER BY `date` DESC";
		$countResult=$global->query($cquery);
		$count=$countResult->num_rows;
		$query="SELECT * FROM `message` WHERE `to`='{$_SESSION["username"]}' AND `state`='{$read}' ORDER BY `date` DESC LIMIT {$_POST["row"]},{$everyPage}";
		$result=$global->query($query);
		?>
		<div style="text-align:right;"><span style="margin:5px;display:inline-block;width:16px;height:16px;line-height:16px;font-size:0.8em;text-align:center;color:red;border:1px solid red;cursor:pointer" class="close_box">X</span></div>
		<table class="v-table">
			<tr class="list-header" ><th style="width:50px;">选择</th><th style="width:50px;">类型</th><th style="width:150px;">相关IP</th><th style="width:75px;">来自</th><th style="width:80px;">发布时间</th><th class="state" style="width:40px;">状态</th></tr>
			<?php 
				while($array=$result->fetch_array(1)){
			?>
			<tr class="mes-list <?php if($array["state"]==0){echo "unread";}else{echo "read";} ?>" data-id="<?php echo $array["id"];?>"><td><input class="m-select" type="checkbox" data-id="<?php echo $array["id"];?>"/></td><td><a class="comment-edit" data-id="<?php echo $array["id"];?>" ><?php echo $mesType[$array["type"]];?></a></td><td><?php echo $global->seizeStr($projects->getProjectKey($array["tid"]),30);?></td><td><?php echo $array["to"];?></td><td><?php echo date("m-d H:i",strtotime($array["date"]));?></td><td ><span class="<?php if($array["state"]==0){echo "unread-ico";}else{echo "read-ico";} ?>"></span></td></tr>
			<?php }?>
		</table>
		<div class="mes-search-div"><span class="read-ico search-ico" data-state="read"></span><span class="unread-ico search-ico" data-state="unread"></span><input id="read-state" type="hidden" value="<?php echo $read;?>"></div>
		<div class="page-div"><?php if($count>0){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="0">首页</span><?php } if($_POST["row"]>=$everyPage){?><span class="prev-page go-page but2 bg6 br3 clw" data-page="<?php echo $_POST["row"]-$everyPage;?>">上一页</span><?php } if(($count-$everyPage)>0 && ($count>($_POST["row"]+$everyPage))){?><span class="prev-page but2 bg6 br3 clw go-page" data-page="<?php echo ($_POST["row"]+$everyPage);?>">下一页</span><?php } if(($count-$everyPage)>$everyPage-2){?><span class="next-page but2 bg6 br3 clw go-page" data-page="<?php echo (ceil($count/$everyPage)*$everyPage-$everyPage);?>">尾页</span><?php }?></div>
		<?php
		break;
		case "showmes":
		$message->setState($_POST["id"]);
		$mesArr=$message->getMes($_POST["id"]);
		?>
			<div class="mes-info"><span>信息类型：<?php echo $mesType[$mesArr["type"]];?></span><span>发布者：<?php echo $mesArr["from"];?></span><span>时间：<?php echo $mesArr["date"];?></span></div>
			<div class="mes-ip"><span>IP名称：<?php echo $projects->getProjectKey($mesArr["tid"])?></span></div>
			<div class="mes-content"><p><?php echo $global->de_quotes($mesArr["content"]);?></p></div>
			<input id="unread-num" type="hidden" value="<?php echo $message->unread($_SESSION["username"]);?>"/>
		<?php
		break;
	}
?>

