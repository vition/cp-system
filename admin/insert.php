<?php 
	require_once('../config.php');
	if($global->verify()=="success"){
		load_class("user");
		$user=new _user($serverinfo);
		$userinfo=$user->getuser($_SESSION["username"]);
	}else{
		$global->gotopage($global->getoption("weburl")."admin");
	}
	if(isset($_GET["id"])){
		$result=$global->query("SELECT * FROM `projects` WHERE `id`='{$_GET["id"]}'");
		$array=$result->fetch_array(1);
		$buttonName="修改项目";
		$protype="update";
		$projectid=$_GET["id"];
	}else{
		
		$result=$global->query("show columns from `projects`");
		
		$array=array();
		while($parray=$result->fetch_array(1)){
			$array[$parray["Field"]]="";
		}
		$buttonName="新增项目";
		$protype="insert";
		$projectid=0;
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title>娱乐营销CP推进系统管理后台</title>
	<script type="text/javascript" src="../js/jquery.js?<?php random();?>"></script>
	<script type="text/javascript" src="js/insert.js?<?php random();?>"></script>
	<link href="css/insert.css?<?php random();?>" rel="stylesheet" type="text/css">
	<link href="../css/base.css?<?php random();?>" rel="stylesheet" type="text/css">
	<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/lang/zh-CN.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#content',{resizeType:0});
        });
</script>
</head>
<body>
	<input id="projectype" type="hidden" value="<?php echo $protype;?>" />
	<input id="projecid" type="hidden" value="<?php echo $projectid;?>" />
	<div class="content">
		<ul class="data-input-ul">
		<!--<div id="divedit" contenteditable="true" onkeyup="edit(this,event)" style="height:50px;line-height:3em;width:100px;white-space:nowrap;text-algin:center;overflow:hidden;border:1px solid #DDDDDD;">可编辑div测试1</div>-->
			<li><span class="data-input-tit">一级分类</span><span><input type="text" id="firstclass" data-parentid="root" readonly="readonly" class="data-input select-input" value="<?php echo $array["firstclass"]; ?>" /></span></li>
			<li><span class="data-input-tit">二级分类</span><span><input type="text" id="secondclass" data-parentid="firstclass" readonly="readonly" class="data-input select-input" value="<?php echo $array["secondclass"]; ?>" /></span></li>
			<li><span class="data-input-tit">三级分类</span><span><input type="text" id="threeclass" data-parentid="secondclass" readonly="readonly" class="data-input select-input" value="<?php echo $array["threeclass"]; ?>" /></span></li>
			<li><span class="data-input-tit">IP名称</span><span><input type="text" id="title" class="data-input" value="<?php echo $array["title"]; ?>" /></span></li>
			<li><span class="data-input-tit">平台/地点</span><span><input type="text"id="platform" class="data-input" value="<?php echo $array["platform"]; ?>" /></span></li>
			<li><span class="data-input-tit">时间</span><span><input type="text" id="datetime" class="data-input" value="<?php echo $array["datetime"]; ?>" /></span></li>
			<li><span class="data-input-tit">核心</span><span><input type="text" id="core" class="data-input" value="<?php echo $array["core"]; ?>" /></span></li>
			<li><span class="data-input-tit">合作形式1</span><span><input type="text" id="mode1" class="input-30 data-input" value="<?php echo $array["mode1"]; ?>" /></span><span class="title-08">刊例价1</span><span><input type="text" id="price1" class="input-30 data-input" value="<?php echo $array["price1"]; ?>" /></span></li>
			<li><span class="data-input-tit">合作形式2</span><span><input type="text" id="mode2" class="input-30 data-input" value="<?php echo $array["mode2"]; ?>" /></span><span class="title-08">刊例价2</span><span><input type="text" id="price2" class="input-30 data-input" value="<?php echo $array["price2"]; ?>" /></span></li>
			<li><span class="data-input-tit">合作形式3</span><span><input type="text" id="mode3" class="input-30 data-input" value="<?php echo $array["mode3"]; ?>" /></span><span class="title-08">刊例价3</span><span><input type="text" id="price3" class="input-30 data-input" value="<?php echo $array["price3"]; ?>" /></span></li>
			<li><span class="data-input-tit">推荐客户</span><span><input type="text" id="channel" class="data-input" value="<?php echo $array["channel"]; ?>" /></span></li>
			<li><span class="data-input-tit">意向客户营业负责</span><span><input type="text" id="director" class="data-input" readonly="readonly" value="<?php echo $array["director"]; ?>" /></span><span class="user-ico"></span></li>
			<li><span class="data-input-tit">IP日截</span><span><input type="text" id="deadline" class="data-input" value="<?php echo $array["deadline"]; ?>" /></span></li>
			<li><span class="data-input-tit">CP联系人</span><span><input type="text" id="contact" class="data-input" value="<?php echo $array["contact"]; ?>" /></span></li>
			<li><span class="data-input-tit">CP联系方式</span><span><input type="text" id="telephone" class="data-input" value="<?php echo $array["telephone"]; ?>" /></span></li>
			<li><span class="data-input-tit">标签</span><span><input type="text" id="tags"  class="data-input" value="<?php echo $array["tags"]; ?>" /></span><span class="tags-ico"></span></li>
			<li><span class="data-input-tit">封面</span><span><input type="text" id="cover"  class="data-input" value="<?php echo $array["cover"]; ?>" /></span></li>
			<li><span class="data-input-tit">PDF文件</span><span><input type="text" id="pdfname"  class="data-input" value="<?php echo $array["pdfname"]; ?>" /></span></li>
			<li><span class="data-input-tit">是否推送</span><?php if($array["pushed"]==1){echo '<span id="push-home" class="but-select">求推送</span>';}else{ echo '<span id="push-home" class="but-no-select">不推送</span>';} ?><input id="pushed" type="hidden" class="data-input" value="<?php echo $array["pushed"]; ?>"/></li>
		</ul>
		<div id="progressNumber"></div>
		<div><textarea id="content" name="content" class="data-input" style="width:700px;height:300px;resize:none;">
