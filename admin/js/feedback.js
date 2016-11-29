pdata={};
pdata["type"]="search";
$(function (){
	showLIst(0)
	$("#f-del").click(delFeedback);
})
//获取列表啦
function showLIst(row){
	pdata["row"]=row;
	$.ajax({
		type:"POST",
		url:"control/feedback.php",
		data:pdata,
		dataType:"html",
		success:function(data){
			$("#feedback-list-box").html(data)
			$(".v-table tr").bind({mouseenter:function(){$(this).find("a").css("color","#FFFFFF")},mouseleave:function(){$(this).find("a").css("color","#000000")}})
			$(".go-page").click(function(){showLIst($(this).data("page"))})
			//$(".feedback-edit").click(editNotice)
		}
	})
}
//删除评论
function delFeedback(){
	// alert("come on");
	pdata["type"]="del";
	var selCon=$(".f-select");
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
		url:"control/feedback.php",
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
//获取对象属性数量
function objLength(o){
	var l=0;
	for(var i in o){
		l++;
	}
	return l;
}