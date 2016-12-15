$(function (){
	$(".tags-ico").click(function(){$("#popup").css("display","block");showTags("tags")});
	$("#search-input").bind("input propertychange",function(){searchTags()})
	$("#search-user").bind("input propertychange",function(){showUser(this.value)})
	
	$(".close-ico").click(close_box);
	$("#edit-base").click(insert)
	$(".select-input").click(getClass)
	$("#cover").click(showCover)
	$("#pdfname").click(showPdf)
	$("#coverphoto").change(loadImg)
	$("#batch-button").click(showBatch);
	$("#batch-file").change(batchFile)
	$("#tags").change(changeTags)
	$("#p-templet").click(downTemplet)
	$("#push-home").click(pushHome)
	$("#push-wx").click(pushWx)
	indata={};
	formData = new FormData();
	$(".user-ico").click(function(){$("#user-box").css("display","block");$("#search-user").val("");showUser("")})
	$("#clear-user").bind({mouseenter:function(){$(this).text("清空")},mouseleave:function(){$(this).text("搜索")}})
	$("#clear-user").click(function(){$("#director").val("")})
	$("#classlist").bind({mouseenter:function(){$(this).css("display","block")},mouseleave:function(){$(this).css("display","none")}})
	$("#user-box").bind({mouseenter:function(){$(this).css("display","block")},mouseleave:function(){$(this).css("display","none")}})
})
//显示标签层
function showTags(tagname){
	$.ajax({
		type:"post",
		url:"control/showtags.php",
		data:{tags:tagname},
		dataType:"html",
		success:function(data){
			$("#popup-tages").html(data);
			$(".tags-style").click(write);
		}
	})
}

