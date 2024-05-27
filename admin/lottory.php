<?php 
include('../core.php');
 
if (!S('islogin')) str_alert('','login.php'); 
if (I('get.act')=='del') {
    $id  = (int)I('get.id');
    D('lottory',array('id'=>$id),'-');  
	str_alert('成功','lottory.php'); 
}

if (I('get.act')=='delsome') {
    $id  = I('post.id');
    D('lottory',array('id'=>array('where_in',$id)),'-');
	str_alert('成功','lottory.php'); 
}

if (I('get.act')=='state') {
    $id  = (int)I('get.id');
    D('lottory',array('state'=>1),array('id'=>$id));  
	str_alert('核销成功','lottory.php'); 
}

 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>抽奖名单</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="statics/base/css/metinfo.css" />
<link rel="stylesheet" type="text/css" href="statics/base/css/newstyle.css" />
<script type="text/javascript">var basepath='statics/base/images';</script>
<script type="text/javascript" src="statics/base/js/metvar.js"></script>
<script type="text/javascript" src="statics/base/js/jQuery1.7.2.js"></script>
<script type="text/javascript" src="statics/base/js/iframes.js"></script>
<script type="text/javascript" src="statics/base/js/cookie.js"></script>
 

 
<script type="text/javascript">
/*ajax执行*/
var lang = 'cn';
var metimgurl='statics/base/images/';
var depth='../';
$(document).ready(function(){
	ifreme_methei();
});
</script>
<!--[if lte IE 9]>
<SCRIPT language=JavaScript>  
function killErrors() {  
return true;  
}  
window.onerror = killErrors;  
</SCRIPT> 
<![endif]-->

</head>
<body>

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

	<div class="position">简体中文 > 抽奖名单</div>


	</div>
	<div class="clear"></div>

	</div>

<div class="v52fmbx_tbmax v52fmbx_tbmaxmt">
<div class="v52fmbx_tbbox">
<h3 class="v52fmbx_hr">
	 
	<span class="formright">
		
				<form method="post" action="?" >
				    <input type="text" class="text1" size="10" name="keyword" value="<?php echo I('keyword')?>" />
					<input type='submit' value='搜索' class="submit li-submit" />
					<input type="button" value='导出' class="submit li-submit" onClick=window.location.href="lottory_xls.php" />
				</form>
				
	</span>
</h3>


<table cellpadding="2" cellspacing="1" class="table">
			  <form name="myform" method="post" id="myform">
			 
              <tr>
                <td width="40" class="list" style="padding:0px; text-align:center;">选择</td>
				<td width="50" class="list" style="padding:0px; text-align:center;">ID</td>
				 
				 
                <td class="list" width="80" >奖项</td>
				<td class="list" width="80" >抽奖码</td>
				 
				<td class="list" width="150">信息</td>
				 
				<td class="list" width="80" >状态</td>
				<td width="10%" class="list" style="padding:0px; text-align:center;">操作</td>
              </tr>
			  <?php 
              $w['order']      = 'id desc'; 
			  $w['_string']    = I('keyword')?' and (name like "%'.I('keyword').'%" or tel like "%'.I('keyword').'%" or award_name like "%'.I('keyword').'%")':'';  
			  $c['totalrows']  = D('lottory',$w,3);
			  $p               = lib_page($c); 
			  $w['limit1']     = $p['limit1']; 
			  $w['limit2']     = $p['limit2']; 
			  $l = D('lottory',$w);
			  foreach($l as $k=>$v) {
			  ?>
              <tr class="mouse click">
				<td class="list-text"><input name='id[]' type='checkbox' id="id" value='<?php echo $v['id']?>' /></td>
				<td class="list-text"><?php echo $v['id']?></td>
				 
				<td class="list-text"><?php echo $v['award_name']?></td>
				<td class="list-text"><?php echo $v['cjm']?></td>
				 
				<td class="list-text alignleft">
				姓名：<?php echo $v['name']?><br>
				手机：<?php echo $v['tel']?><br>
				寄送地址：<?php echo $v['address']?><br>
				抽奖时间：<?php echo $v['addtime']?>
				</td> 
				<td class="list-text"><?php echo $v['state']==1?'已核销':'未核销'?></td>
				<td class="list-text">
				<?php if($v['state']<1){?> 
				<a href="javascript:;" onclick="{if(confirm('确定核销吗?')){window.location='?act=state&id=<?php echo $v['id']?>';return true;}return false;}" >核销</a>
				<?php }?>
				<a href="javascript:;" onclick="{if(confirm('确定删除吗?')){window.location='?act=del&id=<?php echo $v['id']?>';return true;}return false;}" >删除</a>            
				</td>
              </tr>
			  <?php }?>           
   	   <tr> 
            <td class="all" width="40"><input name="chkAll" type="checkbox" id="chkAll" onclick=CheckAll(this.form) value="checkbox"></td>
			<td class="all-submit" colspan="6" align="left" style="padding:5px 10px;">
			<input type='submit' value='删除' class="submit li-submit" onclick="{if(confirm('确定删除吗?')){document.myform.action='?act=delsome';return true;}return false;}"/>
			
			</td>
          </tr>
		  </form>	 
		<tr>
		<td colspan="7" class="page_list">
		<form method='POST' action='?'>
		<style>.digg4 a{ border:1px solid #ccdbe4; padding:2px 8px 2px 8px; background:#fff; background-position:50%; margin:2px; color:#666; text-decoration:none;}
		.digg4 a:hover { border:1px solid #999; color:#fff; background-color:#999;}
		.digg4 a:active {border:1px solid #000099; color:#000000;}
		.digg4 span.current { padding:2px 8px 2px 8px; margin:2px; text-decoration:none;}
		.digg4 span.disabled { border:1px solid #ccc; background:#fff; padding:1px 8px 1px 8px; margin:2px; color:#999;}
       </style>
		<div class='digg4'>
		 <?php echo $p['show']?>
		 转到
		 <input name='<?php echo $p['varpage']?>' class='page_input' value="" />页 
		 <input type='submit' value=' go ' class="bnt_pinyin"/>
		 </form>
		</div>
		</td></tr> 
</table>
</div>
</div>
<?php V('footer')?>
<script type="text/javascript">
function safesq(){
	var vl = $("#deltype").val();
	var vp = $("option[value='"+vl+"']").text();
		vp = '确定清空'+vp+'？';
	return vp;
}
seachinput($('#searchtext'),'请输入网站标题关键字');
</script>
</body>
</html>
