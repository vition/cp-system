<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$userInfo=$user->getuser($_SESSION["username"]);
		load_class("weixin");
		$weixin=new weixin($serverinfo);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	//$global
	$isresult=$global->query("SELECT `id` FROM `projects` WHERE `title`='{$_POST["title"]}'");
	if($isresult->num_rows>0 && $_POST["ptype"]=="insert"){
		//这里是判断项目名称是否存在
		echo "{$_POST["title"]} 该IP已存在，不能再新建";
	}else{
		switch($_POST["ptype"]){
			case "insert":
			$picurl="";
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
								 $picurl=$global->blob2Img($val);
								 $dataVal.="'".$picurl."',";
							}else{
								 $dataVal.="'{$val}',";
								 $picurl=$val;
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
								$picurl=$global->blob2Img($val);
								$datakv.="`{$key}`='".$picurl."',";
							}else{
								$datakv.="`{$key}`='{$val}',";
								$picurl=$val;
							}
						}else{
							$picurl="";
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
			$id=$_POST["id"];
			$control="更新项目";
			//$query="INSERT INTO `projects`(".rtrim($dataKey,",").") VALUES (".rtrim($dataVal,",").")";
			break;
		}
		$global->query($query);
		
		$wxids=$user->getUserId();
		if($control=="新增项目"){
			$insertId=$global->insert_id;
			if($insertId>0){
				$id=$insertId;
			}
		}
		//$data=array("touser"=>"{$wxids}","msgtype"=> "news","agentid"=> 0,"news"=>array("articles"=>array(array("title"=>"WTC娱乐营销{$control}：{$_POST["title"]}","description"=>"{$_POST["core"]}【请使用电脑登录".$global->getoption("weburl")."进行查看】","picurl"=>$global->getoption("weburl").$picurl))),"safe"=>"0");
		$data=array("touser"=>"{$wxids}","msgtype"=> "news","agentid"=> 0,"news"=>array("articles"=>array(array("title"=>"WTC娱乐营销{$control}：{$_POST["title"]}","description"=>"{$_POST["core"]}【点击查看】","url"=>"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx650b23fa694c8ff7&redirect_uri=".$global->getoption("weburl")."page.php?id={$id}&response_type=code&scope=SCOPE&state=STATE#wechat_redirect","picurl"=>$global->getoption("weburl").$picurl))),"safe"=>"0");
		//$weixin->send($data);//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx650b23fa694c8ff7&redirect_uri=http://twoway.cc/qyweixin/attend/punchInOut.php&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
		if($control!=""){
			$user->ulog($_SESSION["username"],$control,$_POST);
			$weixin->send($data);
			echo "操作成功了，真棒！";
		}else{
			echo "抱歉出错了！";
		}
		
	}
	
?>
