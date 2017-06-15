pdata={};
pdata["type"]="search";
$(function (){
	showLIst(0)
	$("#title").bind("input propertychange",search)
	$("#platform").bind("input propertychange",search)
	$("#core").bind("input propertychange",search)
	$("#p-del").click(delP);
})
//获取列表啦
function showLIst(row){
	pdata["row"]=row;
	$.ajax({
		type:"POST",
		url:"control/showlist.php",
		data:pdata,
		dataType:"html",
		success:function(data){
			$("#datalist").html(data)
			$("#datalist table tr").bind({mouseenter:function(){$(this).find("a").css("color","#FFFFFF")},mouseleave:function(){$(this).find("a").css("color","#000000")}})
			$(".go-page").click(function(){showLIst($(this).data("page"))})
		}
	})
}
//触碰查询
function search(){
	var pInfo=$(".p-info")
	var data={}
	for(i=0;i<pInfo.length;i++){
		var infoVal=pInfo.eq(i).val();
		if(infoVal!=""){
			data[pInfo.eq(i).attr("id")]=infoVal;
		}
	}
	if(objLength(data)>0){
		pdata["data"]=data;
	}else{
		pdata["data"]=undefined;
	}
	showLIst(0);
}
//获取平台
function getPlatform(){

}
//删除IP
function delP(){
	pdata["type"]="del";
	var selCon=$(".p-select");
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
		url:"control/showlist.php",
		data:pdata,
		dataType:"html",
		success:function(data){
			pdata["type"]="search";
			search();
		}
	})
	}else{
		alert("没有选择项目")
	}
}
//

//获取对象属性数量
function objLength(o){
	var l=0;
	for(var i in o){
		l++;
	}
	return l;
}