<?php echo $global->de_quotes($array["content"]); ?>
</textarea></div>
	<div class="button-div"><span id="edit-base" class="v-button button-green"><?php echo $buttonName;?></span><span id="batch-button" data-box="batch-box" class="v-button button-blue">批量上传</span></div>
	<div id="classlist" ><ul></ul></div>
	
	<div id="coverbox"><div class="loadframe"><input type="file" id="coverphoto"  accept="image/*" /><span class="close-ico" name="coverbox" ></span></div></div>
	
	<div id="pdfbox"><div class="loadframe"><input type="file" id="uploadpdf"  accept=".pdf" /><span class="close-ico" name="pdfbox" ></span></div></div>
	<div id="user-box">
		<span class="v-search-group"><span class="v-search-title" id="clear-user">搜索</span><input id="title" class="p-info" autocomplete="off" type="text"></span>
		<div id="user-list"><ul></ul></div>
	</div>
	
		<div id="batch-box">
			<div class="loadframe">
				<input type="file" id="batch-file"  accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" /><span class="close-ico" name="batch-box" ></span>
				<div style="margin-top: 13%;">
					<p class="msg-button font-09" id="p-templet">模板</p>
				</div>
			</div>
		</div>
	</div>
	<div id="popup">
		<div class="search-tags"><span><input id="search-input" class="search-tags" type="text"></span><span class="search-tags search-ico"></span><span class="close-ico" name="popup" ></span></div>
		<div id="popup-tages"></div>
	</div>
	<script>
		function edit(self,e){
	if(e.which==13){
		$(self).html($(self).html().replace("<br>",""));
	}
}
	</script>
	<div id="wait-box"></div>
</body>
</html>
