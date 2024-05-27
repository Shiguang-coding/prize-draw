<?php 
include('../core.php');
if (!S('islogin')) str_alert('','login.php'); 
if (I('get.act')=='out') {
	S('islogin',NULL);
	str_alert('','login.php'); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpci企业网站管理系统</title>
<link href="favicon.ico" rel="shortcut icon" />
<link href="statics/base/css/metinfo_box.css" rel="stylesheet" />
<link href="statics/lib/asyncbox/skins/ZCMS/asyncbox.css" type="text/css" rel="stylesheet" />
</head>
<script type="text/javascript" src="statics/base/js/jQuery1.7.2.js"></script>
<script type="text/javascript" src="statics/base/js/cookie.js"></script>
<script type="text/javascript" src="statics/lib/asyncbox/AsyncBox.v1.4.5.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#kzqie").click(function(){
		var my = $(this);
		if(my.text()=='宽版'){
			$('#content,#top .topnbox').animate({ width: '99%'}, 80);
			$.ajax({url : '',type: "POST"});
			my.attr('title','切换到窄版');
			my.text('窄版');
			setTimeout("topwidth(100)",100);
		}else{
			$('#content,#top .topnbox').animate({ width: '1000px'}, 80);
			$.ajax({url : '',type: "POST"});
			my.attr('title','宽版');
			my.text('宽版');
			setTimeout("topwidth(100)",100);
		}
	});
});
$(function() {
    $("#cache").click( function () { 
	    if(confirm('确定清除吗?')){
			$.ajax({
				type: "post",
				cache: !1,
				url: "index.php/admin/home/clear",
				data: "",
				timeout: 1e4,
				error: function() {},
				success: function(e) {
					if (e>0) {
					    asyncbox.tips("清除成功",'success');
					} else {
					    asyncbox.tips('清除失败','error');
					}
				}
			})
		}
	});  
})
</script>


<style>
#content,#top .topnbox{ width:1000px;}
#top .floatr li a span{ behavior: url(statics/images/iepngfix.htc); }
</style>
<body id="indexid">
<div id="metcmsbox">
<div id="top"> 
	<div class="topnbox">
    <div class="floatr">
		<div class="top-r-box">
		<div class="top-right-boxr">
			<div class="top-r-t">
				<ol class="rnav">
					 
					<li class="list"><a target="_top" onclick="{if(confirm('确定退出吗?')){window.location='?act=out';return true;}return false;}" href="javascript:;" id="outhome" title="退出" class='tui'>退出</a></li>
					<li class="line">|</li>
					<li class="list"><a href="javascript:;" id="kzqie" title="切换到宽版">宽版</a></li>
                    

				</ol>
				<div class="clear"></div>
			</div>
		</div>
		<div></div>
		<div class="nav">
            <ul id="topnav">
                                <li id="metnav_1" class="list">
					<a href="javascript:;" id="nav_1" class="onnav" hidefocus="true">
					<span class="c1"></span>
					<p>快捷导航</p>
					</a>
				</li>

            </ul>
		</div>
		</div>
    </div>
    <div class="floatl">
	    <a href="" hidefocus="true" id="met_logo"><img src="statics/base/images/logoen.gif" alt="phpci企业网站管理系统" title="phpci企业网站管理系统" /></a>
	</div>
	</div>
</div>

<div id="content">
    <div class="floatl" id="metleft">
		<div class="floatl_box">
	    <div class="nav_list" id="leftnav">
			<div class="fast">
				<a target="_blank" href="../" id="qthome" title="网站首页">网站首页</a>
			</div>
                        <ul  id="ul_1">
										 
									<li ><a href="site.php" id="nav_1_49" target="main"  title="基本设置" hidefocus="true">基本设置</a></li>
			       					<li ><a href="award.php" id="nav_1_49" target="main"  title="奖项设置" hidefocus="true">奖项设置</a></li>
									<li ><a href="cjm.php" id="nav_1_49" target="main"  title="抽奖码号" hidefocus="true">抽奖码号</a></li>
			       					<li ><a href="lottory.php" id="nav_1_78" target="main"  title="抽奖记录" hidefocus="true">抽奖记录</a></li>	 
			       			</ul>
                        
             

	    </div>
		<div class="claer"></div>
	
		<div class="left_footer"><div class="left_footer_box"><a href="http://www.jocat.cn/" target="_blank">我要提建议</a></div></div>
		
		</div>
	</div>
    <div class="floatr" id="metright">
        <div class="iframe">
		    <div class="min"><iframe frameborder="0" id="main" name="main" src="site.php" scrolling="no"></iframe></div>
		</div>
    </div>
	<div class="clear"></div>
	</div>
</div>
<?php V('footer')?>
<script src="statics/base/js/metinfo.js" type="text/javascript"></script>
</body>
</html>
