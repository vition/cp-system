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
?>
				<ul class="post big-post">
					<div class="cover" cover-text="" cover-girl-text="">
						<a href="page.php?id=<?php echo $projects["id"];?>" hidefocus="true" target="_blank"><img src2="<?php echo $global->getoption("weburl").$projects["cover"];?>" alt="" style="display: block;" src="<?php echo $global->getoption("weburl").$projects["cover"];?>"><div class="overlay" style="display: none;"><span style="color: rgb(255, 0, 153);"></span></div></a>
					</div>
					<li><label>项目名称 / </label><a href="page.php?id=<?php echo $projects["id"];?>" title="赵泽峰" hidefocus="true" class="nickname" target="_blank"><?php echo $projects["title"];?></a></li>
					<li><label>平台 / </label><span><?php echo $projects["platform"];?></span></li>
					<li><label>更新日期 / </label><span><?php echo $projects["date"];?></span></li>
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
			if(isset($_POST["val"])){
				$result=$global->query("SELECT distinct `platform` FROM `projects` WHERE `platform` LIKE '%{$_POST["val"]}%'");
			}else{
				$result=$global->query("SELECT distinct `platform` FROM `projects`");
			}
			
			while($classArr=$result->fetch_array(1)){
				echo "<span class='condition-item'>{$classArr["platform"]}</span>";
			}
			break;
			case "price":
			break;
		}
		break;
		case "multiple":
		print_r($_POST);
		break;
	}
	
?>