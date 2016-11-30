<?php
	class _message{
		protected $mydb;
		function __construct($dbinfo){
			$this->mydb=new mysqli($dbinfo["dbhost"],$dbinfo["rootname"],$dbinfo["rootpsw"],$dbinfo["dbname"]);     //创建mysqli对象
			$this->mydb->query("set names utf8");
		}
		//发送消息
		function sendMes($idArr){
			$date=date("Y-m-d H:i:s");
			//echo "INSERT INTO `message`(`type`, `tid`, `from`, `to`, `content`, `date`, `state`) VALUES ('commet','{$idArr["tid"]}','{$idArr["from"]}','{$idArr["to"]}','{$idArr["content"]}','{$date}','0')";
			$result=$this->mydb->query("INSERT INTO `message`(`type`, `tid`, `from`, `to`, `content`, `date`, `state`) VALUES ('{$idArr["type"]}','{$idArr["tid"]}','{$idArr["from"]}','{$idArr["to"]}','{$idArr["content"]}','{$date}','0')");
		}
		//获取未读数量
		function unread($user){
			$result=$this->mydb->query("SELECT `id` FROM `message` WHERE `to`='{$user}' AND `state`='0'");
			return $result->num_rows;
		}
		//获指定id的消息
		function getMes($id){
			$result=$this->mydb->query("SELECT * FROM `message` WHERE `id`='{$id}'");
			$array=$result->fetch_array(1);
			return $array;
		}
		//修改消息状态
		function setState($id,$read=1){
			$result=$this->mydb->query("UPDATE `message` SET `state`='{$read}' WHERE `id`='{$id}'");
		}

	}
	
?>