<?php 
include('../core.php');
if (!S('islogin')) str_alert('','login.php'); 
$award = D('award',array('order'=>'id'));
foreach($award as $k=>$v){
	D('award',array('rotate'=>$k+1),array('id'=>$v['id'])); 	
} 

if (I('get.act')=='del') {
    $id  = (int)I('get.id');
    $sql = D('award',array('id'=>$id),'-');  
	if ($sql) str_alert('成功','award.php'); 
	str_alert('失败');
}

if (I('get.act')=='delsome') {
    $id  = I('post.id');
    $sql = D('award',array('id'=>array('where_in',$id)),'-');
	if ($sql) str_alert('成功','award.php'); 
	str_alert('失败');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>奖项设置</title>
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

	<div class="position">简体中文 > 奖项设置</div>


	</div>
	<div class="clear"></div>

	</div>

<div class="v52fmbx_tbmax v52fmbx_tbmaxmt">
<div class="v52fmbx_tbbox">
<h3 class="v52fmbx_hr">
	<span class="formleft">
		<!--<a href="award_add.php" title="新增">+新增</a>-->
	</span>
	<span class="formright">
		
				<form method="post" action="?" >
				    <input type="text" class="text1" size="10" name="keyword" value="<?php echo I('keyword')?>" />
					<input type='submit' value='搜索' class="submit li-submit" />
				</form>
				
	</span>
</h3>


<table cellpadding="2" cellspacing="1" class="table">
			  <form name="myform" method="post" id="myform">
			 
              <tr>
                 
				<td width="50" class="list" style="padding:0px; text-align:center;">ID</td>
                <td class="list" width="100">奖项名称</td>
                <td class="list" width="80" >中奖概率</td>
				<td class="list" >奖品名称</td>
				<td class="list" width="80" >奖品数量</td>
				<!--<td class="list" >转动角度</td> -->
				<td width="10%" class="list" style="padding:0px; text-align:center;">操作</td>
              </tr>
			  <?php foreach(D('award',array('order'=>'id desc')) as $arr=>$row){?>
                            <tr class="mouse click">
				 
				 <td class="list-text"><?php echo $row['id']?></td>
                <td class="list-text"><?php echo $row['prize']?></td>
				<td class="list-text"><?php echo $row['v']?></td>
			    <td class="list-text alignleft"><?php echo $row['name']?></td>
				<td class="list-text"><?php echo $row['qty']?></td>
				 
				 
               
				<td class="list-text">
				<a href="award_edit.php?id=<?php echo $row['id']?>">编辑</a>
				<a href="javascript:;" onclick="{if(confirm('确定删除吗?')){window.location='?act=del&id=<?php echo $row['id']?>';return true;}return false;}" >删除</a>            
				</td>
              </tr>
			  <?php }?>
                      
              
                    
   	   
		  </form>	 
		 
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
