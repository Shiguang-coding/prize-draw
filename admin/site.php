<?php 
include('../core.php');
C(require('../config.php'));
if (!S('islogin')) str_alert('','login.php'); 
if (count(I('post.'))>0) {
	foreach (I('post.') as $k=>$v) { 
		$str[strtoupper($k)] = $v;
	}
	 
	$c['filepath'] = '../upload/';
	$c['file']     = 'bjt';
	$f = lib_upload($c);
	 
	if (!isset($f['error'])) $str[strtoupper('bjt')] = 'upload/'.$f['newname'];
	$c['file']     = 'bjyy';
	$f = lib_upload($c);
	if (!isset($f['error'])) $str[strtoupper('bjyy')] = 'upload/'.$f['newname'];
	$str = "<?php\nreturn ".var_export($str, true).";\n?>";
	if (write_file('../config.php',$str,'w+')) str_alert('设置成功');   
	str_alert('设置失败');     		
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>基本设置</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="statics/base/css/metinfo.css" />
<link rel="stylesheet" type="text/css" href="statics/base/css/newstyle.css" />
<script type="text/javascript">var basepath='statics/base/images';</script>
<script type="text/javascript" src="statics/base/js/metvar.js"></script>
<script type="text/javascript" src="statics/base/js/jQuery1.7.2.js"></script>
<script type="text/javascript" src="statics/base/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="statics/base/js/iframes.js"></script>
<script type="text/javascript" src="statics/base/js/cookie.js"></script>
<script charset="utf-8" src="statics/lib/kind/kindeditor-min.js"></script>
<script charset="utf-8" src="statics/lib/kind/lang/zh_CN.js"></script>
<script type="text/javascript">
/*ajax执行*/
var lang = 'cn';
 
var uid='';
var adminpwd='';
$(document).ready(function(){
	ifreme_methei();
});
</SCRIPT>
 
<!--[if lte IE 9]>
<SCRIPT language=JavaScript>  
function killErrors() {  
return true;  
}  
window.onerror = killErrors;  
</SCRIPT> 
<![endif]-->
<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="info"]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
			});
		</script>

</head>
<body>
<script type="text/javascript" src="statics/base/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="statics/base/js/uploadify/swfobject.js"></script>
<script type="text/javascript">
function metreturn(url){
	if(url){
		location.href=url;
	}else if($.browser.msie){
		history.go(-1);
	}else{
		history.go(-1);
	}
}
</script>
	<div class="metinfotop">
	<div class="position">简体中文 > 快捷导航 > 基本设置</div>
	</div>
	<div class="clear"></div>
	</div>
 
<div style="clear:both;"></div>
<form method="POST" name="myform" action="?act=ok" enctype="multipart/form-data">
<div class="v52fmbx_tbmax">
<div class="v52fmbx_tbbox">
<div class="v52fmbx">
	
	<div class="metsliding_box metsliding_box_1">
 
		
		 
 
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>系统名称：</dt>
			<dd>
				<input type="text" class="text" size="10" name="webname" value="<?php echo C('webname')?>" /><span class="tips"></span>
			</dd>
		</dl>
		</div>
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>后台账号：</dt>
			<dd>
				<input type="text" class="text" size="10" name="username" value="<?php echo C('username')?>" /><span class="tips"></span>
			</dd>
		</dl>
		</div>
		
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>后台密码：</dt>
			<dd>
				<input type="text" class="text" size="10" name="userpwd" value="<?php echo C('userpwd')?>" /><span class="tips"></span>
			</dd>
		</dl>
		</div>
		
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>背景图片：</dt>
			<dd>
				 
				<input type="file"  name="bjt" value="上传"/>   <?php if(C('bjt'))?><a href="../<?php echo C('bjt')?>" target="_blank">预览</a> 640px * 高不限
				<span class="tips"></span>
			</dd>
		</dl>
		</div>
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>背景音乐：</dt>
			<dd>
			    
				<input type="file"  name="bjyy" value="上传"/> <?php if(C('bjyy'))?><a href="../<?php echo C('bjyy')?>" target="_blank">下载</a><span class="tips">.mp3格式</span>
				 
			</dd>
		</dl>
		</div>
		 
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>虚拟抽奖人数：</dt>
			<dd>
				<input type="text" class="text" size="10" name="cjrs" value="<?php echo C('cjrs')?>" /> <span class="tips"> 抽奖人数=虚拟抽奖人数+中奖总记录数</span>
			</dd>
		</dl>
		</div>
		
	 
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>活动说明：</dt>
			<dd>
			<textarea name="info" cols="" style="width: 521px; height: 137px;" rows=""><?php echo C('info')?></textarea>
				 <span class="tips"></span>
			</dd>
		</dl>
		</div>
		
		 
	 
		
		
	</div>

	<div class="metsliding_box metsliding_box_2">
		
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
