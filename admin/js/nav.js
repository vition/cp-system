$(function (){
	$(".a-nav-list").click(sel_nav);
	//alert($(".a-nav-list").data("pagename"))
})
function sel_nav(){
	var navList=$(".a-nav-list");
	var thisNavText=$(this).text();
	//alert(thisNavText)
	for(i=0;i<navList.length;i++){
		var navText=navList.eq(i).text();
		if(navText==thisNavText){
			navList.eq(i).addClass("a-active")
			pagename=$(this).data("pagename");
			if(pagename!=undefined){
				$('#page-iframe', parent.document).attr("src",pagename+".php");
			}
			//
		}else{
			navList.eq(i).removeClass("a-active")
		}
	}
}
