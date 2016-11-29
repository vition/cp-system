$(function (){
	$(".upimg-input").change(previewImg);
	//imgs=new Object();
	$("#updata-imgs-button").click(uploadImg)
})
function previewImg(){
	file = this.files[0]; //选择上传的文件
	thisId=this.id;
	thisele=this;
	fileM=parseInt(file.size/1048576);
	if(fileM>=2){
		alert("文件不能大于2M")
		this.value="";
	}else{
		var r = new FileReader();
		r.readAsDataURL(file); //Base64
		$(r).load(function(){
			//$('#photo-preview').html('<img src="'+ this.result +'" alt="" />');
			//imgs[thisId]=this.result
			//alert();
			//$('#photo-preview').html(imgs.thisId)
			$(thisele).parent().prev().children().val(this.result)
		});
	}
}
function uploadImg(){
	var lis=$(".content ul li");
	data={};
	for(i=0;i<lis.length;i++){
		var title=lis.eq(i).children().children().next().children().val();
		var href=lis.eq(i).children().children().next().next().children().val();
		var imgsrc=lis.eq(i).children().next().children().children().val()
		adv={title:title,href:href,imgsrc:imgsrc};
		data[i]=adv;
	}
	
	//var imgs=$("#imgs").attr("src")
	$.ajax({
		type:"post",
		url:"control/updataimg.php",
		data:data,
		dataType:"html",
		success:function(data){
			//alert(data)
			a=data.split(",")
			for(i=0;i<a.length;i++){
				d=a[i].split(":");
				$("#imgurl-"+d[0]).val(d[1]);
			}
		}
	})
}