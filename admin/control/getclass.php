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
		case "list":
		$class=$global->getClass($_POST["superi"]);
		if($class=="error"){
				return;
			}
		if($_POST["classif"]=="firstclass"){
			echo "<ul class='ul-sub2' data-class='secondclass'>";
		}elseif($_POST["classif"]=="secondclass"){
			echo "<ul class='ul-sub2' data-class='threeclass'>";
		}else{
			echo "<ul class='ul-sub2'>";
		}
		for($i=0;$i<count($class);$i++){
			$classInfo=explode("-",$class[$i]);
			echo "<li class='' data-classid='{$classInfo[0]}'><span class='jico plus-ico ul-click{$_POST["randomn"]}'></span><span class='edit-class{$_POST["randomn"]}'>{$classInfo[1]}</span>";
			if($_POST["classif"]!="secondclass"){
				echo "<a class='add-class'></a></li>";
			}else{
				"</li>";
			}
			
			echo "<li class='ul-sub'></li>";
		}
		echo "</ul>";
		break;
		case "super":
		$super=$global->getSuper($_POST["classname"]);
		if($super=="root"){
			echo $super;
		}else{
			echo "<select>";
			$class=$global->getClass($global->getSuper($super));
			for($i=0;$i<count($class);$i++){
				$classInfo=explode("-",$class[$i]);
				if($super==$classInfo[1]){
					echo "<option selected='selected'>{$classInfo[1]}</option>";
				}else{
					echo "<option>{$classInfo[1]}</option>";
				}
				
			}
			echo "</select>";
		}
		break;
		case "input":
		$class=$global->getClass($_POST["sup"],false);
		if($class=="error"){
			
		}else{
			foreach($class as $val){
				echo "<li data-belong='{$_POST["id"]}'>{$val}</li>";
			}
		}
		
		break;
		case "add":
		//print_r($_POST);
		$query="INSERT INTO `classif`(`superiors`, `subordinate`) VALUES ('{$_POST["supclass"]}','{$_POST["newclass"]}')";
		$global->query($query);
		break;
		case "del":
		$query="DELETE FROM `classif` WHERE `id`='{$_POST["id"]}'";
		$global->query($query);
		break;
		
	}
	
	//$global->verify("weburl");
?>
