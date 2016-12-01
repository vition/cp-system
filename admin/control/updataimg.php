<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	$return="";
	foreach($_POST as $key=>$val){
		//$index=explode("-",$key);
		preg_match("/data:image/",$val["imgsrc"],$array);
		if(!empty($array)){
			$imgsrc=$global->blob2Img($val["imgsrc"]);
			$return.=($key+1).":".$imgsrc.",";
		}else{
			//$imgsrc="http";
			$imgsrc=$val["imgsrc"];
		}
		$index=$key+1;
		$title=$val["title"];
		$href=$val["href"];
		$query="UPDATE `option` SET `value`='{$title}',`value2`='{$imgsrc}',`value3`='{$href}' WHERE `item`='banner-{$index}'";
		$global->query($query);
		//echo $query;
		//$return.=$index[1].":".$global->blob2Img($val).",";
	}
	$user->ulog($_SESSION["username"],"更新了广告图片内容");
	echo "修改成功";
	//echo rtrim($return,",");
?>
