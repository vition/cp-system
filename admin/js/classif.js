$(function (){
	$(".ul-click").click(showSub)
	$(".edit-class").click(editClass)
	$(".close-ico").click(function(){$("#edit-class").css("display","none")})
	$("#edit-class-but").click(changeClass)
	$(".add-class").click(openAddBox)
	$(".add-class-box").mouseenter(function(){$(this).css("display","block")});
	$(".add-class-box").mouseleave(function(){$(this).css("display","none")});
	$("#add-class-button").click(addClassif);
	$("#del-class-but").click(delClassif)
})
function showSub(){
	sup=$(this).parent().text();
	nextli=$(this).parent().next("li");
	thisli=$(this).parent();
	var classif=$(this).parent().parent().data("class")
	var disState = nextli.css("display");
	if(disState=="none"){
		var randoms=GetRandomNum(1,999999);
		$.ajax({
			type:"post",
			url:"control/getclass.php",
			data:{superi:sup,type:"list",randomn:randoms,classif:classif},
			dataType:"html",
			success:function(data){
				if(data!=""){
					nextli.html(data);
					$(".ul-click"+randoms).click(showSub)
					$(".edit-class"+randoms).click(editClass)
					$(".add-class").click(openAddBox)
					nextli.css("display","block");
					thisli.children(".jico").addClass("minus-ico")
					thisli.children(".jico").removeClass("plus-ico")
				}
			}
		})
	}else{
		nextli.css("display","none");
		thisli.children(".jico").addClass("plus-ico")
		thisli.children(".jico").removeClass("minus-ico")
	}
	
	
}
function GetRandomNum(Min,Max){   
	var Range = Max - Min;   
	var Rand = Math.random();  // 
	return(Min + Math.round(Rand * Range));   
} 
function editClass(){
	$("#edit-class").css("display","block");
	a=$(this).parent().data("classid")
	var thisClass=$(this).parent().parent().data("class");
	$("#thisclass").val(thisClass);
	
	if(thisClass!="firstclass"){
		var prevClass=$(this).parent().parent().parent().parent().data("class");
		$("#prevclass").val(prevClass);
		//
	}else{
		$("#super-list").html("")
	}
	var cname=$(this).text();
	$.ajax({
		url:"control/getclass.php",
		type:"POST",
		data:{type:"super",classname:cname},
		dataType:"html",
		success:function(data){
			if(data!="root"){
				$("#super-list").html(data);
			}
		}
	})
	$("#class-input").val(cname)
	$("#class-id").val(a);
}
function changeClass(){
	var newclass=$("#class-input").val();
	var classid=$("#class-id").val();
	var newsuper=$("#super-list select").val();
	var thisClass=$("#thisclass").val();
	var prevClass=$("#prevclass").val();
	if(newsuper!=""){
		$.ajax({
			url:"control/editclass.php",
			type:"POST",
			data:{cname:newclass,csuper:newsuper,cid:classid,thisclass:thisClass,prevclass:prevClass},
			dataType:"html",
			success:function(data){
				//alert(data)
				window.location.reload()
			}
		})
	}else{
		alert("分类名称不能为空")
	}
	
}
function openAddBox(){
	thisoff=$(this).offset()
	$(".add-class-box").css("display","block");
	$(".add-class-box").css("left",thisoff.left+14+"px");
	$(".add-class-box").css("top",thisoff.top+14+"px");
	$(".sup-name").val($(this).prev().text());
	//alert($(this).parent().data("classid"))
}
function addClassif(){
	var supclassif=$(".sup-name").val();
	var newclassif=$(this).parent().prev().children().val();
	if(newclassif!=""){
		$.ajax({
			url:"control/getclass.php",
			type:"POST",
			data:{type:"add",supclass:supclassif,newclass:newclassif},
			dataType:"html",
			success:function(data){
				window.location.reload();
			}
		})
	}else{
		alert("分类名称不能为空")
	}
	
}
//删除分类
function delClassif(){
	var classId=$("#class-id").val();
	$.ajax({
		url:"control/getclass.php",
		type:"POST",
		data:{type:"del",id:classId},
		dataType:"html",
		success:function(data){
			window.location.reload();
		}
	})
}