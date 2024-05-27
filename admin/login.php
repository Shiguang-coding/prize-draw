<?php 
include('../core.php');
C(require('../config.php'));
if (I('post.')) {
    if (I('post.user')==C('username') && I('post.pwd')==C('userpwd')) {
	    $_SESSION['islogin'] = C('username');
	    str_alert('','index.php'); 
	} else {
	    str_alert('账号密码错误'); 
	}
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台登录 -企业网站管理系统</title>
<meta content="企业网站管理系统后台登录"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="statics/base/css/metinfo.css">
<script type="text/javascript" src="statics/base/js/metinfo-min.js"></script>
</head>
<script type="text/javascript">
function check_main_login(){
	var name = $("input[name='user']");
	var pass = $("input[name='pwd']");
	var code = $("input[name='code']");
		if(name.val() == ''){
			alert('用户名不能为空');
			name.focus();
			return false;
		}
		if(pass.val() == ''){
			alert('密码不能为空');
			pass.focus();
			return false;
		}
		if(code.val() == ''){
			alert('验证码不能为空');
			pass.focus();
			return false;
		}
}
function pressCaptcha(obj){
    obj.value = obj.value.toUpperCase();
}
function metfocus(intext){
        intext.focus(function(){
		    $(this).addClass('metfocus');
		});
        intext.focusout(function(){
		    $(this).removeClass('metfocus');
		});
}
</script>
<style>
	html,body{  background:#fbfbfb;}
</style>
<body id="login">
<div class="login-min">
			<div class="login-left">
				<div style=" border-right:1px solid #fff; padding:0px 0px 20px;">
				<a href="#" style="font-size:0px;" target="_blank" title="phpci" class="img">
					<img src="statics/base/images/login-logo.png?a=1" alt="phpci" title="phpci" />
				</a>
				<p>打造具有营销价值的企业网站</p>
				 
				</div>
			</div>
			<div class="login-right">	
				<h1 class="login-title">管理员登录</h1>
				<div>
				<form method="post" action="?" name="main_login" onSubmit="return check_main_login()">
					<p><label>用户名</label><input type="text" class="text" name="user" value=""  /></p>
					<p><label>密码</label><input type="password" class="text" name="pwd" /></p>
										
										<p class="login-submit">
						<input type="submit" name="Submit" value="登录" />
						 
					</p>
				</form>
				</div>
			</div>
		<div class="clear"></div>
        
        <div style="text-align:center;"><a href="http://www.jocat.cn/" target="_blank">奇偶猫</a></div>
        
</div>
<?php V('footer')?>
<!--[if IE 6]>
<script src="images/js/IE6-png.js" type="text/javascript"></script>
<script type="text/javascript">DD_belatedPNG.fix('.bg,img');</script>
<![endif]-->
</body>
</html>
