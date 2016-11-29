<?php
//excel 类
	class excel{
		protected $phpexcelpath;//定义include phpexcel 的路径
		
		function __construct($path=""){//构造方法，创建对象的时候输入phpexcel路径
		  $this->phpexcelpath=$path;
		  require_once($this->phpexcelpath);
	  }
		function readexcel($filePath){//读入excel方法
			    $PHPExcel = PHPExcel_IOFactory::load($filePath);  
				$currentSheet = $PHPExcel->getSheet(0);  /**取得一共有多少列*/  
				$allColumn = $currentSheet->getHighestColumn();     /**取得一共有多少行*/  
				$allColumn = $currentSheet->getHighestColumn();     /**取得一共有多少行*/  
				$allRow = $currentSheet->getHighestRow();  
				Global $Row;
				$Row=$allRow ;
				$all = array();  
				for( $currentRow = 1 ; $currentRow <= $allRow ; $currentRow++){    
					$flag = 0;  
					$col = array();  
					for($currentColumn='A'; ord($currentColumn) <= ord($allColumn) ; $currentColumn++){        
						$address = $currentColumn.$currentRow;                
						$string = $currentSheet->getCell($address)->getValue();             
						$col[$flag] = $string; 	
						$flag++;  
					}  
					$all[] = $col;  
				}  
				return $all;  
		}
		function fun_readexcel($filePath,$allColumn){//读入excel方法
			    $PHPExcel = PHPExcel_IOFactory::load($filePath);  
				$currentSheet = $PHPExcel->getSheet(0);  /**取得一共有多少列*/  
				//$allColumn = $currentSheet->getHighestColumn();     /**取得一共有多少行*/  
				$allRow = $currentSheet->getHighestRow();  
				Global $Row;
				$Row=$allRow ;
				$all = array();  
				for( $currentRow = 1 ; $currentRow <= $allRow ; $currentRow++){    
					$flag = 0;  
					$col = array();  
					for($currentColumn='A'; ord($currentColumn) <= ord($allColumn) ; $currentColumn++){        
						$address = $currentColumn.$currentRow;                
						$string = $currentSheet->getCell($address)->getValue();             
						$col[$flag] = $string; 	
						$flag++;  
					}  
					$all[] = $col;  
				}  
				return $all;  
		}
		//readexcel 结束
		function exportexcel($data, $path=false, $name=''){//导出excel方法
			$objPHPExcel = new PHPExcel();  
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			if(!is_array($data[0])) $data = array($data);  
			$workSheet =  $objPHPExcel->getActiveSheet();  
			$allcol=count($data[0]);
			$allcol=$allcol+65;
			//print_r($allcol);
			for($i=65;$i<=$allcol;$i++){
					$s=chr($i);
					$workSheet->getColumnDimension($s)->setWidth(15);
				}
			foreach($data as $k=>$v){ 	
				$row_id = $k+1;  
				if(is_array($v))  
					foreach($v as $kk=>$vv){  
						$col_id = $kk;   
						//$workSheet->getColumnDimension(chr(64))->setWidth(15);
						if(is_array($vv)){  
						print_r($vv);
							$cell = $workSheet->setCellValueByColumnAndRow($col_id, $row_id,  $vv[0])->getCellByColumnAndRow($col_id, $row_id);
						}else $workSheet->setCellValueByColumnAndRow($col_id, $row_id, $vv);  
					}  
				else  
					$workSheet->setCellValueByColumnAndRow(1, $row_id, $vv);  
			}  
			
			if(!$path){  
				if(!$name) $name = time().'.xlsx';  
				ob_end_clean();
				header('Content-Type: application/vnd.ms-excel');  
				header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');  
				header('Cache-Control: max-age=0'); 
				
				$objWriter = PHPExcel_IOFactory:: createWriter($objPHPExcel, 'Excel2007');  
				$objWriter->save( 'php://output');  
			}else $objWriter->save($path);  
		  
		}
		}
		//exportexcel结束
	
  
  
  
  
  