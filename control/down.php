<?php 
	require_once('../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	switch($_REQUEST["type"]){
		case "pdf":
		//print_r($_POST);
		
		$filename = "../upload/pdf/".md5($_REQUEST["filename"]).".pdf";
		$out_filename = $_REQUEST["filename"].".pdf";
		if(!file_exists($filename)){//
			echo 'Not Found'.$filename;
			exit;
		}else{
			header('Accept-Ranges: bytes');
			header('Accept-Length: ' . filesize($filename));
			header('Content-Transfer-Encoding: binary');
			header('Content-type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . $out_filename);
			header('Content-Type: application/octet-stream; name=' . $out_filename);
		   if(is_file($filename) && is_readable($filename)){
			   $file = fopen($filename, "r");
			   echo fread($file, filesize($filename));
			   fclose($file);
		   }
		　　exit;
		}
		break;
	}
?>
