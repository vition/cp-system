<?php
	class _global{
		protected $mydb;
		public $insert_id;
		function __construct($dbinfo){
			$this->mydb=new mysqli($dbinfo["dbhost"],$dbinfo["rootname"],$dbinfo["rootpsw"],$dbinfo["dbname"]);     //创建mysqli对象
			$this->mydb->query("set names utf8");
		}
		//验证
		function verify($url=""){
			
			if(isset($_SESSION["cplogin"])){
				return "success";
			}else{
				return "error";
			}
		}
		//获取potion
		function getoption($item,$value=""){
			$query="SELECT `value`,`value2`,`value3` FROM `option` WHERE `item`='{$item}'";
			$result=$this->mydb->query($query);
			if($result->num_rows>0){
				$array=$result->fetch_array(1);
				switch($value){
					case "":
					return $array["value"];
					break;
					case "array":
					return $array;
					break;
					default:
					return $array["value2"];
					break;
				}
			}else{
				return "error";
			}
		}
		//设置potion
		function setOption($array){
			foreach($array as $key=>$val){
				$this->mydb->query("UPDATE `option` SET `value`='{$val}' WHERE `item`='{$key}'");
			}
			
		}
		//跳转页面
		function gotopage($url,$msg=""){
			if($msg!=""){
				echo "<script>alert('{$msg}')</script>";
			}
			header("Location: {$url}");
		}
		//获取分类
		function getClass($className,$id=true){
			$query="SELECT `id`,`subordinate` FROM `classif` WHERE `superiors`='{$className}'";
			$result=$this->mydb->query($query);
			if($result->num_rows>0){
				$class=array();
				while($array=$result->fetch_array(2)){
					if($id==true){
						array_push($class,$array[0]."-".$array[1]);
					}else{
						array_push($class,$array[1]);
					}
					
				}
				return $class;
			}else{
				return "error"; 
			}
		}
		//获取上级分类
		function getSuper($sub){
			$query="SELECT `superiors` FROM `classif` WHERE `subordinate`='{$sub}'";
			$result=$this->mydb->query($query);
			if($result->num_rows>0){
				$array=$result->fetch_array(1);
				return $array["superiors"];
			}else{
				return "error"; 
			}
		}
		//根据id获取分类
		function id2Class($id){
			$query="SELECT `superiors`,`subordinate` FROM `classif` WHERE `id`='{$id}'";
			$result=$this->mydb->query($query);
			return $result->fetch_array(1);
		}
		//根据修改分类来修改所有项目的分类
		function scouredClass($soure,$new){
			$set="";
			$condition="";
			foreach($soure as $key=>$val){
				$condition.=" `{$key}`='{$val}' AND";
			}
			foreach($new as $key=>$val){
				$set.=" `{$key}`='{$val}' ,";
			}
			$condition=rtrim($condition,"AND");
			$set=rtrim($set,",");
			$result=$this->mydb->query("UPDATE `projects` SET {$set} WHERE {$condition}");
		}

		//二进制转图片blob2img
		function blob2Img($blob,$dir="../../images/upload/"){
			//获取到一个data:image/jpeg;base64,数据
			$head_data=explode(",",$blob);
			$headSB=explode(";",$head_data[0]);
			$headS=explode("/",$headSB[0]);
			$suffix=$headS[1];
			$base64=base64_decode($head_data[1]);
			$imgname=round(time()+microtime(),5).".".$suffix;
			$resource = fopen($dir.$imgname , 'w+');  
			fwrite($resource, $base64);  
			fclose($resource); 
			return "images/upload/".$imgname;
		}
		//二进制转文件
		function blob2file($blob,$fileName,$dir="../../upload/excel/"){
			//获取到一个data:image/jpeg;base64,数据
			$head_data=explode(",",$blob);
			$headSB=explode(";",$head_data[0]);
			$base64=base64_decode($head_data[1]);
			$temp=explode(".",$fileName);
			$imgname=md5($temp[0]).".".$temp[count($temp)-1];
			
			$resource = fopen($dir.$imgname , 'w+');  
			fwrite($resource, $base64);  
			fclose($resource); 
			$info=array("name"=>$imgname,"src"=>$dir.$imgname,"zhName"=>$temp[0]);
			return $info;
		}
		//mysql 操作
		function query($query){
			$result=$this->mydb->query($query);
			$this->insert_id=$this->mydb->insert_id;
			return $result;
		}
		//加密引号
		function en_quotes($str){
			$regex=array('/\'/','/\"/');
			$sub=array("<{v1}>","<{v2}>");
			$nstr=preg_replace($regex,$sub,$str);
			return $nstr;
		}//解密引号
		function de_quotes($str){
			$regex=array("(<{v1}>)","(<{v2}>)");
			$sub=array("'",'"');
			$nstr=preg_replace($regex,$sub,$str);
			return $nstr;
		}
		//获取指定字符
		function seizeStr($str,$int){
			if(mb_strlen($str)<=$int){
				return mb_strcut($str,0,$int,'utf-8');
			}else{
				return mb_strcut($str,0,$int,'utf-8')."…";
			}
			
			//return mb_strlen($str);
		}
		//取当前页面文件名
		function thisPhp(){
			$php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
			return $php_self;
		}
		//更新标签
		function upTags($tags){
			$tagArray=explode(",",$tags);
			$query="SELECT `value` FROM `option` WHERE `item`='tags' ";
			$result=$this->mydb->query($query);
			$array=$result->fetch_array(1);
			$narray=preg_split( "/(\-|\,)/", $array["value"] );
			
			for($j=0;$j<count($tagArray);$j++){
				for($i=0;$i<count($narray);$i=$i+2){
					if($tagArray[$j]==$narray[$i]){
						$tagArray[$j]="";
						$narray[$i+1]++;
					}
				}
			}
			
			foreach($this->array_empty($tagArray) as $tag ){
				array_push($narray,$tag);
				array_push($narray,1);
			}
			$newTags=$this->array2tags($narray);
			$query="UPDATE `option` SET `value`='{$newTags}' WHERE `item`='tags'";
			$this->mydb->query($query);
		}
		//删除数组空元素
		function array_empty($array){
			arsort($array);
			$array2=array_unique($array);
			array_pop($array2);
			return($array2);
		}
		//数组转标签
		function array2tags($array){
			$tags="";
			for($j=0;$j<count($array);$j=$j+2){
				$tags.=$array[$j]."-".$array[$j+1].",";
			}
			return rtrim($tags,",");
		}
		//获取当前项目是否有自己的反馈
		function isFeedback($username,$pid){
			$query="SELECT `id` FROM `feedback` WHERE `pid`='{$pid}' AND `username`='{$username}'";
			$result=$this->mydb->query($query);
			if($result->num_rows>0){
				return "success";
			}else{
				return "error";
			}
		}
		//获取评论内容
		function getComment($rid,$type="comment"){
			if($type=="comment"){
				$query="SELECT `username`,`comment` FROM `comment` WHERE `id`='{$rid}'";
				$result=$this->mydb->query($query);
				if($result->num_rows>0){
					$array=$result->fetch_array(1);
					return "@".$array["username"]." : ".$array["comment"];
				}else{
					return "error";
				}
			}else{
				$query="SELECT `{$type}` FROM `comment` WHERE `id`='{$rid}'";
				$result=$this->mydb->query($query);
				if($result->num_rows>0){
					$array=$result->fetch_array(1);
					return $array["{$type}"];
				}else{
					return "error";
				}
			}
			
		}
		function getImgLen($url){
			
		}
	}
?>