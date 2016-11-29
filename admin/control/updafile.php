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
	
	switch($_POST["type"]){
		case "excel":
		$excelFile=$global->blob2file($_POST["file"],$_POST["fileName"]);
		$excel=new excel('../../class/excel/Classes/PHPExcel/IOFactory.php');
		$arr=$excel->readexcel($excelFile["src"]);
		for($i=1;$i<=$Row-1;$i++){
			//print_r($arr[$i]);
			$query="SELECT `id` FROM `projects` WHERE `title`='{$arr[$i][3]}'";
			$result=$global->query($query);
			if($result->num_rows>=1){
				$id=$result->fetch_array(2);
				$query="UPDATE `projects` SET ";
				for($n=0;$n<count($arr[$i]);$n++){
					if($arr[$i][$n]!=""){
						$query.="`".$arr[0][$n]."`='".$arr[$i][$n]."',";
					}else{
						if($arr[0][$n]==""){
							
						}
					}
				}
				$query=rtrim($query,",");
				$query.="WHERE `id`='{$id[0]}'";
				echo $query;
			}else{
				$query="INSERT INTO `projects`(";
				$values=" ) VALUES ( ";
				for($n=0;$n<count($arr[$i]);$n++){
					if($arr[0][$n]!=""){
						$query.="`".$arr[0][$n]."`,";
						$values.="'".$arr[$i][$n]."',";
					}
					
				}
				$query=rtrim($query,",");
				$values=rtrim($values,",");
				echo $query.=$values.")";
			}
			$global->query($query);
			// foreach($arr[$i] as $value){
				// if($value!=""){
					// echo $value."\n";
					// if()
				// }
			// }
		}
		break;
		case "pdf":
		break;
	}
	
	//print_r($_POST);
	
	
	// for($i=1;$i<=count($_POST);$i++){
		// $global->blob2Img($_POST["imgs-{$i}"]);
	// }
	
	// $temp=explode(",",$_POST["img"]);
	// $temp2=explode(";",$temp[0]);
	// $temp3=explode("/",$temp2[0]);
	// $img=base64_decode($temp[1]);
	// $imgname=time().".".$temp3[1];
	// $resource = fopen("../../images/upload/".$imgname , 'w+');  
	// fwrite($resource, $img);  
	// fclose($resource); 
?>
