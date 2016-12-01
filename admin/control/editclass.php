<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	
	$query="SELECT `subordinate` FROM `classif` WHERE `id`='{$_POST["cid"]}'";
	$result=$global->query($query);
	$array=$result->fetch_array(1);
	$oldSub=$array["subordinate"];
	$oldClass=$global->id2Class($_POST["cid"]);
	if(isset($_POST["csuper"])){
		$query="UPDATE `classif` SET `superiors`='{$_POST["csuper"]}',`subordinate`='{$_POST["cname"]}' WHERE `id`='{$_POST["cid"]}'";
	}else{
		$query="UPDATE `classif` SET `subordinate`='{$_POST["cname"]}' WHERE `id`='{$_POST["cid"]}'";
	}
	$global->query($query);
	//echo $query;
	$query="UPDATE `classif` SET `superiors`='{$_POST["cname"]}' WHERE `superiors`='{$oldSub}'"; 

	$global->query($query);
	if($_POST["thisclass"]=="firstclass"){
		$classArr=array($_POST["thisclass"]=>$_POST["cname"]);
		$oldArr=array($_POST["thisclass"]=>$oldClass["subordinate"]);
	}else{
		$classArr=array($_POST["thisclass"]=>$_POST["cname"],$_POST["prevclass"]=>$_POST["csuper"]);
		$oldArr=array($_POST["thisclass"]=>$oldClass["subordinate"],$_POST["prevclass"]=>$oldClass["superiors"]);
	}
	$global->scouredClass($oldArr,$classArr);
	$user->ulog($_SESSION["username"],"修改了分类",$_POST);
?>
