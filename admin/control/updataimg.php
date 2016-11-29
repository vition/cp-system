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
		preg_match("/http/",$val["imgsrc"],$array);
		if(empty($array)){
			$imgsrc=$global->blob2Img($val["imgsrc"]);
			$return.=($key+1).":".$imgsrc.",";
		}else{
			$imgsrc="http";
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
	echo rtrim($return,",");
	
	
	// for($i=1;$i<=count($_POST);$i++){
		// $global->blob2Img($_POST["imgs-{$i}"]);
	// }
	
	// $temp=explode(",",$_POST["img"]);
	// $temp2=explode(";",$temp[0]);
	// $temp3=explode("/",$temp2[0]);
	// $img=base64_decode($temp[1]);
	// $imgname=time().".".$temp3[1];
	// $resource = fopen("../../images/upload/".$imgname , 'w+');  
	// fwrite($resource, $img);  
	// fclose($resource); 
?>
