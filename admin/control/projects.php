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
	//print_r($_POST);
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
				if($key=="wx"){
					echo $key;
				}
				if($key=="ptype" OR $key=="id" OR $key=="pdf" OR $key=="wx"){
					
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
				if($key=="ptype" OR $key=="id" OR $key=="pdf" OR $key=="wx"){
					
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
		
		//$weixin->send($data);//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx650b23fa694c8ff7&redirect_uri=http://twoway.cc/qyweixin/attend/punchInOut.php&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
		if($control!=""){
			$user->ulog($_SESSION["username"],$control,$_POST);
			if($_POST["wx"]=="true"){
				$wxMsf="并且推送到微信企业号";
				$data=array("touser"=>"{$wxids}","msgtype"=> "news","agentid"=> 0,"news"=>array("articles"=>array(array("title"=>"WTC娱乐营销{$control}：{$_POST["title"]}","description"=>"{$_POST["core"]}【点击查看】","url"=>"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx650b23fa694c8ff7&redirect_uri=".$global->getoption("weburl")."page.php?id={$id}&response_type=code&scope=SCOPE&state=STATE#wechat_redirect","picurl"=>$global->getoption("weburl").$picurl))),"safe"=>"0");
				$weixin->send($data);
			}else{
				$wxMsf="但是没有推送到微信企业号";
			}
			echo "操作成功了，".$wxMsf;
		}else{
			echo "抱歉出错了！";
		}
		
	}
	
?>
<input value="请选择字段" id="key">
<ul class='key-level'>
	<li>simple</li>
	<li>complex</li>
</ul>
点击 key 后弹出 key-level
点击 complex 后弹出一下
<ul class='key-level'>
	<li>cc</li>
	<li>test</li>
</ul>
同时$(".key-level").eq(0).css("display","none");其实eq(0)应该是根据当前的节点来判断是第几个
点击test的时候
$(this).parent().css("display","none");隐藏当前父节点，或者直接remove
$(".key-level").eq(0).css("display","block");显示 class key-level的第一个







