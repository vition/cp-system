pdata={};
pdata["type"]="search";
$(function (){
	$("#login").click(login);
	$("#password").keydown(function(e){if(e.keyCode==13){login();}});
	$(".edit-psw").click(showEditPsw)
	$("#psw-box").mouseenter(function(){$(this).css("display","block")});
	$("#psw-box").mouseleave(function(){$(this).css("display","none")});
	$("#change-psw").click(changePsw);
	$("#edit-base").click(chagneBase)
	$("#edit-level").click(chagneLevel)
	message()
	$(".inbox-ico a").click(function(){$("#inbox-box").css("display","block");showLIst(0,0)})
	$("#message-box").bind({mouseenter:function(){$(this).css("display","block")},mouseleave:function(){$(this).css("display","none");}})
})
function login(){
	if($("#username").val()!="" && $("#password").val()!=""){
		$.ajax({
			type:"post",
			url:"control/login.php",
			data:{username:$("#username").val(),psw:$("#password").val()},
			dataType:"html",
			success:function(data){
				//alert(data);
				if(data=="success"){
					window.location.href="../index.php";
				}else if(data=="error"){
					alert("回去把账号和密码抄10遍再来！");
				}else{
					window.location.href=data;
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
	data["type"]="base";
	data["data"]={};
	for(i=0;i<baseInfo.length;i++){
		data["data"][baseInfo.eq(i).data("option")]=baseInfo.eq(i).val()
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
//修改等级
function chagneLevel(){
	var levelInfo=$(".level-info");
	data={};
	data["type"]="level";
	data["data"]={};
	for(i=0;i<levelInfo.length;i++){
		data["data"][levelInfo.eq(i).data("level")]=levelInfo.eq(i).val()
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
	}else{
		$(".inbox-ico").css("background-image","url(images/inbox.png)");
		$(".inbox-ico a").css("color","#FFFFFF");
	}
}
//获取消息列表
function showLIst(row){
	pdata["row"]=row;
	var state=$("#read-state").val();
	pdata["state"]=state;
	$.ajax({
		type:"POST",
		url:"control/message.php",
		data:pdata,
		dataType:"html",
		success:function(data){
			$("#inbox-box").html(data)
			//$("#datalist table tr").bind({mouseenter:function(){$(this).find("a").css("color","#FFFFFF")},mouseleave:function(){$(this).find("a").css("color","#000000")}})
			$(".go-page").click(function(){showLIst($(this).data("page"))})
			$(".search-ico").click(search)
			$(".mes-list").click(showMes)
			$(".close_box").click(closeBox)
			
		}
	})
}
//查找读未读
function search(){
	if($(this).data("state")=="read"){
		$("#read-state").val(1);
	}else{
		$("#read-state").val(0);
	}
	showLIst(0)
}
//读取mes
function showMes(){
	pdata["type"]="showmes";
	pdata["id"]=$(this).data("id");
	$.ajax({
		url:"control/message.php",
		type:"POST",
		data:pdata,
		dataType:"html",
		success:function(data){
			$("#message-box").html(data)
			pdata["type"]="search";
			showLIst(0)
			setUnread();
			//
		}
	})
	$("#message-box").css("display","block");
}
function closeBox(){
	$("#inbox-box").css("display","none");
}
//处理消息显示
function setUnread(){
	var unread=$("#unread-num").val()
	$(".inbox-ico a").text(unread)
	message();
}