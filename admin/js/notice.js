pdata={};
pdata["type"]="search";
$(function (){
	showLIst(0)
	$("#notice-create").click(createNotice)
	$("#notice-updata").click(updataNotice)
	$("#n-del").click(delN);
})
//获取列表啦
function showLIst(row){
	pdata["row"]=row;
	$.ajax({
		type:"POST",
		url:"control/noticelist.php",
		data:pdata,
		dataType:"html",
		success:function(data){
			$("#notice-list-box").html(data)
			$(".v-table tr").bind({mouseenter:function(){$(this).find("a").css("color","#FFFFFF")},mouseleave:function(){$(this).find("a").css("color","#000000")}})
			$(".go-page").click(function(){showLIst($(this).data("page"))})
			$(".notice-edit").click(editNotice)
		}
	})
}
//新建公告
function createNotice(){
	var noticeInfo=$(".notice-info");
	var data={}
	//获取到数据
	for(i=0;i<noticeInfo.length;i++){
		var tempInfo=noticeInfo.eq(i).val();
		if(tempInfo!=""){
			data[noticeInfo.eq(i).data("key")]=tempInfo;
		}
	}
	
	if(objLength(data)>1){
		pdata["type"]="create";
		pdata["data"]=data;
		$.ajax({
			type:"POST",
			url:"control/noticelist.php",
			data:pdata,
			dataType:"html",
			success:function(data){
				alert(data)
				if(data==1){
					$("#notice-create").data("updata","")
					$("#title").val("");
					$("#content").val("");
				}
				
				pdata["type"]="search";
				$(".notice-info").val("");
				showLIst(0)
			}
		})
	}else{
		alert("请填写好信息")
	}
}
//更新
function updataNotice(){
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
		pdata["type"]="updata";
		pdata["id"]=upId;
		pdata["data"]=data;
		$.ajax({
			type:"POST",
			url:"control/noticelist.php",
			data:pdata,
			dataType:"html",
			success:function(data){
				if(data==1){
					$("#notice-create").data("updata","")
					$(".notice-info").val("");
				}
				
				pdata["type"]="search";
				showLIst(0)
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
			showLIst(0)
		}
	})
	}else{
		alert("没有选择公告")
	}
}
//编辑公告
function editNotice(){
	var noticeId=$(this).data("id");
	$("#notice-updata").data("updata",noticeId)
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