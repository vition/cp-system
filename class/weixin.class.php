<?php
	header("Content-type: text/html; charset=utf-8");
	//微信类
	class weixin{
		protected $Mydb;
		protected $CorpID="wx650b23fa694c8ff7";
		protected $Secret="w_oV6aNTMaNUrOjwah0zupDxnWeYmtDR3QiUcD3Uqf584CpwYPB-U79QuhLLD_eJ";
		protected $AccessToken;
		protected $User;
		protected $Code;
		
		function __construct($dbinfo){
			$this->Mydb=new mysqli($dbinfo["dbhost"],$dbinfo["rootname"],$dbinfo["rootpsw"],$dbinfo["dbname"]); 
			$this->AccessToken=$this->getToken();
			//echo $this->AccessToken;
		}
		//获取AccessToken
		function getToken(){
			$data = json_decode($this->get_php_file(ROOT."/weixin/config/access_token.php"));
			if ($data->expire_time < time()) {
				$AccessTokenJ=file_get_contents("https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$this->CorpID}&corpsecret={$this->Secret}");
				$res=json_decode($AccessTokenJ);
				$accessToken=$res->access_token;
				if ($accessToken) {
					$data->expire_time = time() + 7000;
					$data->access_token = $accessToken;
					$this->set_php_file(ROOT."/weixin/config/access_token.php", json_encode($data));
				}
			}else {
				$accessToken = $data->access_token;
			}
			return $accessToken;
		}
		
		//获取企业号里的ID
		function getUserId(){
			$this->Code=$_GET["code"];
			$user=file_get_contents("https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$this->AccessToken}&code={$this->Code}");
			$codeinfo = json_decode($user); 
			return $codeinfo->UserId;
		}
		
		//查找ID号在wtc系统里是否存在
		function getUsername($userid){
			$result=$this->Mydb->query("SELECT `username` FROM `user` WHERE `wxid`='{$userid}'");
			if($result->num_rows>0){
				$info=$result->fetch_array(1);
				return $info["username"];
			}else{
				return false;
			}
		}
		//检查用户是否存在
		function checkUsername($username){
			$result=$this->Mydb->query("SELECT `id` FROM `user` WHERE `username`='{$username}'");
			if($result->num_rows>0){
				return true;
			}else{
				return false;
			}
		}
		//绑定用户名
		function binding($username,$wxid){
			if($this->checkUsername($username)){
				$result=$this->Mydb->query("UPDATE `user` SET `wxid`='{$wxid}' WHERE `username`='{$username}'");
				if($result>0){
					return "success";
				}else{
					return "error";
				}
			}else{
				return "error";
			}
			
		}
		//取消绑定
		function unbing($username){
			$result=$this->Mydb->query("UPDATE `user` SET `wxid`='' WHERE `username`='{$username}'");
			if($result>0){
				return "success";
			}else{
				return "error";
			}
		}
		
		
		
		
		
		//获取用户信息
		function getUser3($userid){
			$user=file_get_contents("https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token={$this->AccessToken}&userid={$userid}");
			$this->User=json_decode($user);
			if($this->User->errmsg=="ok"){
				return true;
			}else{
				return false;
			}
		}
		//获取用户名
		function getname($code){
			$query="SELECT `username` FROM `personnel` WHERE `code`='{$code}'";
			$result=$this->Mydb->query($query);
			$array=$result->fetch_array(1);
			return $array["username"];
		}
		
		//推送消息到用户
		function send($data){
			//$data=array("touser"=>"vition","msgtype"=> "text","agentid"=> 0,"text"=>array ("content"=>""),"safe"=>"0");
			$url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token={$this->AccessToken}";
			$return=$this->send_post($url,$data);
			$return=json_decode($return);
			if($return->errmsg=="ok"){
				return true;
			}else{
				return false;
			}
		}
		function send_post($url,$post_data) {
			$postdata = json_encode($post_data,JSON_UNESCAPED_UNICODE);
			//$postdata = $this->encode_json($post_data);
			$options = array(
			'http' => array(
			'method' => 'POST',//or GET
			'header' => 'Content-type:application/x-www-form-urlencoded',
			'content' => $postdata,
			'timeout' => 15 * 60 // 超时时间（单位:s）
			)
			);
			$context = stream_context_create($options);
			return file_get_contents($url, false, $context);
		}
		function encode_json($str){  
			$code = json_encode($str);  
			//return preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $code); 
		    preg_replace_callback("/{([^\}\{\n]*)}/", function($r) { return $this->select($r[1]); }, $source);			
		}  
		//qu 
		private function get_php_file($filename) {
			return trim(substr(file_get_contents($filename), 15));
		}
		private function set_php_file($filename, $content) {
			$fp = fopen($filename, "w");
			fwrite($fp, "<?php exit();?>" . $content);
			fclose($fp);
		}
	}
	?>