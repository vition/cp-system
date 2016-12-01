<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	//$global
	switch($_POST["ptype"]){
		case "insert":
		$dataKey="`date`,";
		$dataVal="'".date("Y-m-d H:i:s",time())."',";
		foreach($_POST as $key=>$val){
			if($key=="ptype" || $key=="id" || $key=="pdf"){
				
			}elseif($key=="content"){
				$dataKey.="`{$key}`,";
				$dataVal.="'".$global->en_quotes($val)."',";
			}else{
				$dataKey.="`{$key}`,";
				if($key=="cover"){
					 if($val!=""){
						preg_match("/http/",$val,$array);
						if(empty($array)){
							 $dataVal.="'".$global->blob2Img($val)."',";
						}else{
							 $dataVal.="'{$val}',";
						}
						
					 }else{
						 $dataVal.="'',";
					 }
				}elseif($key=="pdfname"){
					if($val!=""){
						$fileInfo=$global->blob2file($_POST["pdf"],$val,"../../upload/pdf/");
						if($fileInfo["zhName"]!=""){
							$dataVal.="'{$fileInfo["zhName"]}',";
						}
					}else{
						$dataVal.="'',";
					}
				}else{
					$dataVal.="'{$val}',";
					if($key=="tags"){
						if($val!=""){
							$global->upTags($val);
						}
					}
				}
				
			}
		}
		$query="INSERT INTO `projects`(".rtrim($dataKey,",").",`publisher`) VALUES (".rtrim($dataVal,",").",'{$_SESSION["username"]}')";
		//echo $query;
		$control="新增项目";
		break;
		case "update":
		$dataKey="`date`,";
		$dataVal="'".date("Y-m-d H:i:s",time())."',";
		
		$datakv="`date`='".date("Y-m-d H:i:s",time())."',";
		foreach($_POST as $key=>$val){
			if($key=="ptype" || $key=="id" || $key=="pdf"){
				
			}elseif($key=="content"){
				$datakv.="`{$key}`='".$global->en_quotes($val)."',";
			}else{
				if($key=="cover"){
					if($val!=""){
						preg_match("/data/",$val,$array);
						if(!empty($array)){
							$datakv.="`{$key}`='".$global->blob2Img($val)."',";
						}else{
							$datakv.="`{$key}`='{$val}',";
						}
					}
				}elseif($key=="pdfname"){
					if($val!="" && isset($_POST["pdf"])){
						$fileInfo=$global->blob2file($_POST["pdf"],$val,"../../upload/pdf/");
						if($fileInfo["zhName"]!=""){
							$datakv.="`{$key}`='{$fileInfo["zhName"]}',";
						}
					}
				}else{
					$datakv.="`{$key}`='{$val}',";
					if($key=="tags"){
						if($val!=""){
							$global->upTags($val);
						}
					}
				}
				
			}
		}
		$query="UPDATE `projects` SET ".rtrim($datakv,",")." WHERE `id`='{$_POST["id"]}'";
		$control="更新项目";
		//$query="INSERT INTO `projects`(".rtrim($dataKey,",").") VALUES (".rtrim($dataVal,",").")";
		break;
	}
	//print_r($_POST);
	$global->query($query);
	$user->ulog($_SESSION["username"],$control,$_POST);
	echo "操作成功了，真棒！";
	//echo $query;
?>
