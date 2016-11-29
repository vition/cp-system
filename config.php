<?php 
	session_start();
	header("Content-type:text/html;charset=utf-8");
	//定义ROOT
	define('ROOT' , pathinfo(__FILE__, PATHINFO_DIRNAME));
	//定义时区
	date_default_timezone_set('Asia/Shanghai');
	//定义加载类文件
	function load_class($class_name){
		$path = ROOT . '/class/' . $class_name . '.class.php';
		require_once( $path ); 
	}
	//定义随机数
	function random(){
		echo lcg_value();
	}
	//定义数据库
	$serverinfo=array("dbhost"=>"localhost","rootname"=>"root","rootpsw"=>"root","dbname"=>"cpsystem");
	load_class("global");
	$global=new _global($serverinfo);
	//定义成员组别
	$groupArr=array("超级管理员"=>4,"管理员"=>3,"营业员"=>2,"平民"=>1);
?>
