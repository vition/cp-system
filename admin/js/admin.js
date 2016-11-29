$(function (){
	$("#login").click(login);
	$("#password").keydown(function(e){if(e.keyCode==13){login();}});
	$(".edit-psw").click(showEditPsw)
	$("#psw-box").mouseenter(function(){$(this).css("display","block")});
	$("#psw-box").mouseleave(function(){$(this).css("display","none")});
	$("#change-psw").click(changePsw);
	$("#edit-base").click(chagneBase)
	message()
})
function login(){
	if($("#username").val()!="" && $("#password").val()!=""){
		$.ajax({
			type:"post",
			url:"control/login.php",
			data:{username:$("#username").val(),psw:$("#password").val()},
			dataType:"html",
			success:function(data){
				if(data=="success"){
					window.location.href="../index.php";
				}else{
					alert("回去把账号和密码抄10遍再来！");
				}
				
			}
		});
	}else{
		alert("账户和密码不能为空");
	}
	
}
//打开修改密码框
function showEditPsw(){
	$("#psw-box").css("display","block")
}
//确认修改密码
function changePsw(){
	var oldpsw=$(".old-psw").val();
	var newpsw=$(".new-psw").val();
	$.ajax({
		url:"control/changepsw.php",
		type:"POST",
		data:{opsw:oldpsw,npsw:newpsw},
		dataType:"html",
		success:function(data){
			alert(data)
		}
	})
}
//修改基本信息
function chagneBase(){
	var baseInfo=$(".base-info");
	data={};
	for(i=0;i<baseInfo.length;i++){
		data[baseInfo.eq(i).data("option")]=baseInfo.eq(i).val()
	}
	$.ajax({
		url:"control/changebase.php",
		type:"POST",
		data:data,
		dataType:"html",
		success:function(data){
			alert(data)
		}
	})
}
//消息样式
function message(){
	var num=$(".inbox-ico a").text()
	if(num>0){
		$(".inbox-ico").css("background-image","url(images/inbox.gif)");
		$(".inbox-ico a").css("color","#FFB200");
	}
}