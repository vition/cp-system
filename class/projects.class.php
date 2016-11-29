<?php
	class _projects{
		protected $mydb;
		function __construct($dbinfo){
			$this->mydb=new mysqli($dbinfo["dbhost"],$dbinfo["rootname"],$dbinfo["rootpsw"],$dbinfo["dbname"]);     //创建mysqli对象
			$this->mydb->query("set names utf8");
		}
		//删除项目
		function delProject($idArr){
			// print_r($idArr);
			$idStr="";
			foreach($idArr as $id){
				$idStr.="'{$id}',";
			}
			$idStr=rtrim($idStr,",");
			$this->mydb->query("DELETE FROM `projects` WHERE `id` in ({$idStr})");
		}
		//根据id获取项目一个关键字
		function getProjectKey($id,$key="title"){
			$result=$this->mydb->query("SELECT `{$key}` FROM `projects` WHERE `id`='{$id}'");
			$array=$result->fetch_array(1);
			return $array[$key];
		}
		//获取项目相关人员
		function getRelevantUser($id){
			$result=$this->mydb->query("SELECT `director`,`publisher` FROM `projects` WHERE `id`='{$id}'");
			$array=$result->fetch_array(1);
			$userArray=array();
			if($array["director"]==""){
				array_push($userArray,$array["publisher"]);
			}else{
				$temp=explode(",",$array["director"]);
				foreach($temp as $val){
					array_push($userArray,$val);
				}
			}
			return $userArray;
		}
	}
	
?>