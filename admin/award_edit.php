<?php 
include('../core.php');
if (!S('islogin')) str_alert('','login.php'); 
$id = (int)I('get.id');
$data = D('award',array('id'=>$id),1);  
if (count(I('post.'))>0) {
   // $d = I('post.');
    //$c['filepath'] = '../upload/';
	//$c['file']     = 'pic';
	//$f = lib_upload($c);
	//if (!isset($f['error'])) $d['pic'] = 'upload/'.$f['newname'];
    //D('award',$d,array('id'=>$id));  
	str_alert('成功','123.php'); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>添加友情链接</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="statics/base/css/metinfo.css" />
<link rel="stylesheet" type="text/css" href="statics/base/css/newstyle.css" />
<script type="text/javascript">var basepath='statics/base/images';</script>
<script type="text/javascript" src="statics/base/js/metvar.js"></script>
<script type="text/javascript" src="statics/base/js/jQuery1.7.2.js"></script>
<script type="text/javascript" src="statics/base/js/iframes.js"></script>
<script type="text/javascript" src="statics/base/js/cookie.js"></script>
<script charset="utf-8" src="statics/lib/kind/kindeditor-min.js"></script>
<script charset="utf-8" src="statics/lib/kind/lang/zh_CN.js"></script>
<script type="text/javascript">
var gettagspath="";
var upload_json="statics/lib/kind/php/upload_json.php";
var file_manager_json="statics/lib/kind/php/file_manager_json.php";

KindEditor.ready(function(K) {
    var editor = K.create('textarea[name="infox"]', {
		allowFileManager : true
	});
	var editor = K.editor({
		allowFileManager : true
	});
	K('#image').click(function() {
		editor.loadPlugin('image', function() {
			editor.plugin.imageDialog({
				imageUrl : K('#pic').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#pic').val(url);
						$("#img").attr("src",url);
						editor.hideDialog();
					}
			});
		});
	});
});

$(function(){
	$("#t3_0").click(function(){$("#link_pic").css("display","none");$("#link_pics").css("display","none")});
	$("#t3_1").click(function(){$("#link_pic").css("display","");$("#link_pics").css("display","")});
})
</script>
<script type="text/javascript">
$(document).ready(function(){
	ifreme_methei();
});
</script>
</head>
<body>
	<div class="metinfotop">
	<div class="position">简体中文：<a href="award.php">奖项设置</a> > 修改奖项</div>
	<div class="return"><a href="javascript:;" onClick="location.href='javascript:history.go(-1)'">&lt;&lt;返回</a></div>
	</div>
	<div class="clear"></div>
	
<form  method="post" name="myform" action="?id=<?php echo $id?>" enctype="multipart/form-data">
<div class="v52fmbx_tbmax">
<div class="v52fmbx_tbbox">
<div class="v52fmbx">
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>奖项名称：</dt>
			<dd>
				<input name="prize" type="text" class="text nonull" value="<?php echo $data['prize']?>">
			</dd>
		</dl>
		</div>
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>中奖概率：</dt>
			<dd>
				<input name="v" type="text" class="text nonull" value="<?php echo $data['v']?>">  例如  5   那么概率就是5%
			</dd>
		</dl>
		</div>
		
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>奖品名称：</dt>
			<dd>
				<input name="name" type="text" class="text nonull" value="<?php echo $data['name']?>">
			</dd>
		</dl>
		</div>  
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>数量：</dt>
			<dd>
				<input name="qty" type="text" class="text nonull" value="<?php echo $data['qty']?>"> 中奖后减，为0将不做抽奖
			</dd>
		</dl>
		</div>
	     
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>奖品图片：</dt>
			<dd>
			    <input type="file"  name="pic" value="上传"/>   <?php if($data['pic'])?><a href="../<?php echo $data['pic']?>" target="_blank">预览</a>
				     200px * 200px
			</dd>
		</dl>
		</div> 
		 
		
		
		<div class="v52fmbx_dlbox v52fmbx_mo">
			<dl>
				<dt></dt>
				<dd>
					<input type="submit"  value="保存" class="submit" onclick="return Smit($(this),'myform')" />
				</dd>
			</dl>
		</div>
	</div>
	
</div>
</div>
</div>      
</form>
<?php V('footer')?>
	
	
</body>
</html>