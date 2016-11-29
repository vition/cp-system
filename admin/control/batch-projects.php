<?php 
	require_once('../../config.php');
	require_once('../../class/excel.class.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	$excel=new excel('../../class/excel/Classes/PHPExcel/IOFactory.php');
	//$excel->exportexcel($data, $path=false, $name='')
	$result=$global->query("show columns from `projects`");
	$array=array();
	while($parray=$result->fetch_array(1)){
		//echo $parray["Field"];
		if($parray["Field"]!="id"){
			array_push($array,$parray["Field"]);
		}
		
	}
	$excel->exportexcel($array,false,"projectTemplet");
?>
