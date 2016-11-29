<?php 
	header("Content-type: application/pdf");
	readfile("upload/pdf/".md5($_GET["filename"]).".pdf");	
	
?>