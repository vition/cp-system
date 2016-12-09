<?php 
	$a=header("Content-type: application/pdf");
	var_dump($a);
	readfile("upload/pdf/".md5($_GET["filename"]).".pdf");	
	
?>