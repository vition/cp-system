$(function(){
	
	showList(0);
	$("#search-but").click(function(){showList(0)})
	//autoSearch()
	$(".search-ico").mouseenter(showCondition)
	$(".condition-box").mouseenter(function(){$(this).css("display","block")});
	$(".condition-box").mouseleave(function(){$(this).css("display","none");$(".screen-item").children(".search-ico").css("background-position-y","7px");});
	$(".condition-search-div input").bind("input propertychange",function(){searchCondition()})
	$("#sprice").bind("input propertychange",setPrice)
	$("#eprice").bind("input propertychange",setPrice)
	$("#allprice").click(function(){$(this).data("value",1);showList(0);$("#sprice").val(0);$("#eprice").val(0)})
	$(".class-title").click(showclass)
	b=function(){alert("1")}
	//function(){alert("11")}
	alert(b())
	//if(b()){alert("2")}
})

function showNews(){
	$.ajax({
		url:"control/getnews.php",
		type:"post",
		dataType:"json",
		data:{id:$(this).data("newsid")},
		success:function(data){
			$(".newsp-title").text(data.title);
			$(".newsp-content").text(data.content);
		}
	})
	$("#newsp-box").css("display","block");
}
function closeBox(){
	var theId=$(this).data("box");
	$("#"+theId).css("display","none");
}
//查询标题
function search(title){
	$.ajax({
		url:"control/getprojects.php",
		type:"post",
		dataType:"html",
		data:{type:"title",title:title},
		success:function(data){
			$(".w970").html(data)
		}
	})
}
//跳转页面到查询
function goSearch(){
	var thisPage=$(".nav-ative").attr("href");
	if(thisPage!="screen.php"){
		var searchs=encodeURI($("#title-screen-box input").val());
		window.location.href=$("#home-url").attr("href")+"screen.php?search="+searchs;
	}
	
	var title=$("#title-screen-box input").val();
	search(title)
}
function autoSearch(){
	var searchs=$("#title-screen-box input").val();
	if(searchs!=""){
		//alert(search)
		search(searchs)
	}
}
//查询功能
function showCondition(){
	var condition=$(this).data("value");
	if(condition=="class"){
		$(".class-sel-box").css("display","block")
		$(".condition-search-div").css("display","none")
		$(".condition-search-price").css("display","none")
		$(".condition-list").css("display","none")
	}else if(condition=="price"){
		$(".condition-search-div").css("display","none")
		$(".condition-search-price").css("display","block")
		$(".condition-list").css("display","block")
		$(".class-sel-box").css("display","none")
	}else if(condition=="pushed"){
		$(".condition-search-div").css("display","none")
		$(".condition-search-price").css("display","none")
		$(".condition-list").css("display","block")
		$(".class-sel-box").css("display","none")
	}else{
		$(".condition-search-div").css("display","block")
		$(".condition-search-price").css("display","none")
		$(".condition-list").css("display","block")
		$(".class-sel-box").css("display","none")
	}
	$(".con-sea-input").val("");
	$(".condition-search-div").data("value",condition);
	var screenItem=$(".screen-item");
	//for(i=0;i<screenItem.length;i++){
		screenItem.removeClass("show-condition")
		screenItem.children(".search-ico").css("background-position-y","7px");
	//}
	$(this).parent().addClass("show-condition");
	$(this).css("background-position-y","-28px");
	var thisoff=$(this).offset()
	var boxHeight=thisoff.top
	var oval=$("#cond-"+condition).val();
	//alert(oval)
	if(oval!=""){
		$('.condition-list').html("<span class='condition-item item-active'>"+oval+"</span>");
		$(".condition-item").click(selectItem)
	}else{
		$.ajax({
			url:"control/getprojects.php",
			type:"post",
			dataType:"html",
			data:{type:"condition",cond:condition},
			success:function(data){
				$('.condition-list').html(data);
				$(".condition-item").click(selectItem)
			}
		})
	}
	
	
	$(".condition-box").css({"display":"block","top":boxHeight+19+"px"});
}
//输入框搜索关键字
function searchCondition(){
	var condition=$(".condition-search-div").data("value")
	var values=$(".con-sea-input").val();
	$.ajax({
		url:"control/getprojects.php",
		type:"post",
		dataType:"html",
		data:{type:"condition",cond:condition,val:values},
		success:function(data){
			$('.condition-list').html(data);
			$(".condition-item").click(selectItem)
		}
	})
}
//点击关键字
function selectItem(){
	var condition=$(".condition-search-div").data("value")
	var oval=$("#cond-"+condition).val();
	var nval=$(this).text();
	if(oval==nval){
		$("#cond-"+condition).val("");
		searchCondition();
		showList(0);
	}else{
		$("#cond-"+condition).val($(this).text());
		$('.condition-list').html("<span class='condition-item item-active'>"+nval+"</span>");
		$(".condition-item").click(selectItem)
		var condClass=$("#cond-class").val();
		var condPlatform=$("#cond-platform").val();
		var condPrice=$("#cond-price").val();
		showList(0);

	}
}
//查看项目列表
function showList(row){
	//alert("a")
	var searchVal={}
	searchVal["row"]=row
	var multiple=$(".multiple");
	var title=$("#title-screen-box input").val();
	searchVal["title"]=title
	for(i=0;i<multiple.length;i++){
		if(multiple.eq(i).val()!="" && multiple.eq(i).val()!=undefined){
			//alert(multiple.eq(i).attr("id"))
			searchVal[multiple.eq(i).attr("id")]=multiple.eq(i).val()
		}
	}
	if($("#allprice").data("value")<=0){
		searchVal["sprice"]=$("#sprice").val()
		searchVal["eprice"]=$("#eprice").val()
	}
	searchVal["type"]="multiple";
	$.ajax({
		url:"control/getprojects.php",
		type:"post",
		dataType:"html",
		data:searchVal,
		success:function(data){
			$(".w970").html(data)
			$(".go-page").click(function(){showList($(this).data("page"))})
		}
	})
}
function setPrice(){
	var sp=Number($("#sprice").val());
	var ep=Number($("#eprice").val());
	if(sp<0 || ep<0){
		$("#sprice").val(0)
		$("#eprice").val(0)
	}
	if(sp==0 && ep==0){
		$("#allprice").data("value",1)
	}else{
		$("#allprice").data("value",0)
	}
	if($(this).attr("id")=="sprice"){
		if(ep>=0 && sp>ep){
			$("#eprice").val(sp+1)
		}else{
			
		}	
	}else{
		if(ep>0 && sp>ep){
			$("#sprice").val(ep-1)
		}
	}
	showList(0)
}
//查找分类
function showclass(){
	var pdata={}
	pdata["type"]="showclass";
	var thisclass=$(this).data("name")
	$("#cond-"+thisclass).val("");
	if(thisclass=="firstclass"){
		pdata["classname"]="root";
	}else if(thisclass=="secondclass"){
		pdata["classname"]=$(".sel-firstclass .class-name .class-item").text();
	}else{
		pdata["classname"]=$(".sel-secondclass .class-name .class-item").text();
	}
	$.ajax({
		url:"control/getprojects.php",
		type:"post",
		dataType:"html",
		data:pdata,
		success:function(data){
			$(".sel-"+thisclass+" .class-name").html(data)
			$(".class-item").click(setClass)
			showList(0);
			//$(".go-page").click(function(){showList($(this).data("page"))})
		}
	})
}
//设置class
function setClass(){
	var thisClass=$(this).parent().prev().data("name")
	$(this).parent().html("<span class='class-item activ'>"+$(this).text()+"</span>");
	$("#cond-"+thisClass).val($(this).text());
	showList(0)
	
}