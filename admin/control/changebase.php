<?php 
	require_once('../../config.php');
	if($global->verify()=="success"){

	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
	$global->setOption($_POST);
	echo "修改完成！";
?>