//写入标签
function write(){
	var tagsInput=$("#tags").val();
	if(tagsInput==""){
		$("#tags").val($(this).text());
	}else{
		$("#tags").val(tagsInput+","+$(this).text());
	}
}
//查询标签
function searchTags(){
	var tagname=$("#search-input").val();
	showTags(tagname);
}
//close
function close_box(){
	$("#"+$(this).attr("name")).css("display","none");
}
//插入项目
function insert(){
	editor.sync(); 
	//alert(editor.html())
	
	dataInput=$(".data-input");
	for(i=0;i<dataInput.length;i++){
		indata[dataInput.eq(i).attr("id")]=dataInput.eq(i).val()
	}
	indata["ptype"]=$("#projectype").val();
	if($("#projecid").val()!=0){
		indata["id"]=$("#projecid").val();
	}
	indata["wx"]=$("#push-wx").data("pushwx");
	$("#wait-box").html('<span class="wait-image">项目建档中，请等待……</span>');
	$("#wait-box").css("display","block");
	　$.ajax({
　　　　type: "POST",
　　　　url: "control/projects.php",
　　　　data: indata,　　//这里上传的数据使用了formData 对象
		dataType:"html",
		success:function (data){
			$("#wait-box").css("display","none");
			alert(data)
		}
　　});
	
}
function onprogress(evt){
　　var loaded = evt.loaded;     //已经上传大小情况 
	var tot = evt.total;      //附件总大小 
	var per = Math.floor(100*loaded/tot);  //已经上传的百分比 
　　$("#son").html( per +"%" );
	$("#son").css("width" , per +"%");
}
function getClass(){
	$("#classlist").css("display","block")
	thisid=this.id
	parentName=$(this).data("parentid");
	thisoff=$(this).offset()
	if(parentName=="root"){
		var supVal="root";
	}else{
		var supVal=$("#"+parentName).val();
	}
	if(supVal!=""){
		$.ajax({
			type:"post",
			url:"control/getclass.php",
			data:{type:"input",sup:supVal,id:thisid},
			dataType:"html",
			success:function(data){
				//alert(data)
				$("#classlist ul").html(data);
				$("#classlist").css("top",thisoff.top+30+"px")
				$("#classlist").css("left",thisoff.left+"px")
				$("#classlist ul li").click(setClass)
			}
		})
	}
	
}
function setClass(){
	beloingid=$(this).data("belong");
	$("#"+beloingid).val($(this).text())
	if(beloingid!="threeclass"){
		$("#"+beloingid).parent().parent().next().children().next().children().val("")
	}
	if(beloingid=="firstclass"){
		$("#"+beloingid).parent().parent().next().next().children().next().children().val("")
	}
	
	$("#classlist").css("display","none")
	$("#classlist ul").html("");
}
function showCover(){
	$("#coverbox").css("display","block");
}
function showPdf(){
	$("#pdfbox").css("display","block");
	$("#uploadpdf").change(loadPdf)
}
//加载图片
function loadImg(){
	var file = this.files[0]; //选择上传的文件
	var r = new FileReader();
	r.readAsDataURL(file); //Base64
	$(r).load(function(){
		//alert(this.result)
		$("#cover").val(this.result);
		$("#coverbox").css("display","none");
		//$('#preview').html('<img style="margin-top:50px;max-width:600px;" id="imgs" src="'+ this.result +'" alt="" />');
	});
}
function showBatch(){
	$("#"+$(this).data("box")).css("display","block")
}
//上传文件
function batchFile(){
	var file = this.files[0]; //选择上传的文件
	var fileName=file.name;
	var r = new FileReader();
	r.readAsDataURL(file); //Base64
	$(r).load(function(){
		//$("#cover").val(this.result);
		efile=this.result
		$.ajax({
			type:"post",
			url:"control/updafile.php",
			data:{fileName:fileName,type:"excel",file:efile},
			dataType:"html",
			success:function(data){
				alert(data)
			}
		})
		//$("#coverbox").css("display","none");
	});
}
//下载模板
function downTemplet(){
	window.location.href="control/batch-projects.php";
}
//推送到首页
function pushHome(){
	if($(this).attr("class")=="but-no-select"){
		$(this).removeClass("but-no-select");
		$(this).addClass("but-select");
		$(this).text("求推送");
		$("#pushed").val(1);
	}else{
		$(this).removeClass("but-select");
		$(this).addClass("but-no-select");
		$(this).text("不推送");
		$("#pushed").val(0);
	}
}
//推送到微信
function pushWx(){
	if($(this).attr("class")=="but-no-select"){
		$(this).removeClass("but-no-select");
		$(this).addClass("but-select");
		$(this).text("求推送");
		$(this).data("pushwx",true)
		$("#pushed").val(1);
	}else{
		$(this).removeClass("but-select");
		$(this).addClass("but-no-select");
		$(this).text("不推送");
		$(this).data("pushwx",false)
	}
}
//加载pdf
function loadPdf(){
	var file = this.files[0]; //选择上传的文件
	var fileName=file.name;
	if(file.size>=9999999){
		$("#pdfname").val("")
		alert("PDF文件不能大于10M")
		
	}else{
		var r = new FileReader();
		r.readAsDataURL(file); //Base64
		$(r).load(function(){
			indata["pdf"]=this.result
			$("#pdfname").val(fileName);
			$("#pdfbox").css("display","none");
		});
	}
	
	
}
//对象转文本
function obj2str(o){ 
	var r=[]; 
	if(typeof o=="string"){ 
		return "\""+o.replace(/([\'\"\\])/g,"\\$1").replace(/(\n)/g,"\\n").replace(/(\r)/g,"\\r").replace(/(\t)/g,"\\t")+"\""; 
	} 
	if(typeof o=="object"){ 
		if(!o.sort){ 
			for(var i in o){ 
				r.push(i+":"+obj2string(o[i])); 
			} 
			if(!!document.all&&!/^\n?function\s*toString\(\)\s*\{\n?\s*\[native code\]\n?\s*\}\n?\s*$/.test(o.toString)){ 
				r.push("toString:"+o.toString.toString()); 
			} 
			r="{"+r.join()+"}"; 
		}else{ 
			for(var i=0;i<o.length;i++){ 
				r.push(obj2string(o[i])) 
			} 
			r="["+r.join()+"]"; 
		} 
		return r; 
	} 
	return o.toString(); 
}
//更新标签的符号
function changeTags(){
	var tags=this.value
	var ntagws=tags.replace("，",",")
	this.value=ntagws
}
//显示用户层
function showUser(username){
	$.ajax({
		type:"post",
		url:"control/showuser.php",
		data:{user:username},
		dataType:"html",
		success:function(data){
			$("#user-list").html(data);
			$(".user-itme").click(inputUser);
			//$(".tags-style").click(write);
		}
	})
}
//填充到用户框
function inputUser(){
	var user=$("#director").val();
	var thisUser=$(this).text()
	if(user!=""){
		var n=user.split(",").length;
		if(n<2){
			if(user!=thisUser){
				$("#director").val(user+","+thisUser);
			}
		}else{
			//var nUser=user.replace(thisUser,"")
			//var nUser=nUser.replace(",","")
			var nuser=user.split(",");
			for(i=0;i<nuser.length;i++){
				if(nuser[i]==thisUser){
					var nUserTemp=user.replace(thisUser,"")
					var nUserStr=nUserTemp.replace(",","")
					$("#director").val(nUserStr);
				}
			}
			
			
			//alert("只允许添加两个负责人")
		}
		
	}else{
		$("#director").val($(this).text());
	}
	$("#user-box").css("display","none");
}