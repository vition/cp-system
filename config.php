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
	$global->url();
	//定义成员组别
	
	// $groupArr=array("宙斯"=>4,"大神"=>3,"朕"=>2,"平民"=>1);
	$groupArr=$global->getLevel();
	$mesType=array("comment"=>"评论","feedback"=>"反馈","system"=>"系统");
?>
