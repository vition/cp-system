<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	$tags=$global->getoption("tags");
	$tags_array=explode(",",$tags);
	for($i=0;$i<count($tags_array);$i++){
		$tags_name=explode("-",$tags_array[$i]);
		if($_POST["tags"]=="tags" || $_POST["tags"]==""){
				echo "<span class='tags-style'>{$tags_name[0]}</span>";
		}else{

			if(strpos($tags_name[0],$_POST["tags"])===false){
				
			}else{
				echo "<span class='tags-style'>{$tags_name[0]}</span>";
			}
			
		}
	}
	//$global->verify("weburl");
?>
