<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8" />
<meta name="author" content="EdieLei" />
<title>HTML5 图片上传预览</title>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
$(function(){
$('#img').change(function(){
var file = this.files[0]; //选择上传的文件
var r = new FileReader();
r.readAsDataURL(file); //Base64
$(r).load(function(){
$('div').html('<img id="imgs" src="'+ this.result +'" alt="" />');
});
});

$("#updata").click(updata)
});
function updata(){
	var imgs=$("#imgs").attr("src")
	$.ajax({
		type:"post",
		url:"control/updataimg.php",
		data:{img:imgs},
		dataType:"html",
		success:function(data){
			alert(data)
		}
		
	})
}
</script>
</head>
<body>
<h3>HTML5 图片上传预览</h3>
<input id="img" type="file" accept="image/*" />
<input id="updata" type="button" value="上传"/>
<div></div>
</body>
</html>