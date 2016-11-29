$(function(){
	$(".news-href").click(showNews)
	$(".close-ico").click(closeBox)
	$("#search-but").click(goSearch)
	autoSearch()
	$(".search-ico").mouseenter(showCondition)
	$(".condition-box").mouseenter(function(){$(this).css("display","block")});
	$(".condition-box").mouseleave(function(){$(this).css("display","none");$(".screen-item").children(".search-ico").css("background-position-y","7px");});
	$(".condition-search-div input").bind("input propertychange",function(){searchCondition()})
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
	if(condition=="price"){
		$(".condition-search-div").css("display","none")
		$(".condition-search-price").css("display","block")
	}else{
		$(".condition-search-div").css("display","block")
		$(".condition-search-price").css("display","none")
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
	}else{
		$("#cond-"+condition).val($(this).text());
		$('.condition-list').html("<span class='condition-item item-active'>"+nval+"</span>");
		$(".condition-item").click(selectItem)
		var condClass=$("#cond-class").val();
		var condPlatform=$("#cond-platform").val();
		var condPrice=$("#cond-price").val();
		var searchVal={}
		var multiple=$(".multiple");
		for(i=0;i<multiple.length;i++){
			if(multiple.eq(i).val()!=""){
				searchVal[multiple.eq(i).attr("id")]=multiple.eq(i).val()
			}
		}
		// if(condClass!=""){
			// searchVal["class"]=condClass;
		// }
		// if(condClass!=""){
			// searchVal["platform"]=condPlatform;
		// }
		// if(condClass!=""){
			// searchVal["price"]=condPrice;
		// }
		searchVal["type"]="multiple";
		$.ajax({
			url:"control/getprojects.php",
			type:"post",
			dataType:"html",
			data:searchVal,
			success:function(data){
				alert(data)
			}
		})
		
	}
	
	
	
}