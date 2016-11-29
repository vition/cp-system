pdata={};
pdata["type"]="search";
$(function (){
	showLIst()
	$("#notice-create").click(createNotice)
	$("#n-del").click(delN);
})
//获取列表啦
function showLIst(){
	$.ajax({
		type:"POST",
		url:"control/noticelist.php",
		data:pdata,
		dataType:"html",
		success:function(data){
			$("#notice-list-box").html(data)
			$(".v-table tr").bind({mouseenter:function(){$(this).find("a").css("color","#FFFFFF")},mouseleave:function(){$(this).find("a").css("color","#000000")}})
			$(".notice-edit").click(editNotice)
		}
	})
}
//新建公告
function createNotice(){
	var noticeInfo=$(".notice-info");
	var data={}
	for(i=0;i<noticeInfo.length;i++){
		var tempInfo=noticeInfo.eq(i).val();
		if(tempInfo!=""){
			data[noticeInfo.eq(i).data("key")]=tempInfo;
		}
	}
	if(objLength(data)>1){
		var upId=$(this).data("updata");
		if(upId!=""){
			pdata["type"]="updata";
			pdata["id"]=upId;
		}else{
			pdata["type"]="create";
		}
		
		pdata["data"]=data;
		$.ajax({
			type:"POST",
			url:"control/noticelist.php",
			data:pdata,
			dataType:"html",
			success:function(data){
				if(data==1){
					$("#notice-create").data("updata","")
					$("#title").val("");
					$("#content").val("");
				}
				
				pdata["type"]="search";
				showLIst()
			}
		})
	}else{
		alert("请填写好信息")
	}
	
	
}
function delN(){
	pdata["type"]="del";
	var selCon=$(".n-select");
	var data={};
	for(i=0;i<selCon.length;i++){
		if(selCon.eq(i).is(":checked")){
			data[i]=selCon.eq(i).data("id");
		}
	}
	if(objLength(data)>0){
		pdata["data"]=data;
		$.ajax({
		type:"POST",
		url:"control/noticelist.php",
		data:pdata,
		dataType:"html",
		success:function(data){
			pdata["type"]="search";
			showLIst()
		}
	})
	}else{
		alert("没有选择公告")
	}
}
//编辑公告
function editNotice(){
	var noticeId=$(this).data("id");
	$("#notice-create").data("updata",noticeId)
	$("#title").val($(this).attr("title"));
	$("#content").val($(this).parent().next().attr("title"));
	

}
//获取对象属性数量
function objLength(o){
	var l=0;
	for(var i in o){
		l++;
	}
	return l;
}