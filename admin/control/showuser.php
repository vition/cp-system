<?php 
	require_once('../../config.php');
	if($global->verify("")=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$gorup=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl"));
	}
	$userArr=$user->userList($_POST["user"]);
	if($userArr!="error"){
		foreach($userArr as $val){
			echo "<li class='user-itme'>{$val}</li>";
		}
		
	}
	// for($i=0;$i<count($tags_array);$i++){
		// $tags_name=explode("-",$tags_array[$i]);
		// if($_POST["user"]=="tags" || $_POST["user"]==""){
				// echo "<span class='tags-style'>{$tags_name[0]}</span>";
		// }else{

			// if(strpos($tags_name[0],$_POST["user"])===false){
				
			// }else{
				// echo "<span class='tags-style'>{$tags_name[0]}</span>";
			// }
			
		// }
	// }
	//$global->verify("weburl");
?>
