$(function(){
	$(".news-href").click(showNews)
	$(".close-ico").click(closeBox)
	$(".wap-navlist").click(wapList)
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
function wapList(){
	
	if($(".navs ul").css("display")=="none"){
		var wapList=$(this).parent().offset();
		$(".navs ul").css({display:"block",top:wapList.top+40+"px"})
	}else{
		$(".navs ul").css({display:"none"})
	}
	
}
