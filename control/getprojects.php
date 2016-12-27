<?php 
	require_once('../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	//print_r($_POST);
	switch($_POST["type"]){
		case "title":
		$result=$global->query("SELECT * FROM `projects` WHERE `title` LIKE '%{$_POST["title"]}%'");
		if($result->num_rows>0){
			while($projects=$result->fetch_array(1)){
				
?>				<ul class="post big-post">
					<div class="cover" cover-text="<?php echo $projects["title"];?>" >
						<a href="page.php?id=<?php echo $projects["id"];?>" hidefocus="true" target="_blank"><img alt="<?php echo $projects["title"];?>" style="display: block;" src="<?php echo $global->getoption("weburl").$projects["cover"];?>"><div class="overlay" style="display: none;"><?php echo $projects["title"];?><span style="color: rgb(255, 0, 153);"></span></div></a>
					</div>
					<li><label>项目名称 / </label><a href="page.php?id=<?php echo $projects["id"];?>" title="<?php echo $projects["title"];?>" hidefocus="true" class="nickname" target="_blank"><?php echo $global->seizeStr($projects["title"],36);?></a></li>
					<li><label>平台/地点 / </label><span title="<?php echo $projects["platform"];?>"><?php echo $global->seizeStr($projects["platform"],26);?></span></li>
					<li><label>播出时间 / </label><span title="<?php echo $projects["datetime"];?>"><?php echo $global->seizeStr($projects["datetime"],26);?></span></li>
				</ul>
<?php		}
		}else{
			echo "<div style='text-align: center;color:#FF0000;'>我不知道，就是不知道！别再问我了！</div>";
		}
		break;
		case "condition":
		switch($_POST["cond"]){
			case "class":
			if(isset($_POST["val"])){
				$result=$global->query("SELECT `subordinate` FROM `classif` WHERE `subordinate` NOT IN (SELECT `superiors` FROM `classif`) AND `subordinate` LIKE '%{$_POST["val"]}%'");
			}else{
				$result=$global->query("SELECT `subordinate` FROM `classif` WHERE `subordinate` NOT IN (SELECT `superiors` FROM `classif`)");
			}
			
			while($classArr=$result->fetch_array(1)){
				echo "<span class='condition-item'>{$classArr["subordinate"]}</span>";
			}
			break;
			case "platform":
			$classResult=$global->query("SELECT `subordinate` FROM `classif` WHERE `superiors`='root'");
			$fClass=array();
			while($cArr=$classResult->fetch_array(1)){
				$fClass[$cArr["subordinate"]]='<div class="platform-title">'.$cArr["subordinate"].'</div><div class="platform-name">';
			}
			$platform=array();
			if(isset($_POST["val"])){
				$result=$global->query("SELECT distinct `firstclass`,`platform` FROM `projects` WHERE `platform`<>'' AND `platform` LIKE '%{$_POST["val"]}%'");
			}else{
				$result=$global->query("SELECT distinct `firstclass`,`platform` FROM `projects` WHERE `platform`<>''");
			}
			
			while($classArr=$result->fetch_array(1)){
				$arr = preg_split( "/(\、|\,|\，|\/|\||\;|\；)/", $classArr["platform"]);
				//print_r($arr);
				foreach($arr as $pla){
					//echo "<span class='condition-item'>{$pla}</span>";
					if(!in_array($pla,$platform)){
						array_push($platform,$pla);
						//print_r($platform);
						//echo ROOT."\images\\".$pla.".png";
						if(file_exists(ROOT."/images/".md5($pla).".png")){
							$fClass[$classArr["firstclass"]].= "<span class='condition-item'><img src='images/".md5($pla).".png' />{$pla}</span>";
						}else{
							$fClass[$classArr["firstclass"]].="<span class='condition-item'>{$pla}</span>";
						}
						
					}
				}
			}
			foreach($fClass as $plas){
				echo "<div>".$plas."</div></div>";
			}
			break;
			case "pushed":
			echo "<span class='condition-item'>仅推荐</span>";
			echo "<span class='condition-item'>所有</span>";
			break;
		}
		break;
		case "multiple":
		$condition="";
		if(isset($_POST["title"])){
			$condition.="`title` LIKE '%{$_POST["title"]}%' AND";
		}
		if(isset($_POST["cond-firstclass"])){
			$condition.="`firstclass` = '{$_POST["cond-firstclass"]}' AND";
		}
		if(isset($_POST["cond-secondclass"])){
			$condition.="`secondclass` = '{$_POST["cond-secondclass"]}' AND";
		}
		if(isset($_POST["cond-threeclass"])){
			$condition.="`threeclass` = '{$_POST["cond-threeclass"]}' AND";
		}
		if(isset($_POST["cond-platform"])){
			$condition.="`platform` LIKE '%{$_POST["cond-platform"]}%' AND";
		}
		if(isset($_POST["sprice"])){
			$condition.="((`price1` >= '{$_POST["sprice"]}' AND `price1` <= '{$_POST["eprice"]}') OR (`price2` >= '{$_POST["sprice"]}' AND `price2` <= '{$_POST["eprice"]}') OR (`price3` >= '{$_POST["sprice"]}' AND `price3` <= '{$_POST["eprice"]}')) AND";
		}
		if(isset($_POST["cond-tags"])){
			$condition.="`tags` LIKE '%{$_POST["cond-tags"]}%' AND";
		}else{
			if(isset($_POST["cond-pushed"])){
				if($_POST["cond-pushed"]=="仅推荐"){
					$condition.="`pushed` = '1' AND";
				}else if($_POST["cond-pushed"]=="所有"){
					$condition.="`pushed` LIKE '%%' AND";
				}else{
					$condition.="`pushed` = '0' AND";
				}

			}
		}
		// print_r($_POST);
		
		
		$condition=rtrim($condition,"AND");
		//if(count($_POST)<3){
		//	$query="SELECT * FROM `projects` ORDER BY `date` DESC";
		//}else{
			$query="SELECT * FROM `projects` WHERE {$condition} ORDER BY `date` DESC";
		//}
		
		//echo $query;
		$everyPage=20;
		$countResult=$global->query($query);
		$count=$countResult->num_rows;
		$srecord=($_POST["row"]-1)*$everyPage;
		$result=$global->query($query." LIMIT {$srecord},{$everyPage}");
		while($projects=$result->fetch_array(1)){
		?>
		<ul class="post big-post">
			<div class="cover" cover-text="" cover-girl-text="">
				<a href="page.php?id=<?php echo $projects["id"];?>" hidefocus="true" target="_blank"><img alt="" style="display: block;" src="<?php if($projects["cover"]==""){ echo $global->getoption("weburl")."images/default.png";}else{ echo $global->getoption("weburl").$projects["cover"];}?>"><div class="overlay" style="display: none;"><span style="color: rgb(255, 0, 153);"></span></div></a>
				
			</div>
			<li><label>项目名称 / </label><a href="page.php?id=<?php echo $projects["id"];?>" title="<?php echo $projects["title"];?>" hidefocus="true" class="nickname" target="_blank"><?php echo $global->seizeStr($projects["title"],36);?></a></li>
			<li><label>平台/地点 / </label><span title="<?php echo $projects["platform"];?>"><?php echo $global->seizeStr($projects["platform"],26);?></span></li>
			<li><label>播出时间 / </label><span title="<?php echo $projects["datetime"];?>"><?php echo $global->seizeStr($projects["datetime"],26);?></span></li>
		</ul>
		<?php
		}
		
		$ep=5;
		//$pp=ceil((ceil($count/$everyPage))/5);
		$pd=ceil($_POST["row"]/$ep);
		$allPage=ceil($count/$everyPage);
		$sp=$pd*$ep-$ep+1;
		if($_POST["row"]==$allPage){
			if(($sp-$ep)>0){
				$sp=$allPage-$ep+1;
			}
		}else{
			if($_POST["row"]==$pd*$ep){
				if(($sp+floor($ep/2))<$allPage){
					$sp+=floor($ep/2);
				}
			}else if($_POST["row"]==$sp && $sp!=1){
			if(($sp-floor($ep/2))>0){
				$sp-=floor($ep/2);
			}
		}
		}
		 
		?>
		<div class="page-div"><span> 共 <?php echo $allPage; ?> 页 <?php echo $count; ?> 条数据 </span>
		<span>
			<a class='go-page' data-page='1'>首页</a>
			<?php for($p=$sp;$p<$sp+$ep;$p++){
			if($p<=ceil($count/$everyPage)){
				if($_POST["row"]==$p){
					echo "<a class='go-page pactiv' data-page='{$p}'>{$p}</a>";
				}else{
					echo "<a class='go-page' data-page='{$p}'>{$p}</a>";
				}
				
			}
		}?>
			<a class='go-page' data-page='<?php echo $allPage;?>'>尾页</a>
		</span>
		</div>
		<?php
		break;
		case "showclass":
		$result=$global->query("SELECT `subordinate` FROM `classif` WHERE `superiors`='{$_POST["classname"]}'");
		while($classArr=$result->fetch_array(1)){
			echo "<span class='class-item'>{$classArr["subordinate"]}</span>";
		}
		break;
	}
	
?>