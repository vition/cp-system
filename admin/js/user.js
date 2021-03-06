$(function (){
	$(".user-group").click(showGroup);
	$("#user-new-but").click(function(){$("#user-new-box").css("display","block")})
	$(".close-but").click(function(){$("#"+$(this).data("box")).css("display","none")})
	$("#username").bind("input propertychange",function(){search(0);})
	$("#user-group-box").bind({mouseenter:function(){$(this).css("display","block")},mouseleave:function(){$(this).css("display","none")}})
	$("#user-create").click(createUser);
	$("#del-user").click(delUser)
	$("#freeze-user").click(delUser)
	$(".psw-span").click(editBox)
	$("#psw-box").bind({mouseenter:function(){$(this).css("display","block")},mouseleave:function(){$(this).css("display","none")}})
	$("#reset-psw").click(resetPsw)
	search(0);
})
//显示组别
function showGroup(){
	if($(this).text()==$("#superadmin").val()){
		return;
	}
	$("#user-group-box").data("name",$(this).prev().text())
	//alert($(this).prev().text());
	var pdata={};
	pdata["type"]="showgroup";
	if($(this).data("id")=="changeg"){
		var h=35
		$("#changegid").val(this.id);
		$("#user-group-box").data("input","changeg")
	}else{
		var h=25
		$("#user-group-box").data("input",this.id)
	}
	
	if(this.id=="user-search-group"){pdata["mode"]=this.id}
	$("#user-group-box").css("display","block")
	//alert($(this).offset().top)
	$("#user-group-box").css("width",$(this).css("width"))
	$("#user-group-box").css("top",$(this).offset().top+h+"px")
	$("#user-group-box").css("left",$(this).offset().left+"px")
	$.ajax({
		url:"control/user.php",
		type:"POST",
		data:pdata,
		dataType:"html",
		success:function(data){
			$("#user-group-box ul").html(data);
			$(".group-item").click(setGroup)
		}
	})
}
//设置组别
function setGroup(){
	var type=$(this).parent().parent().data("input")
	if(type=="changeg"){
		var temp=$("#changegid").val().split("-");
		var uid=temp[1];
		var name=$("#user-group-box").data("name");
		$.ajax({
			url:"control/user.php",
			type:"POST",
			data:{type:"changegroup",name:name,group:$(this).text()},
			dataType:"html",
			success:function(data){
				alert(data)
				search(0);
				//$("#user-group-box ul").html(data);
				//$(".group-item").click(setGroup)
			}
		})
	}else{
		$("#"+type).val($(this).text())
		$(this).parent().parent().css("display","none")
		if(type=="user-search-group"){
			search(0);
		}
	}
	
	
}
//查询用户列表
function search(row){

	var pdata={}
	pdata["type"]="search";
	pdata["row"]=row;
	var data={}
	var username=$("#username").val();
	var group=$("#user-search-group").val();
	if(username!=""){
		data["username"]=username
	}
	if(group!=""){
		data["group"]=group
	}
	pdata["data"]=data;

	$.ajax({
		url:"control/user.php",
		type:"POST",
		data:pdata,
		dataType:"html",
		success:function(data){
			$("#user-list-box").html(data)
			$(".psw-span").click(editBox)
			$(".change-group").click(showGroup)
			$(".go-page").click(function(){search($(this).data("page"))})
			$(".remark-change").click(editRemark)
		}
	})
}
//新建用户
function createUser(){
	var pdata={}
	pdata["type"]="create";
	var data={}
	var info=$(".user-new-info")
	for(i=0;i<info.length;i++){
		var infoVal=info.eq(i).val();
		var infoid=info.eq(i).attr("id");
		if(infoVal!=""){
			var id=infoid.split("-")
			data[id[2]]=infoVal
		}
	}
	// data["username"]=$("#user-new-username").val();
	// data["psw"] =$("#user-new-psw").val();
	// data["group"] =$("#user-new-group").val();
//	alert(objLength(data))
	if(objLength(data)<3){
		alert("请完善资料")
	}else{
		pdata["data"]=data;
		$.ajax({
			url:"control/user.php",
			type:"POST",
			data:pdata,
			dataType:"html",
			success:function(data){
				alert(data)
				$(".close-but").click();
				search(0);
				//$("#user-list-box ul").html(data)
			}
		})
	}
	
}
//获取对象属性数量
function objLength(o){
	var l=0;
	for(var i in o){
		l++;
	}
	return l;
}
//删除选中项成员
function delUser(){
	var idtype=$(this).attr("id")
	var pdata={}
	if(idtype=="del-user"){
		pdata["type"]="del";
		var msg="删除";
	}else{
		pdata["type"]="freeze";
		var msg="冻结";
	}
	
	var data={}
	var selCon=$(".user-control");
	for(i=0;i<selCon.length;i++){
		if(selCon.eq(i).is(":checked")){
			var group=selCon.eq(i).parent().next().next().text()
			if(group==$("#superadmin").val()){
				alert("您选择的用户中包含"+$("#superadmin").val()+"，无法执行"+msg);
				return;
			}else{
				data[i]=selCon.eq(i).parent().next().text();
			}
			
		}
	}
	if(objLength(data)>0){
		pdata["data"]=data;
		$.ajax({
			url:"control/user.php",
			type:"POST",
			data:pdata,
			dataType:"html",
			success:function(data){
				alert(data)
				search(0);
			}
		})
	}else{
		alert("没有选中任何数据！")
	}
}
//弹出修改密码窗
function editBox(){
	if($(this).parent().prev().text()!=$("#superadmin").val()){
		$("#reset-user").val($(this).parent().prev().prev().text())
		$("#psw-box").css("display","block")
	}else{
		alert("您不能修改"+$("#superadmin").val()+"的密码。")
	}
}
//弹出组别
function changeGroup(){
	if($(this).text()!=$("#superadmin").val()){
		showGroup
	}
}
//执行修改密码
function resetPsw(){
	var pdata={}
	pdata["type"]="resetpsw";
	var data={}
	var resetInfo=$(".reset-info");
	for(i=0;i<resetInfo.length;i++){
		var info=resetInfo.eq(i).val()
		if(info!=""){
			data[i]=info
		}
	}
	if(objLength(data)>=2){
		pdata["data"]=data;
		$.ajax({
			url:"control/user.php",
			type:"POST",
			data:pdata,
			dataType:"html",
			success:function(data){
				alert(data)
			}
		})
	}else{
		alert("请完善信息！")
	}
	
}
//编辑备注
function editRemark(){
	$(this).find(".remark-title").attr("contenteditable","true");
//	alert($(this).find(".save-remark").val())
	if($(this).find(".save-remark").val()==undefined){
		$(this).append("<span class='save-remark'></span>")
		$(".save-remark").click(changeRemark)
	}
	
	//$(".remark-change").mouseleave(function(){changeRemark(this)})
}
//修改备注
function changeRemark(){
	var myself=this;
	//alert($(this).parent().prev().prev().prev().text())
	$.ajax({
		url:"control/user.php",
		type:"POST",
		data:{type:"changeremark",username:$(this).parent().prev().prev().prev().prev().text(),remark:$(this).prev().text()},
		dataType:"html",
		success:function(data){
			alert(data)
			$(myself).prev().attr("contenteditable","false");
			$(myself).remove();
		}
	})
}