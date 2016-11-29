$(function(){
	$(".show-pdf-button").click(conPdfBox)
	$(".comment-but").click(submitComment)
	$(".more-but").click(upComment)
	$("#create-feedback").click(createFeedback)
	$(".feedback-edit").click(editFeedback);
	$(".down-pdf").click(downPdf)
})
function conPdfBox(){
	var state=$(this).data("boxstate");
	var pdfName=$(this).data("pdfname");
	// alert(state)
	if(state==0){
		var src=$(".show-pdf iframe").attr("src");
		if(src==""){
			$(".show-pdf iframe").attr("src","pdf.php?filename="+pdfName);
		}
		$(".show-pdf").css("display","block");
		$(this).text("收起PDF窗口");
		$(this).data("boxstate",1);
		
	}else{
		$(".show-pdf").css("display","none");
		$(this).text("点击查看PDF");
		$(this).data("boxstate",0);
	}
}
function getComment(){
	$.ajax({
		url:"control/comment.php",
		type:"POST",
		dataType:"html",
		data:{type:"insert",pid:$("#pid").val(),content:$(".comment-content").val()},
		success:function(data){
			//alert(data);
			$(".comment-list ul:first-child").before(data);
		}
	})
}
function submitComment(){
	if($(".comment-content").val()==""){
		alert("评论内容不能为空");
		return;
	}
	$.ajax({
		url:"control/comment.php",
		type:"POST",
		dataType:"html",
		data:{type:"insert",pid:$("#pid").val(),content:$(".comment-content").val()},
		success:function(data){
			//alert(data);
			var ulList=$(".comment-list ul");
			if(ulList.length<=0){
				$(".comment-list").html(data);
			}else{
				$(".comment-list ul:first-child").before(data);
			}
			
		}
	})
}
function upComment(){
	var ulList=$(".comment-list ul");
	$.ajax({
		url:"control/comment.php",
		type:"POST",
		dataType:"html",
		data:{type:"last",pid:$("#pid").val(),limit:ulList.length},
		success:function(data){
			//alert(data);
			$(".comment-list ul:last-child").after(data);
		}
	})
}
//新建反馈
function createFeedback(){
	var content=$(".feedback-content").val();
	if(content!=""){
		$.ajax({
			url:"control/feedback.php",
			type:"POST",
			dataType:"html",
			data:{type:"create",pid:$("#pid").val(),contents:content},
			success:function(data){
				//alert(data)
				var ulList=$(".feedback-list ul");
				if(ulList.length<=0){
					$(".feedback-list").html(data);
				}else{
					$(".feedback-list ul:first-child").before(data);
				}
				$(".feedbcak-title").remove();
				$(".feedback-edit").click(editFeedback);
			}
		})
	}else{
		alert("内容不能为空");
	}
}
//编辑反馈
function editFeedback(){
	$(this).parent().prev().children().attr("contenteditable","true");
	$(this).parent().prev().children().css("border","1px solid #cccccc");
	$(this).after("<span class='updata-feedback br3 bg1 clw'>确认</span>")
	$(".updata-feedback").click(changeFeedback)
}
//修改反馈
function changeFeedback(){
	var fid=$(this).parent().parent().data("fid");
	var content=$(this).parent().prev().children().text();
	var pid=$("#pid").val();
	var thisele=this;
	$.ajax({
		url:"control/feedback.php",
		type:"POST",
		dataType:"JSON",
		data:{type:"update",pid:$("#pid").val(),fid:fid,content:content},
		success:function(data){
			if(data.state>0){
				//alert("success")
				var times=$(thisele).prev().prev().children().text();
				times=parseInt(times)+1;
				$(thisele).prev().prev().children().text(times);
				$(thisele).parent().parent().find(".feed-list-user").children("span:last").text("最后编辑："+data.time)
				$(".feed-list-con p").removeAttr("contenteditable");
				$(".feed-list-con p").css("border","none");
				$(".updata-feedback").removeAttr("contenteditable");
			}else{
				alert("error");
			}
			
		}
	})
}
//下载pdf
function downPdf(){
	var pdfname=$(this).data("pdfname")
	window.location.href="control/down.php?type=pdf&filename="+pdfname;
}