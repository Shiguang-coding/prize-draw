<?php 
include('../core.php');
if (!S('islogin')) str_alert('尚未登录','login.php'); 
if ($_POST) {
	$d['award_id'] = (int)I('post.award_id');
	D('cjm',$d,array('id'=>(int)I('get.id'))); 
	str_alert('修改成功','cjm.php'); 
}

$order = D('cjm',array('id'=>I('get.id')),1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>生成抽奖码</title>
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
	<div class="position">简体中文： <a href="order.php">抽奖码号</a> > 修改抽奖码</div>
	<div class="return"><a href="javascript:;" onClick="location.href='javascript:history.go(-1)'">&lt;&lt;返回</a></div>
	</div>
	<div class="clear"></div>
	
<form  method="post" name="myform" action="?id=<?php echo I('get.id')?>">
<div class="v52fmbx_tbmax">
<div class="v52fmbx_tbbox">
<div class="v52fmbx">
		 
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>抽奖码：</dt>
			<dd>
				<input name="no" type="text" class="text nonull" disabled="disabled" value="<?php echo $order['no']?>">
			</dd>
		</dl>
		</div>
		
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>指定中奖：</dt>
			<dd>
				 <select name="award_id" class="w420">
                    	<option value="0" >选择指定奖品</option>
						<?php 
						 
						foreach (D('award',array('order'=>'id desc')) as $k=>$v) {
						 
						?>
                        <option value="<?php echo $v['id']?>" <?php echo $v['id']==$order['award_id'] ? 'selected' :''?>><?php echo $v['name']?></option>
						<?php }?>
 
                    </select>
					不指定则按照系统设置的抽奖概率抽奖
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
</body>
</html>