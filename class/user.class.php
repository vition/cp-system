<?php
	class _user{
		protected $mydb;
		protected $username;
		
		function __construct($dbinfo){
			$this->mydb=new mysqli($dbinfo["dbhost"],$dbinfo["rootname"],$dbinfo["rootpsw"],$dbinfo["dbname"]);     //创建mysqli对象
			$this->mydb->query("set names utf8");
			
		}
		//登录
		function login($username,$password){
			//$query="SELECT `id` FROM `user` WHERE `username`='{$username}' AND `password` ='".sha1($password)."'";
			//$result=$this->mydb->query($query);
			if($this->checkPsw($username,$password)=="success"){
				$_SESSION["cplogin"]=1;
				$_SESSION["username"]=$username;
				$this->username=$username;
				$this->ulog($username,"登录");
				echo "success";
			}else{
				$this->ulog($username,"尝试登录失败");
				unset($_SESSION["cplogin"]);
				$_SESSION=array();
				echo "error";
			}
			// if($result->num_rows>0){
				// $_SESSION["login"]=1;
				// $_SESSION["username"]=$username;
				// $this->username=$username;
				// echo "success";
			// }else{
				// unset($_SESSION["login"]);
				// $_SESSION=array();
				// echo "error";
			// }
		}
		//新建用户
		function createUser($userInfo){
			$query="INSERT INTO `user`(`username`, `password`, `group`, `grouplevel`,`state`,`remark`) VALUES ('{$userInfo["username"]}','".sha1($userInfo["psw"])."','{$userInfo["group"]}','{$userInfo["grouplevel"]}','1','{$userInfo["remark"]}')";
			$result=$this->mydb->query($query);
			if($result>=1){
				return "success";
			}else{
				return "error";
			}
		}
		//获取用户信息
		function getuser($username){
			if(isset($_SESSION["cplogin"])){
				$result=$this->mydb->query("SELECT `group`,`grouplevel`,`wxid` FROM `user` WHERE `username`='{$username}'");
				$this->username=$username;
				$array=$result->fetch_array(1);
				return $array;
			}else{
				return "error";
			}
		}
		//验证用户密码
		function checkPsw($username,$psw){
			$query="SELECT `id` FROM `user` WHERE `username`='{$username}' AND `password` ='".sha1($psw)."'";
			//echo $query;
			$result=$this->mydb->query($query);
			if($result->num_rows>0){
				return "success";
			}else{
				return "error";
			}
		}
		//修改用户密码
		function changePsw($username,$newpsw){
			$result=$this->mydb->query("UPDATE `user` SET `password`='".sha1($newpsw)."' WHERE `username`='{$username}'");
			//echo "UPDATE `user` SET `password`='".sha1($newpsw)."' WHERE `username`='{$username}'";
			if($result>=1){
				return "success";
			}else{
				return "error";
			}
		}
		//判断用户是否存在
		function isUser($username){
			$query="SELECT `id` FROM `user` WHERE `username`='{$username}'";
			$result=$this->mydb->query($query);
			if($result->num_rows>=1){
				return "success";
			}else{
				return "error";
			}
		}
		//冻结/解冻用户
		function activUser($username,$activ=true){
			if($activ==false){
				$state=0;
			}else{
				$state=1;
			}
			$result=$this->mydb->query("UPDATE `user` SET `state`='{$state}' WHERE `username`='{$username}'");
			if($result>=1){
				return "success";
			}else{
				return "error";
			}
		}
		//获取所有用户列表
		function userList($username){
			$result=$this->mydb->query("SELECT `username` FROM `user` WHERE `username` LIKE '%{$username}%' LIMIT 0,5");
			if($result->num_rows>0){
				$userArr=array();
				while($array=$result->fetch_array(1)){
					array_push($userArr,$array["username"]);
				}
				return $userArr;
			}else{
				return "error";
			}
		}
		//根据id修改组别
		function changeGroup($username,$group,$grouplevel){
			$result=$this->mydb->query("UPDATE `user` SET `group`='{$group}',`grouplevel`={$grouplevel} WHERE `username`='{$username}'");
			if($result>=1){
				return "success";
			}else{
				return "error";
			}
		}
		//根据用户名修改备注
		function changeRemark($username,$remark){
			$result=$this->mydb->query("UPDATE `user` SET `remark`='{$remark}' WHERE `username`='{$username}'");
			if($result>0){
				return "success";
			}else{
				return "error";
			}
		}
		//获取用户微信id
		function getUserId($nameArr=""){
			if($nameArr==""){
				$ids="";
				$result=$this->mydb->query("SELECT `wxid` FROM `user`");
				while($array=$result->fetch_array(1)){
					if($array["wxid"]!=""){
						$ids.=$array["wxid"]."|";
					}
				}
			}else{
				$ids="";
				foreach($nameArr as $name){
					$result=$this->mydb->query("SELECT `wxid` FROM `user` WHERE `username`='{$name}'");
					$array=$result->fetch_array(1);
					$ids.=$array["wxid"]."|";
				}
			}
			return rtrim($ids,"|");
		}
		//用户操作日志
		function ulog($username,$con,$pdata=""){
			//print_r($pdata);
			if(isset($pdata["pdf"])){
				unset($pdata["pdf"]);
			}
			if(isset($pdata["cover"])){
				unset($pdata["cover"]);
			}
			$data="";
			if($pdata!=""){
				foreach($pdata as $key=>$val){
						if(is_array($val)){
							foreach($val as $key1=>$val1){
								$data.=$key1."=>".$val1.";";
							}
						}else{
							$data.=$key."=>".$val.";";
						}	
				}	
			}
			
			$data=rtrim($data,";");
			$result=$this->mydb->query("INSERT INTO `log`(`username`, `con`,`data`,`date`) VALUES ('{$username}','{$con}','{$data}','".date("Y-m-d H:i:s")."')");
		}
	}
?>